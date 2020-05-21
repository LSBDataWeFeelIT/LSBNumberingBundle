<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Tests;

use LSB\NumberingBundle\Entity\NumberingCounterData;
use PHPUnit\Framework\TestCase;

/**
 * Class NumberingCounterDataTest
 * @package LSB\NumberingBundle\Tests
 */
class NumberingCounterDataTest extends TestCase
{

    public function testDefaultData()
    {
        $counterData = new NumberingCounterData();

        $this->assertEquals(NumberingCounterData::DEFAULT_START, $counterData->getStart());
        $this->assertEquals(NumberingCounterData::DEFAULT_STEP, $counterData->getStep());
        $this->assertEquals(NumberingCounterData::DEFAULT_START, $counterData->getCurrent());

        $this->assertNull($counterData->getId());
        $this->assertNull($counterData->getContextObjectValue());
        $this->assertNull($counterData->getConfigName());
        $this->assertNull($counterData->getTimeContextValue());
        $this->assertNull($counterData->getTimeContext());
        $this->assertNull($counterData->getContextObjectFQCN());
        $this->assertNull($counterData->getSubjectFQCN());
    }

    public function testFluentSetters()
    {
        $counterData = new NumberingCounterData();

        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setContextObjectValue(null));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setContextObjectFQCN(null));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setConfigName(null));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setTimeContext(null));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setTimeContextValue(null));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setSubjectFQCN(null));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setId(1));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setStart(NumberingCounterData::DEFAULT_START));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setStep(NumberingCounterData::DEFAULT_STEP));
        $this->assertInstanceOf(NumberingCounterData::class, $counterData->setCurrent(NumberingCounterData::DEFAULT_START));
    }

    public function testClone()
    {
        $counterData = new NumberingCounterData();
        $cloned = clone $counterData;

        $this->assertInstanceOf(NumberingCounterData::class, $cloned);
    }

}
