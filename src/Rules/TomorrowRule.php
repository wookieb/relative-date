<?php

namespace Wookieb\RelativeDate\Rules;

use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

/**
 * Produces "tomorrow" if diff between days is one calendar day in the future
 *
 * For example
 * 2015-01-01 18:00:00 compared to 2015-01-02 01:00:00 is "tomorrow" despite 7 hours diff
 * 2015-01-01 01:00:00 compared to 2015-01-02 23:00:00 is also "tomorrow" despite 46 hours difference
 *
 */
class TomorrowRule implements RuleInterface
{
    const RESULT_NAME = 'tomorrow';

    public function isApplicable(DateDiffRequest $diffRequest)
    {
        $tomorrowDate = $diffRequest->getBaseDate()->add(new \DateInterval('P1D'));
        return $tomorrowDate->format('Ymd') === $diffRequest->getDate()->format('Ymd');
    }

    public function createResult(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::RESULT_NAME);
    }
}