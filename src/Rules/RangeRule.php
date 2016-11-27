<?php

namespace Wookieb\RelativeDate\Rules;


use Wookieb\RelativeDate\Rules\RuleInterface;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

/**
 * Produces the result created by $resultCallback only if the amount of seconds falls in a given range
 */
class RangeRule implements RuleInterface
{
    private $min;
    private $max;
    private $resultCallback;

    /**
     * RangeRule constructor.
     * @param int $min
     * @param int $max
     * @param callable $resultCallback
     */
    public function __construct($min, $max, $resultCallback)
    {
        $this->min = $min;
        $this->max = $max;
        if (!is_callable($resultCallback)) {
            throw new \InvalidArgumentException('Result callback must be callable');
        }
        $this->resultCallback = $resultCallback;
    }

    public function isApplicable(DateDiffRequest $diffRequest)
    {
        return $diffRequest->getDiffInSeconds() >= $this->min && $diffRequest->getDiffInSeconds() <= $this->max;
    }

    public function createResult(DateDiffRequest $request)
    {
        return call_user_func($this->resultCallback, $request);
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
     * @param $resultCallback
     * @return RangeRule
     */
    public static function createForNegativeValues($min, $max, $resultCallback)
    {
        return new self(-$max, -$min, $resultCallback);
    }
}