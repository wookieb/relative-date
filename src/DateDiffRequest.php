<?php

namespace Wookieb;


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

    public function __construct(\DateTimeInterface $date, \DateTimeInterface $baseDate)
    {
        $this->date = $date;
        $this->baseDate = $baseDate;
        $this->interval = $date->diff($baseDate);
        $this->diffInSeconds = $date->format('U') - $baseDate->format('U');
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