<?php

namespace Wookieb\RelativeDate\Rules;

use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

/**
 * Produces "yesterday" if diff is one calendar day to the past
 *
 * For example
 * 2015-01-02 01:00:00 compared to 2015-01-01 18:00:00 is "yesterday" despite 7 hours diff
 * 2015-01-02 23:00:00 compared to 2015-01-01 01:00:00 is also "yesterday" despite 46 hours difference
 *
 */
class YesterdayRule implements RuleInterface
{
    const RESULT_NAME = 'yesterday';

    public function isApplicable(DateDiffRequest $diffRequest)
    {
        $yesterdayDate = $diffRequest->getBaseDate()->sub(new \DateInterval('P1D'));
        return $yesterdayDate->format('Ymd') === $diffRequest->getDate()->format('Ymd');
    }

    public function createResult(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::RESULT_NAME);
    }
}