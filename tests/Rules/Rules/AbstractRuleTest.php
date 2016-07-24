<?php

namespace Wookieb\RelativeDate\Tests\Rules\Rules;


use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Rules\RuleInterface;
use Wookieb\RelativeDate\Tests\AbstractTest;

abstract class AbstractRuleTest extends AbstractTest
{
    /**
     * @var RuleInterface
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = $this->createRule();
    }

    abstract protected function createRule();

    public function testCreatesOnlyOneInstanceOfRule()
    {
        $rule1 = $this->createRule();
        $rule2 = $this->createRule();
        $this->assertSame($rule1, $rule2, 'Rule object has been created more than one time');
    }

    abstract public function cases();

    /**
     * @dataProvider cases
     */
    public function testCases(DateDiffRequest $request, DateDiffResult $result = null)
    {
        if ($result) {
            $this->assertTrue($this->rule->isApplicable($request), 'Rule should be applicable for given request');
            $this->assertEquals($result, $this->rule->createResult($request));
        } else {
            $this->assertFalse($this->rule->isApplicable($request), 'Rule should not be applicable for given request');
        }
    }

    protected function createCase(DateDiffRequest $request, $resultKey = null, $resultValue = null)
    {
        return [$request, $resultKey ? new DateDiffResult($request, $resultKey, $resultValue) : null];
    }

    protected function createRequest($dateString, $baseDateString)
    {
        return new DateDiffRequest(new \DateTimeImmutable($dateString), new \DateTimeImmutable($baseDateString));
    }
}