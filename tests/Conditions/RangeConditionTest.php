<?php

namespace Wookieb\Tests\Conditions;


use Wookieb\Conditions\RangeCondition;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;
use Wookieb\Tests\AbstractTest;

class RangeConditionTest extends AbstractTest
{

    public function testRangeChecking()
    {
        $condition = new RangeCondition(-100, 100, function (DateDiffRequest $request) {
            return DateDiffResult::createFullDate($request);
        });
        $this->assertTrue($condition->isApplicable($this->createRequestForSeconds(5)));
        $this->assertTrue($condition->isApplicable($this->createRequestForSeconds(100)));
        $this->assertTrue($condition->isApplicable($this->createRequestForSeconds(-100)));
        $this->assertFalse($condition->isApplicable($this->createRequestForSeconds(-101)));
        $this->assertFalse($condition->isApplicable($this->createRequestForSeconds(101)));
        $this->assertFalse($condition->isApplicable($this->createRequestForSeconds(1000)));
    }

    public function testCallsProvidedCallback()
    {
        $called = false;
        $condition = new RangeCondition(-100, 100, function (DateDiffRequest $request) use (&$called) {
            $called = true;
            return new DateDiffResult($request, 'foo');
        });

        $result = $condition->createResult($this->createRequestForSeconds(10));
        $this->assertSame('foo', $result->getKey());
        $this->assertNull($result->getValue());
        $this->assertTrue($called, 'Callback has not been called');
    }

    public function testThrowsErrorForInvalidCallback()
    {
        $this->setExpectedExceptionRegExp(\InvalidArgumentException::class, '/^Format callback must be callable$/');
        /** @noinspection PhpParamsInspection */
        new RangeCondition(0, 100, new \stdClass());
    }

    public function testCreatingForNegativeValues()
    {
        $condition = RangeCondition::createForNegativeValues(10, 100, 'trim');
        $this->assertTrue($condition->isApplicable($this->createRequestForSeconds(-10)));
        $this->assertTrue($condition->isApplicable($this->createRequestForSeconds(-100)));
        $this->assertTrue($condition->isApplicable($this->createRequestForSeconds(-50)));
        $this->assertFalse($condition->isApplicable($this->createRequestForSeconds(0)));
        $this->assertFalse($condition->isApplicable($this->createRequestForSeconds(-150)));
        $this->assertFalse($condition->isApplicable($this->createRequestForSeconds(-5)));
    }

}