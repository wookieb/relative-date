<?php

namespace Wookieb\RelativeDate\Tests\Rules\Rules;


use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;

class WeeksAgoRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::weeksAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-07 23:59:59'), null),
            $this->createCase($this->createRequest('2015-01-08 00:00:00', '2015-01-01 00:00:00'), null),
            $this->createCase($this->createRequest('2015-01-15 00:00:00', '2015-01-01 00:00:00'), null),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-08 00:00:00'), Results::WEEKS_AGO, 1),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-14 00:00:00'), Results::WEEKS_AGO, 1),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-15 00:00:00'), Results::WEEKS_AGO, 2),
            'long months' => $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-02-01 00:00:00'), null),
            'shorts months' => $this->createCase($this->createRequest('2015-02-01 00:00:00', '2015-03-01 00:00:00'), null),
            $this->createCase($this->createRequest('2015-02-01 00:00:00', '2015-02-28 23:59:59'), Results::WEEKS_AGO, 3),
            $this->createCase($this->createRequest('2016-02-01 00:00:00', '2016-02-29 23:59:59'), Results::WEEKS_AGO, 4)
        ];
    }

}