<?php

namespace Wookieb\RelativeDate\Tests\Rules;

use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;

class SecondsAgeRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::secondsAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequestForSeconds(-1), Results::SECONDS_AGO, 1),
            $this->createCase($this->createRequestForSeconds(-30), Results::SECONDS_AGO, 30),
            $this->createCase($this->createRequestForSeconds(-59), Results::SECONDS_AGO, 59),
            $this->createCase($this->createRequestForSeconds(-60)),
            $this->createCase($this->createRequestForSeconds(1)),
            $this->createCase($this->createRequestForSeconds(59))
        ];
    }
}