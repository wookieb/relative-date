<?php

namespace Wookieb\RelativeDate;


class DateDiffRequest
{
    /**
     * @var \DateTimeInterface
     */
    private $date;
    /**
     * @var \DateTimeInterface
     */
    private $baseDate;

    /**
     * @var \DateInterval
     */
    private $interval;

    /**
     * @var int
     */
    private $diffInSeconds = 0;
    /**
     * @var int
     */
    private $calendarMonths;

    public function __construct(\DateTimeInterface $date, \DateTimeInterface $baseDate)
    {
        $this->date = $date;
        $this->baseDate = $baseDate;
        $this->interval = $date->diff($baseDate);
        $this->diffInSeconds = $date->format('U') - $baseDate->format('U');
        $this->calendarMonths = $this->calculateCalendarMonths();
    }

    private function calculateCalendarMonths()
    {
        $months = ((int)$this->date->format('Y') - (int)$this->baseDate->format('Y')) * 12;
        $months += (int)$this->date->format('m') - (int)$this->baseDate->format('m');
        if ($this->date > $this->baseDate) {
            return $months + ($this->date->format('d') < $this->baseDate->format('d') ? -1 : 0);
        } else if ($this->date < $this->baseDate) {
            return $months + ($this->date->format('d') > $this->baseDate->format('d') ? 1 : 0);
        }
        return $months;
    }

    /**
     * @return int
     */
    public function getCalendarMonths()
    {
        return $this->calendarMonths;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getBaseDate()
    {
        return $this->baseDate;
    }

    /**
     * @return \DateInterval
     */
    public function getInterval()
    {
        return $this->interval;
    }

    public function getDiffInSeconds()
    {
        return $this->diffInSeconds;
    }
}