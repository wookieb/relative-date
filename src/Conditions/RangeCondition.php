<?php

namespace Wookieb\Conditions;


use Wookieb\Conditions\ConditionInterface;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;

/**
 * Produces the result created by $formatCallback only if the amount of seconds falls in a given range
 *
 * @package Wookieb\Conditions
 */
class RangeCondition implements ConditionInterface
{
    private $min;
    private $max;
    private $formatCallback;

    /**
     * RangeCondition constructor.
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
     * new RangeCondition(10, 100, ...); // 10 <= x <= 100
     * RangeCondition::createForNegativeValues(10, 100, ...); // -100 <= x <= -10
     * </code>
     *
     * @param $min
     * @param $max
     * @param $formatCallback
     * @return RangeCondition
     */
    public static function createForNegativeValues($min, $max, $formatCallback)
    {
        return new self(-$max, -$min, $formatCallback);
    }
}