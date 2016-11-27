<?php

namespace Wookieb\RelativeDate\Tests\Formatters;


use Symfony\Component\Translation\TranslatorInterface;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Formatters\BasicFormatter;
use Wookieb\RelativeDate\Formatters\TranslatorFormatter;
use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\YesterdayRule;
use Wookieb\RelativeDate\Tests\AbstractTest;

class TranslatorFormatterTest extends AbstractFormattersTest
{
    public function formattingCases()
    {
        return [
            [$this->makeResult(Results::MONTHS_AGO, 1)],
            [$this->makeResult(YesterdayRule::RESULT_NAME)],
            [$this->makeResult(Results::SECONDS_AGO, 10)],
            [$this->makeResult(Results::DAYS_AGO, 28)],
        ];
    }

    /**
     * @dataProvider formattingCases
     */
    public function testForwardResultToTranslator(DateDiffResult $result)
    {
        $domain = 'custom-domain';

        $translator = $this->getMockForAbstractClass(TranslatorInterface::class);
        $translator->expects($this->once())
            ->method('transChoice')
            ->with(
                $this->equalTo($result->getKey()),
                $this->equalTo($result->getValue()),
                $this->equalTo(['%count' => $result->getValue()]),
                $domain
            )
            ->willReturn('foo bar');

        $formatter = new TranslatorFormatter($translator, BasicFormatter::FULL_FORMAT, $domain);
        $this->assertSame('foo bar', $formatter->format($result));
    }

    public function fullDateFormattingCases()
    {
        $currentDate = new \DateTimeImmutable();
        return [
            [$this->createFullDateResult($currentDate), BasicFormatter::FULL_FORMAT, $currentDate->format(BasicFormatter::FULL_FORMAT)],
            [$this->createFullDateResult($currentDate), BasicFormatter::SHORT_FORMAT, $currentDate->format(BasicFormatter::SHORT_FORMAT)],
            [$this->createFullDateResult($currentDate), 'c', $currentDate->format('c')]
        ];
    }

    /**
     * @dataProvider fullDateFormattingCases
     */
    public function testFormattingFullDate(DateDiffResult $result, $dateFormat, $expected)
    {
        $translator = $this->getMockForAbstractClass(TranslatorInterface::class);
        $formatter = new TranslatorFormatter($translator, $dateFormat, 'custom-domain');
        $this->assertSame($expected, $formatter->format($result));
    }
}