<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Tests;

use LSB\NumberingBundle\Exception\NumberingGeneratorException;
use LSB\NumberingBundle\Service\NumberingPatternTagVerifier;
use PHPUnit\Framework\TestCase;


/**
 * Class TagVerifierTest
 * @package LSB\NumberingBundle\Tests
 */
class TagVerifierTest extends TestCase
{

    public function testTagVerifierException()
    {
        $testPattern = 'IN/{year}';
        $patternConfig = ['pattern' => $testPattern];
        $counterConfig = [];

        $this->expectException(NumberingGeneratorException::class);

        $verifier = new NumberingPatternTagVerifier();
        $verifier->verify($patternConfig, $counterConfig);
    }
}
