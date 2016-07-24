<?php

namespace Wookieb\RelativeDate\Tests;


use Wookieb\RelativeDate\DateDiffResult;

class DateDiffResultTest extends AbstractTest
{
    public function testItsAnImmutableObjectWithGettersMate()
    {
        $request = $this->createRequestForSeconds(5);
        $result = new DateDiffResult($request, 'some-key', 1);

        $this->assertSame($request, $result->getRequest());
        $this->assertSame('some-key', $result->getKey());
        $this->assertSame(1, $result->getValue());
    }
}