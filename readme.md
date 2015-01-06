# Monolog Colored Line Formatter

A Formatter for Monolog with color support
Built by Bramus! - [https://www.bram.us/](https://www.bram.us/)

[![Build Status](https://api.travis-ci.org/bramus/monolog-colored-line-formatter.png)](http://travis-ci.org/bramus/monolog-colored-line-formatter)

## About

`bramus/monolog-colored-line-formatter` is a formatter for use with [Monolog](https://github.com/Seldaek/monolog). It augments the [Monolog LineFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/LineFormatter.php) by adding color support. To achieve this `bramus/monolog-colored-line-formatter` uses ANSI Escape Sequences – [provided by `bramus/ansi-php`](https://github.com/bramus/ansi-php) – which makes it perfect for usage on text based terminals (viz. the shell).

`bramus/monolog-colored-line-formatter` ships with a default color scheme, yet it can be adjusted to fit your own needs.

![Monolog Colored Line Formatter](https://raw.githubusercontent.com/bramus/monolog-colored-line-formatter/master/screenshots/colorscheme-default.gif)


## Prerequisites/Requirements

- PHP 5.4.0 or greater

## Installation

Installation is possible using Composer

```
composer require bramus/monolog-colored-line-formatter ~1.0
```

## Usage

Create an instance of `\Bramus\Monolog\Formatter\ColoredLineFormatter` and set it as the formatter for the `\Monolog\Handler\StreamHandler` that you use with your `\Monolog\Logger` instance.

```
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Bramus\Monolog\Formatter\ColoredLineFormatter;

$log = new Logger('DEMO');
$handler = new StreamHandler('php://stdout', Logger::WARNING);
$handler->setFormatter(new ColoredLineFormatter());
$log->pushHandler($handler);

$log->addError('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
```

## Custom Color Schemes

Make sure that upon creation of a new `ColoredLineFormatter` instance you store it in a variable for later use. On that instance call `setColorizeTable()` with one argument: an array specifying a color to use for each `\Monolog\Logger` level

```
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Bramus\Monolog\Formatter\ColoredLineFormatter;
use \Bramus\Ansi\Helper;
use \Bramus\Ansi\Escapecodes\SGR;

$log = new Logger('DEMO');
$handler = new StreamHandler('php://stdout', Logger::WARNING);
$coloredLineFormatter = new ColoredLineFormatter();
$handler->setFormatter($coloredLineFormatter);
$log->pushHandler($handler);

$ansiHelper = new Helper();

$coloredLineFormatter->setColorizeTable(array(
	\Monolog\Logger::DEBUG => $ansiHelper->color(SGR::COLOR_FG_WHITE)->get(),
    \Monolog\Logger::INFO => $ansiHelper->color(SGR::COLOR_FG_GREEN)->get(),
    \Monolog\Logger::NOTICE => $ansiHelper->color(SGR::COLOR_FG_CYAN)->get(),
    \Monolog\Logger::WARNING => $ansiHelper->color(SGR::COLOR_FG_YELLOW)->get(),
    \Monolog\Logger::ERROR => $ansiHelper->color(SGR::COLOR_FG_RED)->get(),
    \Monolog\Logger::CRITICAL => $ansiHelper->color(SGR::COLOR_FG_RED)->underline()->get(),
    \Monolog\Logger::ALERT => $ansiHelper->color(array(SGR::COLOR_FG_WHITE, SGR::COLOR_BG_RED_BRIGHT))->get(),
    \Monolog\Logger::EMERGENCY => $ansiHelper->color(SGR::COLOR_BG_RED_BRIGHT)->blink()->color(SGR::COLOR_FG_WHITE)->get(),
));
```

Please refer to [the `bramus/ansi-php` documentation](https://github.com/bramus/ansi-php) to define your own styles and colors.

## Unit Testing

`bramus/monolog-colored-line-formatter` ships with unit tests using [PHPUnit](https://github.com/sebastianbergmann/phpunit/).

- If PHPUnit is installed globally run `phpunit` to run the tests.

- If PHPUnit is not installed globally, install it locally through composer by running `composer install --dev`. Run the tests themselves by calling `vendor/bin/phpunit`.

Unit tests are also automatically run [on Travis CI](http://travis-ci.org/bramus/monolog-colored-line-formatter)

## License

`bramus/monolog-colored-line-formatter` is released under the MIT public license. See the enclosed `LICENSE.txt` for details.
