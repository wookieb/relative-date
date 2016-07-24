<?php


namespace Wookieb\RelativeDate\Rules;


use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

interface RuleInterface
{
    /**
     * Returns true if current date interval satisfies condition rules
     *
     * @param DateDiffRequest $diffRequest
     * @return mixed
     */
    public function isApplicable(DateDiffRequest $diffRequest);

    /**
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public function createResult(DateDiffRequest $request);
}