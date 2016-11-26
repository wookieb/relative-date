<?php

namespace Wookieb\RelativeDate\Tests;

use \DateTime as D;
use \DateTimeInterface as DI;
use Wookieb\RelativeDate\DateDiffRequest;

class DateDiffRequestTest extends \PHPUnit_Framework_TestCase
{
    public function cases()
    {
        return [
            [new D('2016-01-01 15:00:00'), new D('2016-01-01 16:00:00'), -3600],
            [new D('2016-01-01 16:00:00'), new D('2016-01-01 15:00:00'), 3600],
            [new D('2016-02-01 00:00:00'), new D('2016-01-01 01:00:00'), 60 * 60 * 24 * 31 - 3600]
        ];
    }

    /**
     * @dataProvider cases
     */
    public function testCalculatesDiffInSeconds(DI $date, DI $baseDate, $expectedDiffInSeconds)
    {
        $request = new DateDiffRequest($date, $baseDate);
        $this->assertSame($expectedDiffInSeconds, $request->getDiffInSeconds());
    }

    public function calendarMonthsCases()
    {
        return [
            [new D('2015-01-01 00:00:00'), new D('2015-02-01 00:00:00'), -1],
            [new D('2015-01-01 00:00:00'), new D('2016-02-01 00:00:00'), -13],
            [new D('2015-02-01 00:00:00'), new D('2015-01-01 00:00:00'), 1],
            [new D('2016-02-01 00:00:00'), new D('2015-01-01 00:00:00'), 13],
            [new D('2015-01-15 00:00:00'), new D('2015-02-01 00:00:00'), 0],
            [new D('2015-01-15 00:00:00'), new D('2016-02-01 00:00:00'), -12],
            [new D('2015-01-01 00:00:00'), new D('2015-02-15 00:00:00'), -1],
            [new D('2016-01-01 00:00:00'), new D('2015-02-15 00:00:00'), 10],
            [new D('2015-02-15 00:00:00'), new D('2015-01-01 00:00:00'), 1],
            [new D('2016-02-15 00:00:00'), new D('2015-01-01 00:00:00'), 13],
            [new D('2015-02-01 00:00:00'), new D('2015-01-15 00:00:00'), 0],
            [new D('2016-02-01 00:00:00'), new D('2015-01-15 00:00:00'), 12],
            [new D('2016-01-01 00:00:00'), new D('2015-12-01 00:00:00'), 1],
            [new D('2016-01-01 00:00:00'), new D('2015-12-15 00:00:00'), 0],
            [new D('2016-01-15 00:00:00'), new D('2015-12-01 00:00:00'), 1],
            [new D('2015-12-01 00:00:00'), new D('2016-01-01 00:00:00'), -1],
            [new D('2015-12-15 00:00:00'), new D('2016-01-01 00:00:00'), 0],
            [new D('2015-12-01 00:00:00'), new D('2016-01-15 00:00:00'), -1],
            [new D('2010-12-01 00:00:00'), new D('2016-01-01 00:00:00'), -5 * 12 - 1],
        ];
    }

    /**
     * @dataProvider calendarMonthsCases
     */
    public function testCalculatesDiffInCalendarMonths(DI $date, DI $baseDate, $expectedCalendarMonths)
    {
        $request = new DateDiffRequest($date, $baseDate);
        $this->assertSame($expectedCalendarMonths, $request->getCalendarMonths());
    }

    public function testConvertsDatesToImmutableVersion()
    {
        $baseDate = \DateTime::createFromFormat('U', 12345);
        $date = \DateTime::createFromFormat('U', 12345678);
        $request = new DateDiffRequest($date, $baseDate);

        $this->assertInstanceOf(\DateTimeImmutable::class, $request->getBaseDate());
        $this->assertSame($baseDate->getTimestamp(), $request->getBaseDate()->getTimestamp());
        $this->assertEquals($baseDate->getTimezone(), $request->getBaseDate()->getTimezone());

        $this->assertInstanceOf(\DateTimeImmutable::class, $request->getDate());
        $this->assertSame($date->getTimestamp(), $request->getDate()->getTimestamp());
        $this->assertEquals($date->getTimezone(), $request->getDate()->getTimezone());
    }
}
