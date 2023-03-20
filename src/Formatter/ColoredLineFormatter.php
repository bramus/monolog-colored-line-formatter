<?php

declare(strict_types=1);

namespace Bramus\Monolog\Formatter;

use Bramus\Monolog\Formatter\ColorSchemes\ColorSchemeInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\LogRecord;

use function trim;

/**
 * A Colored Line Formatter for Monolog.
 */
class ColoredLineFormatter extends LineFormatter
{
    /**
     * The Color Scheme to use.
     */
    private ColorSchemeInterface|null $colorScheme = null;

    /**
     * @param null $colorScheme
     * @param null $format The format of the message
     * @param null $dateFormat The format of the timestamp: one supported by DateTime::format
     * @param bool $allowInlineLineBreaks Whether to allow inline line breaks in log entries
     */
    public function __construct(
        $colorScheme = null,
        $format = null,
        $dateFormat = null,
        bool $allowInlineLineBreaks = false,
        bool $ignoreEmptyContextAndExtra = false
    ) {
        // Store the Color Scheme
        if ($colorScheme instanceof ColorSchemeInterface) {
            $this->setColorScheme($colorScheme);
        }

        // Call Parent Constructor
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }

    /**
     * Gets The Color Scheme.
     */
    public function getColorScheme(): ColorSchemeInterface
    {
        if (! $this->colorScheme) {
            $this->colorScheme = new ColorSchemes\DefaultScheme();
        }

        return $this->colorScheme;
    }

    /**
     * Sets The Color Scheme.
     */
    public function setColorScheme(ColorSchemeInterface $colorScheme): void
    {
        $this->colorScheme = $colorScheme;
    }

    /**
     * {@inheritdoc}
     */
    public function format(LogRecord $record): string
    {
        // Get the Color Scheme
        $colorScheme = $this->getColorScheme();

        // Let the parent class to the formatting, yet wrap it in the color linked to the level
        return $colorScheme->getColorizeString($record['level']) . trim(
            parent::format($record)
        ) . $colorScheme->getResetString() . "\n";
    }
}
