<?php

namespace LSB\NumberingBundle\Service;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use LSB\NumberingBundle\Entity\NumberingCounterData;
use LSB\NumberingBundle\Interfaces\NumberableInterface;
use LSB\NumberingBundle\Model\GeneratorOptions;
use LSB\NumberingBundle\Model\SimpleNumber;
use LSB\NumberingBundle\Model\TimeContext;

/**
 * Class NumberingGenerator
 * @package LSB\NumberingBundle\Service
 */
class NumberingGenerator
{

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * NumberingGenerator constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }

    /**
     * @param array $config
     */
    public function setConfiguration(array $config): void
    {
        $this->configuration = $config;
    }

    /**
     * @return array|null
     */
    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }


    /**
     * @param NumberableInterface $subject
     * @param GeneratorOptions $options
     * @return SimpleNumber
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function generateNumber(NumberableInterface $subject, GeneratorOptions $options): SimpleNumber
    {
        return $this->process($subject, $options);
    }

    /**
     * @param NumberableInterface $subject
     * @param GeneratorOptions $options
     * @return SimpleNumber
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \LSB\NumberingBundle\Exception\NumberingGeneratorException
     */
    protected function process(NumberableInterface $subject, GeneratorOptions $options): SimpleNumber
    {
        $increase = true;
        $subjectClassName = get_class($subject);
        $counterConfig = $this->getCounterConfig($options->getConfigName());
        $patternConfig = $this->getPatternForConfig($options->getConfigName());

        // verify pattern tags
        NumberingPatternTagVerifier::verify($patternConfig, $counterConfig);

        // get existing NumberingCounterData
        $counterData = $this->em->getRepository(NumberingCounterData::class)->getByConfigAndSubjectClass($counterConfig, $subjectClassName, $options->getContextObjectValue());

        // create new NumberingCounterData
        if (!$counterData instanceof NumberingCounterData) {
            $counterData = $this->createNewCounterData($subjectClassName, $counterConfig, $options->getContextObjectValue());
            $this->em->persist($counterData);
            $this->em->flush();
            $increase = false;
        }

        try {
            $this->em->getConnection()->setAutoCommit(false);
            $this->em->getConnection()->beginTransaction();
            $this->em->lock($counterData, LockMode::PESSIMISTIC_WRITE);

            // increase current number value
            if ($increase) {
                $this->increaseCounterValue($counterData, $options->getDate());
            }

            // resolve number from pattern
            $resolvedNumber = NumberingPatternResolver::resolve($patternConfig['pattern'], $counterData, $options->getDate());

            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->em->getConnection()->setAutoCommit(true);

            $number = new SimpleNumber($resolvedNumber, $counterData->getCurrent());

        } catch (\Exception $e) {
            $this->resetEntityManager();
            throw $e;
        }

        return $number;
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     */
    protected function resetEntityManager(): void
    {
        $this->em->getConnection()->rollback();
        $this->em->getConnection()->setAutoCommit(true);

        if (!$this->em->isOpen()) {
            $this->em = $this->doctrine->resetManager();
        }
    }

    /**
     * @param NumberingCounterData $counterData
     * @param \DateTime|null $date
     * @throws \Exception
     */
    protected function increaseCounterValue(NumberingCounterData $counterData, \DateTime $date = null): void
    {
        $currentValue = $counterData->getCurrent() ?? $counterData->getStart();
        $newValue = $currentValue + $counterData->getStep();

        if (!empty($counterData->getTimeContext())) {

            $timeContextValue = TimeContext::getValueForTag($counterData->getTimeContext(), $date);

            if ($timeContextValue !== $counterData->getTimeContextValue()) {
                // set start value and new time context value
                $newValue = $counterData->getStart();
                $counterData->setTimeContextValue($timeContextValue);
            }

        }

        $counterData->setCurrent($newValue);
    }

    /**
     * @param string $subjectClassName
     * @param array $config
     * @param string|null $contextObjectValue
     * @return NumberingCounterData
     * @throws \Exception
     */
    protected function createNewCounterData(string $subjectClassName, array $config, string $contextObjectValue = null): NumberingCounterData
    {
        $numberingCounterData = (new NumberingCounterData)
            ->setSubjectFQCN($subjectClassName)
            ->setConfigName($config['name'])
            ->setStart($config['start'])
            ->setCurrent($config['start'])
            ->setStep($config['step']);

        if (isset($config['time_context']) && !empty($config['time_context'])) {
            $numberingCounterData
                ->setTimeContext($config['time_context'])
                ->setTimeContextValue(TimeContext::getValueForTag($config['time_context']));
        }

        if (isset($config['context_object_fqcn']) && !empty($config['context_object_fqcn'])) {
            $numberingCounterData
                ->setContextObjectFQCN($config['context_object_fqcn'])
                ->setContextObjectValue($contextObjectValue);
        }

        return $numberingCounterData;
    }

    /**
     * @param string $configName
     * @return array
     * @throws \Exception
     */
    public function getPatternForConfig(string $configName): array
    {
        $patterns = $this->getConfiguration()['patterns'];

        $config = $this->getCounterConfig($configName);
        $patternName = $config['patternName'];

        $filteredPattern = array_filter($patterns, function ($elem) use ($patternName) {
            return $elem['name'] === $patternName;
        });

        if (empty($filteredPattern)) {
            throw new \Exception('No pattern name found, check bundle configuration');
        }

        return reset($filteredPattern);
    }

    /**
     * @param string $configName
     * @return array
     * @throws \Exception
     */
    public function getCounterConfig(string $configName): array
    {
        $configs = $this->getConfiguration()['counter_configs'];

        $filteredConfig = array_filter($configs, function ($elem) use ($configName) {
            return $elem['name'] === $configName;
        });

        if (empty($filteredConfig)) {
            throw new \Exception('No counter config found, check bundle configuration');
        }

        if (count($filteredConfig) > 1) {
            throw new \Exception('More than one counter config found, check bundle configuration');
        }

        return reset($filteredConfig);
    }
}
