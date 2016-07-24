<?php

namespace Wookieb\RelativeDate\Tests\Rules\Rules;


use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;

class YearsAgoRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::yearsAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-12-31 23:59:59'), null),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2016-01-01 00:00:00'), Results::YEARS_AGO, 1),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2016-12-31 23:59:59'), Results::YEARS_AGO, 1),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2016-01-01 12:00:00'), Results::YEARS_AGO, 1),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2016-05-12 23:59:59'), Results::YEARS_AGO, 1),
            $this->createCase($this->createRequest('2016-01-01 00:00:00', '2015-01-01 00:00:00'), null)
        ];
    }
}