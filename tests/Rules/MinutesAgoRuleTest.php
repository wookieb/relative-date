<?php

namespace Wookieb\RelativeDate\Tests\Rules;


use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\Rules;
use Wookieb\RelativeDate\DateUnits as Unit;

class MinutesAgoRuleTest extends AbstractRuleTest
{
    protected function createRule()
    {
        return Rules::minutesAgo();
    }

    public function cases()
    {
        return [
            $this->createCase($this->createRequestForSeconds(-1), null),
            $this->createCase($this->createRequestForSeconds(-59), null),
            $this->createCase($this->createRequestForSeconds(-Unit::MINUTE), Results::MINUTES_AGO, 1),
            $this->createCase($this->createRequestForSeconds(-2 * Unit::MINUTE), Results::MINUTES_AGO, 2),
            $this->createCase($this->createRequestForSeconds(-59 * Unit::MINUTE), Results::MINUTES_AGO, 59),
            $this->createCase($this->createRequestForSeconds(-59 * Unit::MINUTE - 59), Results::MINUTES_AGO, 59),
            $this->createCase($this->createRequestForSeconds(-60 * Unit::MINUTE), null),
            $this->createCase($this->createRequestForSeconds(10 * Unit::MINUTE), null),
            $this->createCase($this->createRequestForSeconds(Unit::MINUTE), null)
        ];
    }

}