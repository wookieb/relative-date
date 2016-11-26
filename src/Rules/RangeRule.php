<?php

namespace Wookieb\RelativeDate\Rules;


use Wookieb\RelativeDate\Rules\RuleInterface;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

/**
 * Produces the result created by $formatCallback only if the amount of seconds falls in a given range
 */
class RangeRule implements RuleInterface
{
    private $min;
    private $max;
    private $formatCallback;

    /**
     * RangeRule constructor.
     * @param int $min
     * @param int $max
     * @param callable $formatCallback
     */
    public function __construct($min, $max, $formatCallback)
    {
        $this->min = $min;
        $this->max = $max;
        if (!is_callable($formatCallback)) {
            throw new \InvalidArgumentException('Format callback must be callable');
        }
        $this->formatCallback = $formatCallback;
    }

    public function isApplicable(DateDiffRequest $diffRequest)
    {
        return $diffRequest->getDiffInSeconds() >= $this->min && $diffRequest->getDiffInSeconds() <= $this->max;
    }

    public function createResult(DateDiffRequest $request)
    {
        return call_user_func($this->formatCallback, $request);
    }

    /**
     * Flips min and max range and converts them to negative number;
     *
     * <code>
     * new RangeRule(10, 100, ...); // 10 <= x <= 100
     * RangeRule::createForNegativeValues(10, 100, ...); // -100 <= x <= -10
     * </code>
     *
     * @param $min
     * @param $max
     * @param $formatCallback
     * @return RangeRule
     */
    public static function createForNegativeValues($min, $max, $formatCallback)
    {
        return new self(-$max, -$min, $formatCallback);
    }
}