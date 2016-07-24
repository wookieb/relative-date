<?php

namespace Wookieb\RelativeDate;


use Wookieb\RelativeDate\Rules\RuleInterface;
use Wookieb\RelativeDate\Rules\Results;

class DateDiffCalculator
{
    /**
     * @var RuleInterface[]
     */
    private $conditions;

    /**
     * @var callable
     */
    private $defaultResultCallback;

    /**
     * DateDiffCalculator constructor.
     * @param RuleInterface[] $conditions
     * @param callable $defaultResultCallback
     */
    public function __construct($conditions, $defaultResultCallback = [Results::class, 'createFullDate'])
    {
        $this->conditions = $conditions;
        $this->defaultResultCallback = $defaultResultCallback;
    }

    public function compute(\DateTimeInterface $date, \DateTimeInterface $baseDate = null)
    {
        $baseDate = $baseDate ?: new \DateTimeImmutable();

        $diffRequest = new DateDiffRequest($date, $baseDate);
        foreach ($this->conditions as $condition) {
            if ($condition->isApplicable($diffRequest)) {
                return $condition->createResult($diffRequest);
            }
        }
        return call_user_func($this->defaultResultCallback, $diffRequest);
    }
}