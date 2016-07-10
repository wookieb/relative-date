<?php

namespace Wookieb\Tests;

use \DateTime as D;
use Wookieb\DateDiffRequest;

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
    public function testProperDiffCalculations(\DateTimeInterface $date, \DateTimeInterface $baseDate, $expectedDiffInSeconds)
    {
        $request = new DateDiffRequest($date, $baseDate);
        $expectedInterval = $date->diff($baseDate);
        $this->assertEquals($expectedInterval, $request->getInterval());
        $this->assertSame($expectedDiffInSeconds, $request->getDiffInSeconds());
    }
}