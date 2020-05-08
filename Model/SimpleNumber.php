<?php

namespace LSB\NumberingBundle\Model;

/**
 * Class SimpleNumber
 * @package LSB\NumberingBundle\Model
 */
class SimpleNumber
{

    /**
     * @var string
     */
    protected $number;

    /**
     * @var integer
     */
    protected $value;

    /**
     * SimpleNumber constructor.
     * @param string $number
     * @param int $value
     */
    public function __construct(string $number, int $value)
    {
        $this->number = $number;
        $this->value = $value;
    }


    /**
     * Returns number as a string eg. FV/2019/0023
     *
     * @return string
     */
    public function getNumber(): string
    {

        return $this->number;
    }

    /**
     * Returns a value of a number eg. 23
     *
     * @return integer
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNumber();
    }

}
