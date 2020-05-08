<?php

namespace LSB\NumberingBundle\Repository;

use Doctrine\ORM\EntityRepository;
use LSB\NumberingBundle\Entity\NumberingCounterData;

/**
 * Class NumberingCounterDataRepository
 * @package LSB\NumberingBundle\Repository
 */
class NumberingCounterDataRepository extends EntityRepository
{

    /**
     * @param array $config
     * @param string $subjectClass
     * @param string|null $contextObjectValue
     * @return NumberingCounterData|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByConfigAndSubjectClass(array $config, string $subjectClass, string $contextObjectValue = null): ?NumberingCounterData
    {
        $qb = $this->createQueryBuilder('ncd')
            ->where('ncd.subjectFQCN = :subjectClass')
            ->andWhere('ncd.configName = :configName')
            ->setParameters([':subjectClass' => $subjectClass, ':configName' => $config['name']]);

        if (isset($config['time_context']) && !empty($config['time_context'])) {
            $qb
                ->andWhere('ncd.timeContext = :timeContext')
                ->setParameter(':timeContext', $config['time_context']);
        }

        if (isset($config['context_object_fqcn']) && !empty($config['context_object_fqcn'])) {
            $qb
                ->andWhere('ncd.contextObjectFQCN = :contextObjectFQCN')
                ->andWhere('ncd.contextObjectValue = :contextObjectValue')
                ->setParameter(':contextObjectFQCN', $config['context_object_fqcn'])
                ->setParameter(':contextObjectValue', $contextObjectValue);
        }


        return $qb->getQuery()->getOneOrNullResult();
    }


}
