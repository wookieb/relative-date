<?php

namespace Wookieb\RelativeDate\Tests\Calculators;

use Wookieb\RelativeDate\Calculators\TimeAgoCalculator;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\YesterdayRule;
use Wookieb\RelativeDate\Tests\AbstractTest;

class TimeAgoCalculatorTest extends AbstractTest
{
    private function createCase($date, $baseDate, $resultKey, $resultValue = null)
    {
        $date = new \DateTimeImmutable($date);
        $baseDate = new \DateTimeImmutable($baseDate);
        $request = new DateDiffRequest($date, $baseDate);
        return [$date, $baseDate, new DateDiffResult($request, $resultKey, $resultValue)];
    }

    private function secondsAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2016-01-01 00:00:10', Results::SECONDS_AGO, 10);
    }

    private function minutesAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2016-01-01 00:04:10', Results::MINUTES_AGO, 4);
    }

    private function hoursAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2016-01-01 10:04:10', Results::HOURS_AGO, 10);
    }

    private function daysAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2016-01-04 10:04:10', Results::DAYS_AGO, 3);
    }

    private function weeksAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2016-01-15 10:04:10', Results::WEEKS_AGO, 2);
    }

    private function monthsAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2016-03-04 10:04:10', Results::MONTHS_AGO, 2);
    }

    private function yearsAgoCase()
    {
        return $this->createCase('2016-01-01 00:00:00', '2017-03-02 10:04:10', Results::YEARS_AGO, 1);
    }

    private function yesterdayCase()
    {
        return $this->createCase('2016-01-01 23:00:00', '2016-01-02 01:04:10', YesterdayRule::RESULT_NAME);
    }

    public function fullCalculatorTestCases()
    {
        return [
            $this->secondsAgoCase(),
            $this->minutesAgoCase(),
            $this->hoursAgoCase(),
            $this->daysAgoCase(),
            $this->weeksAgoCase(),
            $this->monthsAgoCase(),
            $this->yearsAgoCase()
        ];
    }

    /**
     * @dataProvider fullCalculatorTestCases
     */
    public function testFullCalculator(\DateTimeInterface $date, \DateTimeInterface $baseDate, DateDiffResult $expectedResult)
    {
        $calculator = TimeAgoCalculator::full();
        $result = $calculator->compute($date, $baseDate);
        $this->assertEquals($expectedResult, $result);
    }

    public function upTo2WeeksCalculatorTestCases()
    {
        return [
            $this->secondsAgoCase(),
            $this->minutesAgoCase(),
            $this->hoursAgoCase(),
            $this->daysAgoCase(),
            'yesterday' => $this->yesterdayCase(),
            'a week' => $this->createCase('2016-01-01 00:00:00', '2016-01-08 00:00:00', Results::WEEKS_AGO, 1),
            'almost 2 weeks' => $this->createCase('2016-01-01 00:00:00', '2016-01-14 23:59:59', Results::WEEKS_AGO, 1),
            'more than 2 weeks' => $this->createCase('2016-01-01 00:00:00', '2016-01-15 00:00:00', DateDiffResult::FULL_DATE)
        ];
    }

    /**
     * @dataProvider upTo2WeeksCalculatorTestCases
     */
    public function testUpTo2WeeksCalculator(\DateTimeInterface $date, \DateTimeInterface $baseDate, DateDiffResult $expectedResult)
    {
        $calculator = TimeAgoCalculator::upTo2Weeks();
        $result = $calculator->compute($date, $baseDate);
        $this->assertEquals($expectedResult, $result);
    }


    public function upTo2DaysCalculatorTestCases()
    {
        return [
            $this->secondsAgoCase(),
            $this->minutesAgoCase(),
            $this->hoursAgoCase(),
            'yesterday' => $this->yesterdayCase(),
            'more than 2 days' => $this->createCase('2016-01-01 00:00:00', '2016-01-03 00:00:00', DateDiffResult::FULL_DATE)
        ];
    }

    /**
     * @dataProvider upTo2DaysCalculatorTestCases
     */
    public function testUpTo2DaysCalculator(\DateTimeInterface $date, \DateTimeInterface $baseDate, DateDiffResult $expectedResult)
    {
        $calculator = TimeAgoCalculator::upTo2Days();
        $result = $calculator->compute($date, $baseDate);
        $this->assertEquals($expectedResult, $result);
    }
}