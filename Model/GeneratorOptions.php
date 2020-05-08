<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Model;

/**
 * Class GeneratorOptions
 * @package LSB\NumberingBundle\Model
 */
class GeneratorOptions
{
    /**
     * @var string
     */
    protected $configName;

    /**
     * @var string|null
     */
    protected $contextObjectValue;

    /**
     * @var \DateTime|null
     */
    protected $date;

    /**
     * GeneratorOptions constructor.
     * @param string $configName
     */
    public function __construct(string $configName)
    {
        $this->setConfigName($configName);
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
     * @return GeneratorOptions
     */
    public function setConfigName(string $configName): GeneratorOptions
    {
        $this->configName = $configName;
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
     * @return GeneratorOptions
     */
    public function setContextObjectValue(?string $contextObjectValue): GeneratorOptions
    {
        $this->contextObjectValue = $contextObjectValue;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return GeneratorOptions
     */
    public function setDate(?\DateTime $date): GeneratorOptions
    {
        $this->date = $date;
        return $this;
    }

}
