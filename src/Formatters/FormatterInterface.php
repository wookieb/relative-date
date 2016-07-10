<?php

namespace Wookieb\Formatters;


use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;

interface FormatterInterface
{
    public function format(DateDiffResult $result);
}