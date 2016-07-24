<?php

namespace Wookieb\RelativeDate\Tests\Rules\Formatters;


use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Tests\AbstractTest;

abstract class AbstractFormattersTest extends AbstractTest
{
    protected $request;

    protected function createFullDateResult(\DateTimeImmutable $currentDate)
    {
        return DateDiffResult::createFullDate(new DateDiffRequest($currentDate, $currentDate->modify('tomorrow')));
    }

    protected function makeResult($key, $value = null)
    {
        $this->request = $this->createRequestForSeconds(5);
        return new DateDiffResult($this->request, $key, $value);
    }

}