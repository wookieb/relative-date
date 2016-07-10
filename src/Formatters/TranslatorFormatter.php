<?php

namespace Wookieb\Formatters;


use Symfony\Component\Translation\TranslatorInterface;
use Wookieb\DateDiffResult;

class TranslatorFormatter implements FormatterInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translatorInterface;
    /**
     * @var string
     */
    private $dateFormat;

    public function __construct(TranslatorInterface $translatorInterface, $dateFormat = BasicFormatter::FULL_FORMAT)
    {
        $this->translatorInterface = $translatorInterface;
        $this->setDateFormat($dateFormat);
    }

    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    public function format(DateDiffResult $result)
    {
        if ($result->getKey() === DateDiffResult::FULL_DATE) {
            return $result->getRequest()->getDate()->format($this->dateFormat);
        }
        return $this->translatorInterface->transChoice($result->getKey(), $result->getValue(), ['%count' => $result->getValue()]);
    }
}