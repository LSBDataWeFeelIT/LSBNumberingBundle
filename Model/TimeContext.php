<?php

namespace LSB\NumberingBundle\Model;

/**
 * Class TimeContext
 * @package LSB\NumberingBundle\Model
 */
class TimeContext
{

    /**
     * Returns integer representation of time context for given date.
     * For example: 42nd day of the year, 2nd quater of the year etc.
     *
     * @param string $timeContext
     * @param \DateTime|null $date
     * @return int
     * @throws \Exception
     */
    public static function getValueForTag(string $timeContext, ?\DateTime $date = null): int
    {
        $date = $date ?? new \DateTime();

        switch ($timeContext) {
            case Tag::YEAR:
                $res = (int)$date->format('Y');
                break;
            case Tag::SEMESTER:
                $res = (int)ceil($date->format('n') / 6);
                break;
            case Tag::QUARTER:
                $res = (int)ceil($date->format('n') / 3);
                break;
            case Tag::MONTH:
                $res = (int)$date->format('m');
                break;
            case Tag::WEEK:
                $res = (int)$date->format('W');
                break;
            case Tag::DAY:
                $res = $date->format('z');
                break;
            default:
                throw new \InvalidArgumentException('Time context tag not allowed');
                break;
        }

        return $res;
    }


}
