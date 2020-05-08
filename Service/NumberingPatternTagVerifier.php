<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Service;

use LSB\NumberingBundle\Exception\NumberingGeneratorException;
use LSB\NumberingBundle\Model\Tag;

/**
 * Class NumberingPatternTagVerifier
 * @package LSB\NumberingBundle\Service
 */
class NumberingPatternTagVerifier
{

    /**
     * @param array $patternConfig
     * @param array $counterConfig
     * @throws NumberingGeneratorException
     */
    static public function verify(array $patternConfig, array $counterConfig): void
    {
        // verify number tag
        preg_match_all(Tag::REG_EXPS[Tag::NUMBER], $patternConfig['pattern'], $matches);
        if (empty($matches[0])) {
            throw new NumberingGeneratorException(sprintf('No {%s} tag in pattern', Tag::NUMBER));
        }

        // TODO verify time and object context tag if necessary
    }


}
