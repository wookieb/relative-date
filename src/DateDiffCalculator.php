<?php

namespace Wookieb;


use Wookieb\Conditions\ConditionInterface;
use Wookieb\Conditions\Results;

class DateDiffCalculator
{
    /**
     * @var ConditionInterface[]
     */
    private $conditions;

    /**
     * @var callable
     */
    private $defaultResultCallback;

    public function __construct($conditions, $defaultResultCallback = [Results::class, 'fullDate'])
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