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
        if ($seconds < 0) {
            $interval->invert = true;
        }

        $baseDate = new \DateTimeImmutable('2015-01-01 00:00:00');
        return new DateDiffRequest($baseDate->add($interval), $baseDate);
    }
}