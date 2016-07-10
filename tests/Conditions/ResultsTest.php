<?php

namespace Wookieb\Tests\Conditions;


use Wookieb\Conditions\Results;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;
use Wookieb\Tests\AbstractTest;
use Wookieb\DateUnits as Unit;
use \DateTimeImmutable as D;

class ResultsTest extends AbstractTest
{
    public function secondsAgoTestCases()
    {
        return [
            [$this->createRequestForSeconds(5), 5],
            [$this->createRequestForSeconds(100), 100],
        ];
    }

    /**
     * @dataProvider secondsAgoTestCases
     */
    public function testCalculateSecondsAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::SECONDS_AGO, $expectedValue, Results::calculateSecondsAgo($request));
    }

    public function minutesAgoTestCases()
    {
        return [
            [$this->createRequestForSeconds(0), 0],
            [$this->createRequestForSeconds(Unit::MINUTE * 10), 10],
            [$this->createRequestForSeconds(Unit::MINUTE * 200), 200],
        ];
    }

    /**
     * @dataProvider minutesAgoTestCases
     */
    public function testCalculateMinutesAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::MINUTES_AGO, $expectedValue, Results::calculateMinutesAgo($request));
    }

    public function hoursAgoTestCases()
    {
        return [
            [$this->createRequestForSeconds(0), 0],
            [$this->createRequestForSeconds(Unit::HOUR * 10), 10],
            [$this->createRequestForSeconds(Unit::HOUR * 200), 200],
        ];
    }

    /**
     * @dataProvider hoursAgoTestCases
     */
    public function testCalculateHoursAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::HOURS_AGO, $expectedValue, Results::calculateHoursAgo($request));
    }


    public function daysAgoTestCases()
    {
        return [
            [$this->createRequestForSeconds(0), 0],
            [$this->createRequestForSeconds(Unit::DAY * 10), 10],
            [$this->createRequestForSeconds(Unit::DAY * 200), 200],
        ];
    }

    /**
     * @dataProvider daysAgoTestCases
     */
    public function testCalculateDaysAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::DAYS_AGO, $expectedValue, Results::calculateDaysAgo($request));
    }

    public function weeksAgoTestCases()
    {
        return [
            [$this->createRequestForSeconds(0), 0],
            [$this->createRequestForSeconds(Unit::WEEK * 10), 10],
            [$this->createRequestForSeconds(Unit::WEEK * 200), 200],
        ];
    }

    /**
     * @dataProvider weeksAgoTestCases
     */
    public function testCalculateWeeksAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::WEEKS_AGO, $expectedValue, Results::calculateWeeksAgo($request));
    }

    public function monthsAgoTestCases()
    {
        return [
            [new DateDiffRequest(new D('2015-01-01'), new D('2015-01-01')), 0],
            [new DateDiffRequest(new D('2015-01-01'), new D('2015-02-01')), 1],
            [new DateDiffRequest(new D('2015-01-01'), new D('2015-10-05')), 9],
        ];
    }

    /**
     * @dataProvider monthsAgoTestCases
     */
    public function testCalculateMonthsAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::MONTHS_AGO, $expectedValue, Results::calculateMonthsAgo($request));
    }

    public function yearsAgoTestCases()
    {
        return [
            [new DateDiffRequest(new D('2015-01-01'), new D('2015-01-01')), 0],
            [new DateDiffRequest(new D('2015-01-01'), new D('2016-02-01')), 1],
            [new DateDiffRequest(new D('2015-01-01'), new D('2020-10-05')), 5],
        ];
    }

    /**
     * @dataProvider yearsAgoTestCases
     */
    public function testCalculateYearsAgo(DateDiffRequest $request, $expectedValue)
    {
        $this->assertDateDiffResult(Results::YEARS_AGO, $expectedValue, Results::calculateYearsAgo($request));
    }

    public function testCreateFullDate()
    {
        $this->assertDateDiffResult(DateDiffResult::FULL_DATE,null, Results::createFullDate($this->createRequestForSeconds(10)));
        $this->assertDateDiffResult(DateDiffResult::FULL_DATE,null, Results::createFullDate($this->createRequestForSeconds(1000)));
    }
}