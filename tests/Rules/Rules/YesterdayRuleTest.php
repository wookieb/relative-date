<?php

namespace Wookieb\RelativeDate\Tests\Rules\Rules;


use Wookieb\RelativeDate\Rules\Rules;
use Wookieb\RelativeDate\Rules\YesterdayRule;

class YesterdayRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::yesterday();
    }

    public function cases()
    {
        return [
            'almost 24 hours diff' => $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-01 23:59:59'), null),
            'tomorrow' => $this->createCase($this->createRequest('2015-01-02 00:00:00', '2015-01-01 00:00:00'), null),
            $this->createCase($this->createRequest('2015-01-01 00:00:00', '2015-01-02 00:00:00'), YesterdayRule::RESULT_NAME),
            'small diff in hours' => $this->createCase($this->createRequest('2015-01-01 23:00:00', '2015-01-02 01:00:00'), YesterdayRule::RESULT_NAME),
            'different year' => $this->createCase($this->createRequest('2016-01-01 00:00:00', '2015-01-02 00:00:00'), null)
        ];
    }
}