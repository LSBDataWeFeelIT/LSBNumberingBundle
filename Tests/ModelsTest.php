<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Tests;

use LSB\NumberingBundle\Exception\NumberingGeneratorException;
use LSB\NumberingBundle\Model\GeneratorOptions;
use LSB\NumberingBundle\Model\SimpleNumber;
use LSB\NumberingBundle\Model\TimeContext;
use LSB\NumberingBundle\Service\NumberingPatternTagVerifier;
use PHPUnit\Framework\TestCase;


/**
 * Class ModelsTest
 * @package LSB\NumberingBundle\Tests
 */
class ModelsTest extends TestCase
{

    public function testTimeContextException()
    {
        $this->expectException(\InvalidArgumentException::class);

        TimeContext::getValueForTag('invalidTag', new \DateTime());
    }

    public function testSimpleNumber()
    {
        $number = 'testNumber10';
        $value = 10;
        $simpleNumber = new SimpleNumber($number, $value);

        $this->assertSame($number, $simpleNumber->getNumber());
        $this->assertSame($number, (string)$simpleNumber);
        $this->assertSame($value, $simpleNumber->getValue());
    }

    public function testGeneratorOptions()
    {
        $configName = 'configName';
        $options = new GeneratorOptions($configName);

        $this->assertSame($configName, $options->getConfigName());
        $this->assertNull($options->getContextObjectValue());
        $this->assertNull($options->getDate());

        $this->assertInstanceOf(GeneratorOptions::class, $options->setContextObjectValue(null));
        $this->assertInstanceOf(GeneratorOptions::class, $options->setDate(null));
        $this->assertInstanceOf(GeneratorOptions::class, $options->setConfigName($configName));
    }
}
