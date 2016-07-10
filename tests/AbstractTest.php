<?php

namespace Wookieb\Tests;


use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    protected function assertDateDiffResult($key, $value, DateDiffResult $currentResult)
    {
        $this->assertSame($key, $currentResult->getKey(), 'Invalid result key');
        $this->assertSame($value, $currentResult->getValue(), 'Invalid result value');
    }

    protected function createRequestForSeconds($seconds)
    {
        $interval = new \DateInterval('PT'.abs($seconds).'S');
        $date = new \DateTimeImmutable('2015-01-01 00:00:00');
        if ($seconds < 0) {
            $baseDate = $date->add($interval);
        } else {
            $baseDate = $date->sub($interval);
        }
        return new DateDiffRequest($date, $baseDate);
    }
}