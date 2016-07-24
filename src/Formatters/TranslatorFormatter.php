<?php

namespace Wookieb\RelativeDate\Formatters;


use Symfony\Component\Translation\TranslatorInterface;
use Wookieb\RelativeDate\DateDiffResult;

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
    /**
     * @var string
     */
    private $domain;

    public function __construct(TranslatorInterface $translatorInterface, $dateFormat = BasicFormatter::FULL_FORMAT, $domain = 'relative-date')
    {
        $this->translatorInterface = $translatorInterface;
        $this->setDateFormat($dateFormat);
        $this->domain = $domain;
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
        return $this->translatorInterface->transChoice(
            $result->getKey(),
            $result->getValue(),
            ['%count' => $result->getValue()],
            $this->domain
        );
    }
}