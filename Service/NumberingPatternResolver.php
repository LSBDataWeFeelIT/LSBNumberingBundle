<?php
declare(strict_types=1);

namespace LSB\NumberingBundle\Service;


use LSB\NumberingBundle\Entity\NumberingCounterData;
use LSB\NumberingBundle\Model\Tag;
use LSB\NumberingBundle\Model\TimeContext;

class NumberingPatternResolver
{

    /**
     * @param string $numberPatternString
     * @param NumberingCounterData $counterData
     * @param \DateTime|null $date
     * @return string
     * @throws \Exception
     */
    public function resolve(string $numberPatternString, NumberingCounterData $counterData, \DateTime $date = null): string
    {
        $resolvedString = $this->resolveNumberTag($numberPatternString, $counterData);
        $resolvedString = $this->resolveDateTags($resolvedString, $date);
        $resolvedString = $this->resolveContextObjectTag($resolvedString, $counterData);

        return $resolvedString;
    }

    /**
     * @param string $numberPatternString
     * @param NumberingCounterData $counterData
     * @return string
     * @throws \Exception
     */
    private function resolveNumberTag(string $numberPatternString, NumberingCounterData $counterData): string
    {
        $tag = Tag::NUMBER;
        $currentValue = $counterData->getCurrent();

        preg_match_all(Tag::REG_EXPS[$tag], $numberPatternString, $matches);

        if (!empty($matches[0])) {
            $countMatches = count($matches[0]);

            for ($i = 0; $i < $countMatches; $i++) {
                $replacement = $currentValue;

                // check for length modifier
                if (!empty($matches[1][$i])) {
                    $charsNumber = (int)str_replace('|', '', $matches[1][$i]);
                    $replacement = sprintf("%0{$charsNumber}d", $currentValue);
                }

                $numberPatternString = str_replace($matches[0][$i], $replacement, $numberPatternString);
            }
        }

        return $numberPatternString;
    }

    /**
     * @param string $numberPatternString
     * @param NumberingCounterData $counterData
     * @return string
     * @throws \Exception
     */
    private function resolveContextObjectTag(string $numberPatternString, NumberingCounterData $counterData): string
    {
        $tag = Tag::CONTEXT_OBJECT;
        $currentValue = $counterData->getContextObjectValue();

        preg_match_all(Tag::REG_EXPS[$tag], $numberPatternString, $matches);

        if (!empty($matches[0])) {
            $countMatches = count($matches[0]);
            for ($i = 0; $i < $countMatches; $i++) {
                $replacement = $currentValue;
                $numberPatternString = str_replace($matches[0][$i], $replacement, $numberPatternString);
            }
        }

        return $numberPatternString;
    }

    /**
     * @param string $numberPatternString
     * @param \DateTime|null $date
     * @return string
     * @throws \Exception
     */
    private function resolveDateTags(string $numberPatternString, ?\DateTime $date = null): string
    {
        foreach (Tag::DATE_TAGS as $tag) {
            $currentValue = TimeContext::getValueForTag($tag, $date);

            preg_match_all(Tag::REG_EXPS[$tag], $numberPatternString, $matches);
            if (!empty($matches[0])) {
                $countMatches = count($matches[0]);

                for ($i = 0; $i < $countMatches; $i++) {
                    $replacement = (string)$currentValue;

                    // check for length modifier
                    switch ($tag) {
                        case Tag::YEAR:
                            if (!empty($matches[1][$i])) {
                                $charsNumber = (int)str_replace('|', '', $matches[1][$i]);

                                if (in_array($charsNumber, Tag::LENGTHS[Tag::YEAR])) {
                                    $replacement = substr($replacement, -$charsNumber);
                                }
                            }
                            break;

                        case Tag::DAY:
                        case Tag::MONTH:
                            $replacement = sprintf("%02d", $currentValue);
                            break;
                    }

                    $numberPatternString = str_replace($matches[0][$i], $replacement, $numberPatternString);
                }
            }

        }


        return $numberPatternString;
    }


}
