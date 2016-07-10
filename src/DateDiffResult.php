<?php

namespace Wookieb;

class DateDiffResult
{
    private $key;
    private $value;

    const FULL_DATE = 'full-date';

    /**
     * @var DateDiffRequest
     */
    private $request;

    /**
     * DateDiffResult constructor.
     * @param DateDiffRequest $request
     * @param string $key
     * @param int $value
     */
    public function __construct(DateDiffRequest $request, $key, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return int|null
     */
    public function getValue()
    {
        return $this->value;
    }

    public static function createFullDate(DateDiffRequest $request)
    {
        return new self($request, self::FULL_DATE);
    }

    /**
     * @return DateDiffRequest
     */
    public function getRequest()
    {
        return $this->request;
    }
}