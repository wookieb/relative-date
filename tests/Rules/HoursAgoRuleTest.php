<?php

namespace Wookieb\RelativeDate\Tests\Rules;


use Wookieb\RelativeDate\DateUnits;
use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;

class HoursAgoRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::hoursAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequestForSeconds(-3599), null),
            $this->createCase($this->createRequestForSeconds(-3600), Results::HOURS_AGO, 1),
            $this->createCase($this->createRequestForSeconds(-2 * DateUnits::HOUR), Results::HOURS_AGO, 2),
            $this->createCase($this->createRequestForSeconds(-10 * DateUnits::HOUR), Results::HOURS_AGO, 10),
            $this->createCase($this->createRequestForSeconds(-24 * DateUnits::HOUR + 1), Results::HOURS_AGO, 23),
            $this->createCase($this->createRequestForSeconds(-24 * DateUnits::HOUR), null),
            $this->createCase($this->createRequestForSeconds(24 * DateUnits::HOUR), null),
            $this->createCase($this->createRequestForSeconds(2 * DateUnits::HOUR), null)
        ];
    }

}