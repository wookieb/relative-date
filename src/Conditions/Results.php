<?php

namespace Wookieb\Conditions;


use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;

class Results
{
    const SECONDS_AGO = '[X] seconds ago';
    const MINUTES_AGO = '[X] minutes ago';
    const HOURS_AGO = '[X] hours ago';
    const DAYS_AGO = '[X] days ago';
    const WEEKS_AGO = '[X] weeks ago';
    const MONTHS_AGO = '[X] months ago';
    const YEARS_AGO = '[X] years ago';

    public static function calculateSecondsAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::SECONDS_AGO, $request->getInterval()->s);
    }

    public static function calculateMinutesAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::MINUTES_AGO, $request->getInterval()->i);
    }

    public static function calculateHoursAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::HOURS_AGO, $request->getInterval()->h);
    }

    public static function calculateDaysAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::DAYS_AGO, $request->getInterval()->m);
    }

    public static function calculateWeeksAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::WEEKS_AGO, floor($request->getInterval()->days / 7));
    }

    public static function calculateMonthsAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::MONTHS_AGO, $request->getInterval()->m);
    }

    public static function calculateYearsAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::YEARS_AGO, $request->getInterval()->y);
    }

    public static function createFulLDate(DateDiffRequest $request)
    {
        return DateDiffResult::createFullDate($request);
    }
}