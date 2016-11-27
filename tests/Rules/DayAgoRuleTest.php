<?php

namespace Wookieb\RelativeDate\Tests\Rules;


use Wookieb\RelativeDate\DateUnits;
use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;

class DayAgoRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::daysAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequestForSeconds(-DateUnits::DAY + 1), null),
            $this->createCase($this->createRequestForSeconds(-DateUnits::DAY), Results::DAYS_AGO, 1),
            $this->createCase($this->createRequestForSeconds(-5 * DateUnits::DAY), Results::DAYS_AGO, 5),
            $this->createCase($this->createRequestForSeconds(-7 * DateUnits::DAY + 1), Results::DAYS_AGO, 6),
            $this->createCase($this->createRequestForSeconds(-7 * DateUnits::DAY), null),
            $this->createCase($this->createRequestForSeconds(7 * DateUnits::DAY), null),
            $this->createCase($this->createRequestForSeconds(2 * DateUnits::DAY), null)
        ];
    }

}