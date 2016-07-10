<?php


namespace Wookieb\Conditions;


use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;

interface ConditionInterface
{
    /**
     * Returns true if current date interval satisfies condition rules
     *
     * @param DateDiffRequest $diffRequest
     * @return mixed
     */
    public function isApplicable(DateDiffRequest $diffRequest);

    /**
     * @param DateDiffRequest $diffRequest
     * @return DateDiffResult
     */
    public function createResult(DateDiffRequest $diffRequest);
}