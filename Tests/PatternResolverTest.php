<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Tests;

use LSB\NumberingBundle\Entity\NumberingCounterData;
use LSB\NumberingBundle\Service\NumberingPatternResolver;
use LSB\NumberingBundle\Model\Tag;
use PHPUnit\Framework\TestCase;

/**
 * Class PatternResolverTest
 * @package LSB\NumberingBundle\Tests
 */
class PatternResolverTest extends TestCase
{

    public function testPatternResolverContextObject()
    {
        $testPattern = 'IN/{' . Tag::YEAR . '}/{' . Tag::NUMBER . '}/{' . Tag::CONTEXT_OBJECT . '}';
        $randNumber = rand(1, 10);
        $testContextValue = 'TestContextValue';

        $numberingCounterDataMock = $this->createMock(NumberingCounterData::class);

        $numberingCounterDataMock->method('getCurrent')->willReturn($randNumber);
        $numberingCounterDataMock->method('getContextObjectValue')->willReturn($testContextValue);

        $numberingCounterDataMock->expects($this->once())->method('getCurrent');
        $numberingCounterDataMock->expects($this->once())->method('getContextObjectValue');

        $patternResolver = new NumberingPatternResolver();
        $resolvedNumber = $patternResolver->resolve($testPattern, $numberingCounterDataMock);

        $this->assertStringContainsString((string)$randNumber, $resolvedNumber);
        $this->assertStringContainsString((string)$testContextValue, $resolvedNumber);
    }

}
