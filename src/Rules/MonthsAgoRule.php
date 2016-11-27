<?php

namespace Wookieb\RelativeDate\Rules;

use Wookieb\RelativeDate\DateDiffRequest;

/**
 * Produces "months ago" for date difference if greater or equal than one calendar month to the past but less than one calendar year.
 */
class MonthsAgoRule implements RuleInterface
{
    public function isApplicable(DateDiffRequest $diffRequest)
    {
        return $diffRequest->getCalendarMonths() < 0;
    }

    public function createResult(DateDiffRequest $request)
    {
        return Results::calculateMonthsAgo($request);
    }
}