<?php

namespace Bramus\Monolog\Formatter;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

/**
 * A Colored Line Formatter for Monolog
 */
class ColoredLineFormatter extends \Monolog\Formatter\LineFormatter
{

    /**
     * ANSI Wrapper which provides colors
     * @var \Bramus\Ansi\Ansi
     */
    private $ansi = null;

    /**
     * The color scheme to be applied
     * @var array
     */
    private $colorizeTable = null;

    /**
     * @param string $format                     The format of the message
     * @param string $dateFormat                 The format of the timestamp: one supported by DateTime::format
     * @param bool   $allowInlineLineBreaks      Whether to allow inline line breaks in log entries
     * @param bool   $ignoreEmptyContextAndExtra
     */
    public function __construct($format = null, $dateFormat = null, $allowInlineLineBreaks = false, $ignoreEmptyContextAndExtra = false)
    {
        // Create ansi
        $this->ansi = new Ansi();

        // Call Parent Constructor
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }

    /**
     * Return the ANSI Escape Sequence to reset the formatting
     * @return string The ANSI Escape Sequence to reset the formatting
     */
    public function resetFormatting()
    {
        return $this->ansi->reset()->get();
    }

    /**
     * Gets the colorize table / color scheme to use
     * @return array
     */
    public function getColorizeTable()
    {
        if (!$this->colorizeTable) {
            $this->colorizeTable = array(
                \Monolog\Logger::DEBUG => $this->ansi->color(SGR::COLOR_FG_WHITE)->get(),
                \Monolog\Logger::INFO => $this->ansi->color(SGR::COLOR_FG_GREEN)->get(),
                \Monolog\Logger::NOTICE => $this->ansi->color(SGR::COLOR_FG_CYAN)->get(),
                \Monolog\Logger::WARNING => $this->ansi->color(SGR::COLOR_FG_YELLOW)->get(),
                \Monolog\Logger::ERROR => $this->ansi->color(SGR::COLOR_FG_RED)->get(),
                \Monolog\Logger::CRITICAL => $this->ansi->color(SGR::COLOR_FG_RED)->underline()->get(),
                \Monolog\Logger::ALERT => $this->ansi->color(array(SGR::COLOR_FG_WHITE, SGR::COLOR_BG_RED_BRIGHT))->get(),
                \Monolog\Logger::EMERGENCY => $this->ansi->color(SGR::COLOR_BG_RED_BRIGHT)->blink()->color(SGR::COLOR_FG_WHITE)->get(),
            );
        }

        return $this->colorizeTable;
    }

    /**
     * Sets the colorize table
     * @param array
     */
    public function setColorizeTable($table)
    {
        $this->colorizeTable = $table;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        // Get colorize table
        $colorizeTable = $this->getColorizeTable();

        // Let the parent class to the formatting, yet wrap it in the color linked to the level
        return $colorizeTable[$record['level']].trim(parent::format($record)).$this->resetFormatting()."\n";
    }
}
