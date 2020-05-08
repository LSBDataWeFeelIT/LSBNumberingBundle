<?php

namespace LSB\NumberingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LSB\NumberingBundle\Model\TimeContext;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class NumberingCounterData
 * @package LSB\NumberingBundle\Entity
 *
 * @ORM\Entity(repositoryClass="LSB\NumberingBundle\Repository\NumberingCounterDataRepository")
 * @ORM\Table(name="numbering_counter_data")
 */
class NumberingCounterData
{
    const DEFAULT_START = 1;
    const DEFAULT_STEP = 1;

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * Pattern name from configuration
     *
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(max=255)
     */
    protected $configName;

    /**
     * Initial value of the counter
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $start = self::DEFAULT_START;

    /**
     * Step of the counter
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $step = self::DEFAULT_STEP;


    /**
     * Current value of the counter
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $current = self::DEFAULT_START;


    /**
     * FQCN of the subject object
     *
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(max=255)
     */
    protected $subjectFQCN;

    /**
     * Time context type e.g. "year" or  "month", if specified, current value will be determined in that context
     * @see TimeContext
     *
     * @var string|null
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Length(max=30)
     */
    protected $timeContext;

    /**
     * Time context value e.g. 2019, if time context specified
     *
     * @var integer|null
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $timeContextValue;

    /**
     * FQCN of the context object
     *
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    protected $contextObjectFQCN;

    /**
     * Object context value
     *
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    protected $contextObjectValue;


    /**
     * NumberingCounterData constructor.
     */
    public function __construct()
    {
    }


    public function __clone()
    {
        if ($this->getId()) {
            $this->id = null;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return NumberingCounterData
     */
    public function setId(int $id): NumberingCounterData
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigName(): string
    {
        return $this->configName;
    }

    /**
     * @param string $configName
     * @return NumberingCounterData
     */
    public function setConfigName(string $configName): NumberingCounterData
    {
        $this->configName = $configName;
        return $this;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     * @return NumberingCounterData
     */
    public function setStart(int $start): NumberingCounterData
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return int
     */
    public function getStep(): int
    {
        return $this->step;
    }

    /**
     * @param int $step
     * @return NumberingCounterData
     */
    public function setStep(int $step): NumberingCounterData
    {
        $this->step = $step;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }

    /**
     * @param int $current
     * @return NumberingCounterData
     */
    public function setCurrent(int $current): NumberingCounterData
    {
        $this->current = $current;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubjectFQCN(): string
    {
        return $this->subjectFQCN;
    }

    /**
     * @param string $subjectFQCN
     * @return NumberingCounterData
     */
    public function setSubjectFQCN(string $subjectFQCN): NumberingCounterData
    {
        $this->subjectFQCN = $subjectFQCN;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeContext(): ?string
    {
        return $this->timeContext;
    }

    /**
     * @param string|null $timeContext
     * @return NumberingCounterData
     */
    public function setTimeContext(?string $timeContext): NumberingCounterData
    {
        $this->timeContext = $timeContext;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTimeContextValue(): ?int
    {
        return $this->timeContextValue;
    }

    /**
     * @param int|null $timeContextValue
     * @return NumberingCounterData
     */
    public function setTimeContextValue(?int $timeContextValue): NumberingCounterData
    {
        $this->timeContextValue = $timeContextValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContextObjectFQCN(): ?string
    {
        return $this->contextObjectFQCN;
    }

    /**
     * @param string|null $contextObjectFQCN
     * @return NumberingCounterData
     */
    public function setContextObjectFQCN(?string $contextObjectFQCN): NumberingCounterData
    {
        $this->contextObjectFQCN = $contextObjectFQCN;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContextObjectValue(): ?string
    {
        return $this->contextObjectValue;
    }

    /**
     * @param string|null $contextObjectValue
     * @return NumberingCounterData
     */
    public function setContextObjectValue(?string $contextObjectValue): NumberingCounterData
    {
        $this->contextObjectValue = $contextObjectValue;
        return $this;
    }


}
