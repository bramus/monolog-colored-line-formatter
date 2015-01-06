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
    public function format(array $record)
    {
        // Get the Color Scheme
        $colorScheme = $this->getColorScheme();

        // Let the parent class to the formatting, yet wrap it in the color linked to the level
        return $colorScheme->getColorizeString($record['level']).trim(parent::format($record)).$colorScheme->getResetString()."\n";
    }
}
