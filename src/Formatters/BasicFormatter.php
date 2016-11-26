<?php

namespace Wookieb\RelativeDate\Formatters;


use Wookieb\RelativeDate\Rules\Results;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\Rules\TomorrowRule;
use Wookieb\RelativeDate\Rules\YesterdayRule;

/**
 * Very basic formatter for english
 */
class BasicFormatter implements FormatterInterface
{
    /**
     * @var string
     */
    private $dateFormat;

    const FULL_FORMAT = 'Y-m-d H:i:s';
    const SHORT_FORMAT = 'Y-m-d';


    public function __construct($dateFormat = self::FULL_FORMAT)
    {
        $this->dateFormat = $dateFormat;
    }


    public function format(DateDiffResult $result)
    {
        switch ($result->getKey()) {
            case Results::SECONDS_AGO:
                return $result->getValue() < 10 ? 'few seconds ago' : $this->interpolate($result);

            case Results::MINUTES_AGO:
                return $result->getValue() === 1 ? 'a minute ago' : $this->interpolate($result);

            case Results::HOURS_AGO:
                return $result->getValue() === 1 ? 'an hour ago' : $this->interpolate($result);

            case Results::DAYS_AGO:
                return $result->getValue() === 1 ? 'yesterday' : $this->interpolate($result);

            case Results::WEEKS_AGO:
                return $result->getValue() === 1 ? 'a week ago' : $this->interpolate($result);

            case Results::MONTHS_AGO:
                return $result->getValue() === 1 ? 'a month ago' : $this->interpolate($result);

            case Results::YEARS_AGO:
                return $result->getValue() === 1 ? 'a year ago' : $this->interpolate($result);

            case DateDiffResult::FULL_DATE:
                return $result->getRequest()->getDate()->format($this->dateFormat);

            case YesterdayRule::RESULT_NAME:
                return 'yesterday';

            case TomorrowRule::RESULT_NAME:
                return 'tomorrow';
        }

        throw new \InvalidArgumentException(sprintf('Unknown date diff result key "%s"', $result->getKey()));
    }

    private function interpolate(DateDiffResult $dateDiffResult)
    {
        return str_replace('[X]', $dateDiffResult->getValue(), $dateDiffResult->getKey());
    }
}