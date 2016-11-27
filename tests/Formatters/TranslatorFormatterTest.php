<?php

namespace Wookieb\RelativeDate\Tests\Formatters;


use Symfony\Component\Translation\TranslatorInterface;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Formatters\BasicFormatter;
use Wookieb\RelativeDate\Formatters\TranslatorFormatter;
use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\TomorrowRule;
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
                $result->getKey(),
                $result->getValue(),
                ['%count%' => $result->getValue()],
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsAnErrorInCustomPlaceholderFunctionIsNotCallable()
    {
        $translator = $this->getMockForAbstractClass(TranslatorInterface::class);
        $formatter = new TranslatorFormatter($translator);

        $formatter->registerCustomPlaceholder(['test'], '%test%', []);
    }

    public function customPlaceholdersTestCases()
    {
        return [
            [
                new DateDiffResult(
                    new DateDiffRequest(
                        new \DateTimeImmutable('2016-01-01 14:01:00'),
                        new \DateTimeImmutable('2016-01-02 00:00:00')
                    ),
                    YesterdayRule::RESULT_NAME,
                    null
                )
            ],
            [
                new DateDiffResult(
                    new DateDiffRequest(
                        new \DateTimeImmutable('2016-01-02 16:05:00'),
                        new \DateTimeImmutable('2016-01-01 00:00:00')
                    ),
                    TomorrowRule::RESULT_NAME,
                    null
                )
            ]
        ];
    }

    /**
     * @dataProvider customPlaceholdersTestCases
     */
    public function testCustomPlaceholders(DateDiffResult $result)
    {
        $translator = $this->getMockForAbstractClass(TranslatorInterface::class);
        $formatter = new TranslatorFormatter($translator);

        $formatter->registerCustomPlaceholder(['yesterday', 'tomorrow'], '%at%', function (DateDiffResult $result) {
            return $result->getRequest()->getDate()->format('H:i');
        });

        $translator->expects($this->once())
            ->method('transChoice')
            ->with(
                $result->getKey(),
                $this->isNull(),
                ['%count%' => $result->getValue(), '%at%' => $result->getRequest()->getDate()->format('H:i')]
            );

        $formatter->format($result);
    }
}