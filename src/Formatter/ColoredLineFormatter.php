<?php

namespace Bramus\Monolog\Formatter;

use Bramus\Monolog\Formatter\ColorSchemes\ColorSchemeInterface;

/**
 * A Colored Line Formatter for Monolog
 */
class ColoredLineFormatter extends \Monolog\Formatter\LineFormatter
{
    const BEGIN_TOKEN = 'color_begin';
    const END_TOKEN =   'color_end';

    /**
     * The Color Scheme to use
     * @var ColorSchemeInterface
     */
    private $colorScheme = null;

    /**
     * @param ColorSchemeInterface $colorScheme                The color scheme to use
     * @param string               $format                     The format of the message
     * @param string               $dateFormat                 The format of the timestamp: one supported by DateTime::format
     * @param bool                 $allowInlineLineBreaks      Whether to allow inline line breaks in log entries
     * @param bool                 $ignoreEmptyContextAndExtra
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
     *
     * @param ColorSchemeInterface $colorScheme
     */
    public function setColorScheme(ColorSchemeInterface $colorScheme)
    {
        $this->colorScheme = $colorScheme;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record) : string
    {
        // Get the Color Scheme
        $colorScheme = $this->getColorScheme();

        // Let the parent class to the formatting, yet wrap it in the color linked to the level
        $output = parent::format($record);

        // If the begin color token is not found, colorize the entire string and return
        if(false === strpos($output,'%' . self::BEGIN_TOKEN . '%')){
            return $colorScheme->getColorizeString($record['level']).trim($output).$colorScheme->getResetString()."\n";
        }

        // Otherwise replace the begin and end token with the colorize strings
        $replace = [
            self::BEGIN_TOKEN => $this->colorScheme->getColorizeString($record['level']),
            self::END_TOKEN => $this->colorScheme->getResetString(),
        ];
        foreach ($replace as $var => $val) {
            if (false !== strpos($output, '%'.$var.'%')) {
                $output = str_replace('%'.$var.'%', $val, $output);
            }
        }

        return $output;
    }
}
