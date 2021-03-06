<?php

namespace Wookieb\RelativeDate\Rules;


use Wookieb\RelativeDate\DateDiffRequest;

/**
 * Produces "weeks ago" for date difference greater or equal than 7 days to the past but less than one calendar month.
 */
class WeeksAgoRule implements RuleInterface
{
    public function isApplicable(DateDiffRequest $diffRequest)
    {
        $i = $diffRequest->getInterval();
        return !$i->invert && $i->d >= 7;
    }

    public function createResult(DateDiffRequest $request)
    {
        return Results::calculateWeeksAgo($request);
    }
}