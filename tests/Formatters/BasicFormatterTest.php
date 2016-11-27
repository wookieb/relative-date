<?php

namespace Wookieb\RelativeDate\Tests\Formatters;


use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Formatters\BasicFormatter;
use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\Rules\TomorrowRule;
use Wookieb\RelativeDate\Rules\YesterdayRule;

class BasicFormatterTest extends AbstractFormattersTest
{
    public function formattingCases()
    {

        return [
            [$this->makeResult(Results::SECONDS_AGO, 1), 'few seconds ago'],
            [$this->makeResult(Results::SECONDS_AGO, 10), '10 seconds ago'],
            [$this->makeResult(Results::MINUTES_AGO, 1), 'a minute ago'],
            [$this->makeResult(Results::MINUTES_AGO, 10), '10 minutes ago'],
            [$this->makeResult(Results::MINUTES_AGO, 59), '59 minutes ago'],
            [$this->makeResult(Results::HOURS_AGO, 1), 'an hour ago'],
            [$this->makeResult(Results::HOURS_AGO, 10), '10 hours ago'],
            [$this->makeResult(Results::DAYS_AGO, 1), 'yesterday'],
            [$this->makeResult(Results::DAYS_AGO, 20), '20 days ago'],
            [$this->makeResult(YesterdayRule::RESULT_NAME), 'yesterday'],
            [$this->makeResult(Results::WEEKS_AGO, 1), 'a week ago'],
            [$this->makeResult(Results::WEEKS_AGO, 2), '2 weeks ago'],
            [$this->makeResult(Results::MONTHS_AGO, 1), 'a month ago'],
            [$this->makeResult(Results::MONTHS_AGO, 5), '5 months ago'],
            [$this->makeResult(Results::YEARS_AGO, 1), 'a year ago'],
            [$this->makeResult(Results::YEARS_AGO, 5), '5 years ago'],
            [$this->makeResult(TomorrowRule::RESULT_NAME), 'tomorrow']
        ];
    }

    /**
     * @dataProvider formattingCases
     */
    public function testFormat(DateDiffResult $result, $expected)
    {
        $formatter = new BasicFormatter();
        $this->assertSame($expected, $formatter->format($result));
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
    public function testCustomizableDateFormats(DateDiffResult $result, $dateFormat, $expected)
    {
        $formatter = new BasicFormatter($dateFormat);
        $this->assertSame($expected, $formatter->format($result));
    }

    public function testInvalidDateDiffResult()
    {
        $this->setExpectedExceptionRegExp(\InvalidArgumentException::class, '/^Unknown date diff result key "foo"$/');
        $formatter = new BasicFormatter();
        $request = $this->createRequestForSeconds(5);

        $formatter->format(new DateDiffResult($request, 'foo'));
    }
}