<?php

namespace Wookieb\Tests;


use Wookieb\Conditions\ConditionInterface;
use Wookieb\DateDiffCalculator;

use Wookieb\DateDiffRequest as Req;
use Wookieb\DateDiffResult as Res;
use \DateTimeImmutable as D;
use Wookieb\DateDiffResult;

class DateDiffCalculatorTest extends AbstractTest
{

    public function testReturnsResultsFromTheFirstSatisfiedCondition()
    {
        $calculator = new DateDiffCalculator([
            $this->createCondition(function (Req $req) {
                return $req->getDiffInSeconds() > -5;
            }, function (Req $req) {
                return new Res($req, 1);
            }),

            $this->createCondition(function (Req $req) {
                return $req->getDiffInSeconds() > -100;
            }, function (Req $req) {
                return new Res($req, 2);
            })
        ]);

        $this->assertDateDiffResult(1, null, $calculator->compute(new D('2015-01-01 11:00:00'), new D('2015-01-01 11:00:02')));
        $this->assertDateDiffResult(2, null, $calculator->compute(new D('2015-01-01 11:00:00'), new D('2015-01-01 11:00:20')));
        $this->assertDateDiffResult(DateDiffResult::FULL_DATE, null, $calculator->compute(new D('2015-01-01 11:00:00'), new D('2015-01-01 11:10:00')));
    }

    private function createCondition($isApplicableCallback, $createResultCallback)
    {
        $condition = $this->getMockForAbstractClass(ConditionInterface::class);

        $condition->expects($this->any())
            ->method('isApplicable')
            ->willReturnCallback($isApplicableCallback);

        $condition->expects($this->any())
            ->method('createResult')
            ->willReturnCallback($createResultCallback);

        return $condition;
    }
}