<?php

namespace Wookieb\RelativeDate\Tests\Rules\Rules;


use Wookieb\RelativeDate\Rules\Rules;
use Wookieb\RelativeDate\Rules\TomorrowRule;

class TomorrowRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::tomorrow();
    }

    public function cases()
    {
        return [
            'almost 24 hours diff' => $this->createCase($this->createRequest('2015-01-01 23:59:59', '2015-01-01 00:00:00'), null),
            'yesterday' => $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-02 00:00:00'), null),
            $this->createCase($this->createRequest('2015-01-02 00:00:00', '2015-01-01 00:00:00'), TomorrowRule::RESULT_NAME),
            'small diff in hours' => $this->createCase($this->createRequest('2015-01-02 01:00:00', '2015-01-01 23:00:00'), TomorrowRule::RESULT_NAME),
            'different year' => $this->createCase($this->createRequest('2016-01-02 00:00:00', '2015-01-01 00:00:00'), null)
        ];
    }
}