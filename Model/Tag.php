<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Model;

/**
 * Class Tag
 * @package LSB\NumberingBundle\Model
 */
class Tag
{
    /** @var string */
    const NUMBER = 'number';

    /** @var string */
    const YEAR = 'year';

    /** @var string */
    const SEMESTER = 'semester';

    /** @var string */
    const QUARTER = 'quarter';

    /** @var string */
    const MONTH = 'month';

    /** @var string */
    const WEEK = 'week';

    /** @var string */
    const DAY = 'day';

    /** @var string  */
    const CONTEXT_OBJECT = 'context_object';


    /** @var array */
    const REG_EXPS = [
        self::NUMBER => '/{number(\|\d+)?}/',
        self::YEAR => '/{year(\|\d+)?}/',
        self::SEMESTER => '/{semester}/',
        self::QUARTER => '/{quarter}/',
        self::MONTH => '/{month}/',
        self::WEEK => '/{week}/',
        self::DAY => '/{day}/',
        self::CONTEXT_OBJECT => '/{context_object}/'
    ];

    /** @var array */
    const LENGTHS = [
        self::NUMBER => null, // all lengths allowed
        self::YEAR => [2, 4]
    ];

    /** @var array */
    const DATE_TAGS = [
        self::YEAR,
        self::SEMESTER,
        self::QUARTER,
        self::MONTH,
        self::WEEK,
        self::DAY
    ];


}
