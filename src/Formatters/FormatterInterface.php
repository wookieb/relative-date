<?php

namespace Wookieb\RelativeDate\Formatters;


use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

interface FormatterInterface
{
    public function format(DateDiffResult $result);
}