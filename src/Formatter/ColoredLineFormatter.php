<?php

namespace Bramus\Monolog\Formatter;

use Bramus\Monolog\Formatter\ColorSchemes\ColorSchemeInterface;

/**
 * A Colored Line Formatter for Monolog
 */
class ColoredLineFormatter extends \Monolog\Formatter\LineFormatter
{
    /**
     * The Color Scheme to use
     * @var ColorSchemeInterface
     */
    private $colorScheme = null;

    /**
     * @param string $format The format of the message
     * @param string $dateFormat The format of the timestamp: one supported by DateTime::format
     * @param bool $allowInlineLineBreaks Whether to allow inline line breaks in log entries
     * @param bool $ignoreEmptyContextAndExtra
     */
    public function __construct($colorScheme = null, $format = null, $dateFormat = null, $allowInlineLineBreaks = false, $ignoreEmptyContextAndExtra = false)
    {
        // Store the Color Scheme
        if ($colorScheme instanceof ColorSchemeInterface) $this->setColorScheme($colorScheme);

        // Call Parent Constructor
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }

    /**
     * Gets The Color Scheme
     * @return ColorSchemeInterface
     */
    public function getColorScheme()
    {
        if (!$this->colorScheme) {
            $this->colorScheme = new ColorSchemes\DefaultScheme();
        }

        return $this->colorScheme;
    }

    /**
     * Sets The Color Scheme
     * @param array
     */
    public function setColorScheme(ColorSchemeInterface $colorScheme)
    {
        $this->colorScheme = $colorScheme;
    }

    /**
     * {@inheritdoc}
     */
    public function format($record): string
    {
        // Get the Color Scheme
        $colorScheme = $this->getColorScheme();

        if ($record instanceof \Monolog\LogRecord) {
            return $colorScheme->getColorizeString($record->level) . trim(parent::format($record->toArray())) . $colorScheme->getResetString() . "\n";
        }

        return $colorScheme->getColorizeString($record['level']) . trim(parent::format($record)) . $colorScheme->getResetString() . "\n";
    }
}
