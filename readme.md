# Monolog Colored Line Formatter

A Formatter for Monolog with color support
Built by Bramus! - [https://www.bram.us/](https://www.bram.us/)

[![Build Status](https://api.travis-ci.org/bramus/monolog-colored-line-formatter.png)](http://travis-ci.org/bramus/monolog-colored-line-formatter)

## About

`bramus/monolog-colored-line-formatter` is a formatter for use with [Monolog](https://github.com/Seldaek/monolog). It augments the [Monolog LineFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/LineFormatter.php) by adding color support. To achieve this `bramus/monolog-colored-line-formatter` uses ANSI Escape Sequences, which makes it perfect for usage on text based terminals (viz. the shell).

`bramus/monolog-colored-line-formatter` ships with a default color scheme, yet it can be adjusted to fit your own needs.

![Monolog Colored Line Formatter](https://raw.githubusercontent.com/bramus/monolog-colored-line-formatter/master/screenshots/colorscheme-default.gif)


## Prerequisites/Requirements

- PHP 5.3.3 or greater

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

$log = new Logger('DEMO');
$handler = new StreamHandler('php://stdout', Logger::WARNING);
$coloredLineFormatter = new ColoredLineFormatter();
$handler->setFormatter($coloredLineFormatter);
$log->pushHandler($handler);

$coloredLineFormatter->setColorizeTable(array(
	Logger::DEBUG => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_WHITE),
	Logger::INFO => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_GREEN),
	Logger::NOTICE => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_CYAN),
	Logger::WARNING => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_YELLOW),
	Logger::ERROR => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_RED),
	Logger::CRITICAL => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_RED, 'underline'),
	Logger::ALERT => ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_WHITE) . ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_RED, '', 'background_high'),
	Logger::EMERGENCY =>  ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_RED, '', 'background_high') . ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_WHITE, 'blink')
));
```

## Specifying Colors

`bramus/monolog-colored-line-formatter` uses ANSI Escape Sequences to set the color. To format a color, call `ColoredLineFormatter::formatColor($color, $attribute, $coloring)` and pass in these parameters:

- `$color`: The color to use in the output
- `$attribute`: Text attribute to apply
- `$coloring`: The type of coloring to apply

The parameters will be translated to SGR (Select Graphic Rendition) Parameters.

### List of Colors

- `ColoredLineFormatter::COLOR_BLACK`: Black
- `ColoredLineFormatter::COLOR_RED`: Red
- `ColoredLineFormatter::COLOR_GREEN`: Green
- `ColoredLineFormatter::COLOR_YELLOW`: Yellow
- `ColoredLineFormatter::COLOR_BLUE`: Blue
- `ColoredLineFormatter::COLOR_PURPLE`: Purple
- `ColoredLineFormatter::COLOR_CYAN`: Cyan
- `ColoredLineFormatter::COLOR_WHITE`: White

### Attributes

- `ColoredLineFormatter::ATTRIBUTE_NONE`: All Attributes Off
- `ColoredLineFormatter::ATTRIBUTE_BOLD`: Bold or increased intensity
- `ColoredLineFormatter::ATTRIBUTE_DIM`: Decreased intensity _(Not widely supported)_
- `ColoredLineFormatter::ATTRIBUTE_ITALIC`: Italic _(Not widely supported)_
- `ColoredLineFormatter::ATTRIBUTE_UNDERLINE`: Underline (single)
- `ColoredLineFormatter::ATTRIBUTE_BLINK`: Blinking _(Not widely supported)_
- `ColoredLineFormatter::ATTRIBUTE_BLINK_RAPID`: Fast Blinking _(Not widely supported)_
- `ColoredLineFormatter::ATTRIBUTE_REVERSE`: Swap foreground and background
- `ColoredLineFormatter::ATTRIBUTE_CONCEAL`: Concealed/Hidden _(Not widely supported)_
- `ColoredLineFormatter::ATTRIBUTE_STRIKETHROUGH`: Crossed-out _(Not widely supported)_

### Coloring Options

- `ColoredLineFormatter::COLORING_FOREGROUND`: Set passed in `$color` as text color
- `ColoredLineFormatter::COLORING_FOREGROUND_HIGH`: Set passed in `$color` as text color (high intensity)
- `ColoredLineFormatter::COLORING_BACKGROUND`: Set passed in `$color` as background color
- `ColoredLineFormatter::COLORING_BACKGROUND_HIGH: Set passed in `$color` as background color (high intensity)

Note that it's possible to combine foreground and background colors, by concatenating two `ColoredLineFormatter::formatColor($color, $attribute, $coloring)` calls:
```
echo ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_WHITE) . ColoredLineFormatter::formatColor(ColoredLineFormatter::COLOR_RED, '', 'background_high') . 'I am a white text on a red background' . ColoredLineFormatter::resetFormatting();
```

## Unit Testing

`bramus/monolog-colored-line-formatter` ships with unit tests using [PHPUnit](https://github.com/sebastianbergmann/phpunit/).

- If PHPUnit is installed globally run `phpunit` to run the tests.

- If PHPUnit is not installed globally, install it locally throuh composer by running `composer install --dev`. Run the tests themselves by calling `vendor/bin/phpunit`.

Unit tests are also automatically run [on Travis CI](http://travis-ci.org/bramus/monolog-colored-line-formatter)

## License

`bramus/monolog-colored-line-formatter` is released under the MIT public license. See the enclosed `LICENSE.txt` for details.