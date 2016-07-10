<?php

namespace Wookieb\Conditions;

use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;

/**
 * Produces "yesterday" if diff between days is one calendar day.
 *
 * For example
 * 2015-02-01 01:00:00 compared to 2015-01-01 18:00:00 is "yesterday" despite 7 hours diff
 * 2015-02-01 23:00:00 compared to 2015-01-01 01:00:00 is also "yesterday" despite 46 hours difference
 *
 * @package Wookieb\Conditions
 */
class YesterdayCondition implements ConditionInterface
{
    const RESULT_NAME = 'yesterday';

    public function isApplicable(DateDiffRequest $diffRequest)
    {
        $yesterdayDate = \DateTimeImmutable::createFromFormat(
            'U',
            $diffRequest->getDate()->format('U'),
            $diffRequest->getDate()->getTimezone()
        )->sub(new \DateInterval('P1D'));

        return $yesterdayDate->format('Ymd') === $diffRequest->getBaseDate()->format('Ymd');
    }

    public function createResult(DateDiffRequest $diffRequest)
    {
        return new DateDiffResult(self::RESULT_NAME);
    }
}