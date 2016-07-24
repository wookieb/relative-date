<?php

namespace Wookieb\RelativeDate\Tests\Rules;

use \DateTimeImmutable as D;
use Wookieb\RelativeDate\Rules\Rules;
use Wookieb\RelativeDate\Rules\YesterdayRule;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Tests\AbstractTest;

class YesterdayRuleTest extends AbstractTest
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
        $condition = new YesterdayRule();
        $this->assertSame($isApplicable, $condition->isApplicable($request));
        $this->assertEquals(new DateDiffResult($request, YesterdayRule::RESULT_NAME), $condition->createResult($request));
    }

    public function testCreatingRulesFromRulesClass()
    {
        $rule1 = Rules::yesterday();
        $rule2 = Rules::yesterday();

        $this->assertSame($rule1, $rule2, 'Rule object has ben created more than once');
    }
}