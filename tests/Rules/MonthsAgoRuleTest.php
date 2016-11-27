<?php

namespace Wookieb\RelativeDate\Tests\Rules;

use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;


class MonthsAgoRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::monthsAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-31 23:59:59'), null),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-02-01 00:00:00'), Results::MONTHS_AGO, 1),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-02-28 00:00:00'), Results::MONTHS_AGO, 1),
            'few months' => $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-04-05 00:00:00'), Results::MONTHS_AGO, 3),
            'almost a year' => $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-12-31 23:59:59'), Results::MONTHS_AGO, 11),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2016-01-01 00:00:00'), Results::MONTHS_AGO, 12),
            $this->createCase($this->createRequest('2016-01-01 00:00:00', '2015-01-01 00:00:00'), null),
            $this->createCase($this->createRequest('2015-02-01 00:00:00', '2015-01-01 00:00:00'), null)
        ];
    }
}