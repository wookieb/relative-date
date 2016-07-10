<?php

namespace Wookieb\Tests\Conditions;


use Wookieb\Conditions\RangeCondition;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;
use Wookieb\Tests\DateDiffRequestTestUtil;

class RangeConditionTest extends \PHPUnit_Framework_TestCase
{

    public function testRangeChecking()
    {
        $condition = new RangeCondition(-100, 100, function (DateDiffRequest $request) {
            return DateDiffResult::createFullDate($request);
        });
        $this->assertTrue($condition->isApplicable(DateDiffRequestTestUtil::createForSeconds(5)));
        $this->assertTrue($condition->isApplicable(DateDiffRequestTestUtil::createForSeconds(100)));
        $this->assertTrue($condition->isApplicable(DateDiffRequestTestUtil::createForSeconds(-100)));
        $this->assertFalse($condition->isApplicable(DateDiffRequestTestUtil::createForSeconds(-101)));
        $this->assertFalse($condition->isApplicable(DateDiffRequestTestUtil::createForSeconds(101)));
        $this->assertFalse($condition->isApplicable(DateDiffRequestTestUtil::createForSeconds(1000)));
    }

    public function testCallsProvidedCallback()
    {
        $called = false;
        $condition = new RangeCondition(-100, 100, function (DateDiffRequest $request) use (&$called) {
            $called = true;
            return new DateDiffResult($request, 'foo');
        });

        $result = $condition->createResult(DateDiffRequestTestUtil::createForSeconds(10));
        $this->assertSame('foo', $result->getKey());
        $this->assertNull($result->getValue());
        $this->assertTrue($called, 'Callback has not been called');
    }
}