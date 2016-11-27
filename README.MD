# Relative-date

Library that helps you compute human readable information about dates.

This is especially useful for such cases like:
* Computing time ago - "2 seconds ago", "yesterday"
* Computing time in the future - "within 5 seconds", "tomorrow at 14:00" (in progress)

## Features
* Customizable rules and predefined rules ([see calculators](#calculators))
* Smart "yesterday" and "tomorrow" calculations
* Support for translations or any other customer formatter
* Symfony 2 and 3 integration via [relative-date-bundle](https://github.com/wookieb/relative-date-bundle)

## Installation

```bash
composer require wookieb/relative-date
```

## Usage
```php
$formatter = new Wookieb\RelativeDate\Formatters\BasicFormatter();
// You can pick one of calculators. See "calculators" section for details
$calculator = Wookieb\RelativeDate\Calculators\TimeAgoDateDiffCalculator::full();

$date = new \DateTime('2016-01-01 14:00:00');
$now = new \DateTime('2016-01-01 16:00:00');
$formatter->format($calculator->compute($date, $now)); // 2 hours ago
```

## Rationale
I've created this library because I was tired of tons of very simplistic relative date calculators that compute a result based on very strict, immutable rules.
That's why _relative-date_ consists of parts that allows you to redefine the whole logic of relative date computation that exactly suits to your needs.
 
You don't need "2 years ago" result since in most cases it's useless? Feel free to pick "upTo2Weeks" calculator and get exactly what you need!

## Translation and support for different languages

Translations are supported via [TranslatorFormatter](src/Formatters/TranslatorFormatter.php). 

Symfony users should use [relative-date-bundle](https://github.com/wookieb/relative-date-bundle).
```php
// $translator - get Symfony translator somehow 
$formatter = new Wookieb\RelativeDate\Formatters\TranslatorFormatter($translator);
$calculator = Wookieb\RelativeDate\Calculators\TimeAgoDateDiffCalculator::full();

$date = new \DateTime('2016-01-01 14:00:00');
$now = new \DateTime('2016-01-01 16:00:00');
$formatter->format($calculator->compute($date, $now)); // 2 godziny temu
```

## Calculators

### TimeAgoCalculator::full
Computes result in one of the units:
* seconds
* minutes
* hours
* days
* weeks
* months
* years

### TimeAgoCalculator::upTo2Weeks
Computes result in one of the units:
* seconds
* minutes
* "yesterday"
* hours
* days
* weeks (up to 14 days)
* full date (if date is older than 14 days)

### TimeAgoCalculator::upTo2Days
Computes result in one of the units:
* seconds
* minutes
* "yesterday"
* hours
* full date (if date is older than "yesterday")

## Customization
TODO