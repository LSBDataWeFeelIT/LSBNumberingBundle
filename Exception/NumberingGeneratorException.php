<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Exception;

/**
 * Class NumberingGeneratorException
 */
class NumberingGeneratorException extends \Exception
{
    /**
     * NumberingGeneratorException constructor.
     * @param $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
