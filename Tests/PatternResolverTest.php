<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Tests;


use LSB\NumberingBundle\Entity\NumberingCounterData;
use LSB\NumberingBundle\Service\NumberingPatternResolver;
use PHPUnit\Framework\TestCase;


/**
 * Class PatternResolverTest
 * @package LSB\NumberingBundle\Tests
 */
class PatternResolverTest extends TestCase
{
    const TEST_PATTERN = 'FV/{year}/{number}/{object}';

    public function testYearPatternResolver()
    {
        $randNumber = rand(1, 10);
        $currentYear = (new \DateTime)->format('Y');
        $testContextValue = 'TestContextValue';

        $testNumberingData = (new NumberingCounterData)
            ->setCurrent($randNumber)
            ->setContextObjectValue($testContextValue);

        $resolvedNumber = NumberingPatternResolver::resolve(self::TEST_PATTERN, $testNumberingData);

        $this->assertStringContainsString((string)$currentYear, $resolvedNumber);
        $this->assertStringContainsString((string)$randNumber, $resolvedNumber);
        $this->assertStringContainsString((string)$testContextValue, $resolvedNumber);
    }


}
