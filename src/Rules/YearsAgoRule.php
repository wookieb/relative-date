<?php

namespace Wookieb\RelativeDate\Rules;


use Wookieb\RelativeDate\DateDiffRequest;

/**
 * Produces "years ago" for date difference greater or equal than one calendar year
 *
 * @package Wookieb\RelativeDate\Rules
 */
class YearsAgoRule implements RuleInterface
{
    public function isApplicable(DateDiffRequest $diffRequest)
    {
        return !$diffRequest->getInterval()->invert && $diffRequest->getInterval()->y >= 1;
    }

    public function createResult(DateDiffRequest $request)
    {
        return Results::calculateYearsAgo($request);
    }

}