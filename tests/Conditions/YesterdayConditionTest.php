<?php

namespace Wookieb\Tests\Conditions;

use \DateTimeImmutable as D;
use Wookieb\Conditions\YesterdayCondition;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;
use Wookieb\Tests\AbstractTest;

class YesterdayConditionTest extends AbstractTest
{
    public function cases()
    {
        return [
            [new DateDiffRequest(new D('2015-01-01 23:00:00'), new D('2015-01-02 10:00:00')), true],
            [new DateDiffRequest(new D('2015-01-01 23:00:00'), new D('2015-01-02 23:59:59')), true],
            [new DateDiffRequest(new D('2015-01-01 23:00:00'), new D('2015-01-03 10:00:00')), false],
            [new DateDiffRequest(new D('2015-01-01 01:00:00'), new D('2015-01-02 23:59:00')), true],
        ];
    }

    /**
     * @dataProvider cases
     */
    public function testAllFeatures(DateDiffRequest $request, $isApplicable)
    {
        $condition = new YesterdayCondition();
        $this->assertSame($isApplicable, $condition->isApplicable($request));
        $this->assertEquals(new DateDiffResult($request, YesterdayCondition::RESULT_NAME), $condition->createResult($request));
    }
}