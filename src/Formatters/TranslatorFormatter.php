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

    private $customPlaceholders = [];

    public function __construct(TranslatorInterface $translatorInterface, $dateFormat = BasicFormatter::FULL_FORMAT, $domain = 'relative-date')
    {
        $this->translatorInterface = $translatorInterface;
        $this->dateFormat = $dateFormat;
        $this->domain = $domain;
    }

    /**
     * Register custom placeholder generated just for particular result keys like ([X] months ago, yesterday, tomorrow]
     *
     * @param array $resultKeys
     * @param string $placeholderName
     * @param callable $placeholderFunction
     */
    public function registerCustomPlaceholder(array $resultKeys, $placeholderName, $placeholderFunction)
    {
        if (!is_callable($placeholderFunction, true)) {
            throw new \InvalidArgumentException('Placeholder function is not callable');
        }

        foreach ($resultKeys as $resultKey) {
            if (!isset($this->customPlaceholders[$resultKey])) {
                $this->customPlaceholders[$resultKey] = [];
            }
            $this->customPlaceholders[$resultKey][$placeholderName] = $placeholderFunction;
        }
    }

    public function format(DateDiffResult $result)
    {
        if ($result->getKey() === DateDiffResult::FULL_DATE) {
            return $result->getRequest()->getDate()->format($this->dateFormat);
        }
        return $this->translatorInterface->transChoice(
            $result->getKey(),
            $result->getValue(),
            $this->getPlaceholders($result),
            $this->domain
        );
    }

    private function getPlaceholders(DateDiffResult $result)
    {
        $placeholders = ['%count%' => $result->getValue()];
        if (isset($this->customPlaceholders[$result->getKey()])) {
            $customPlaceholders = $this->customPlaceholders[$result->getKey()];
            foreach ($customPlaceholders as $customPlaceholder => $customPlaceholderFunction) {
                $placeholders[$customPlaceholder] = call_user_func($customPlaceholderFunction, $result);
            }
        }
        return $placeholders;
    }
}