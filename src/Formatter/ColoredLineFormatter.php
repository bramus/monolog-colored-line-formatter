<?php

namespace Bramus\Monolog\Formatter;

/**
 * A Colored Line Formatter for Monolog
 */
class ColoredLineFormatter extends \Monolog\Formatter\LineFormatter {

	const COLOR_BLACK = '0';
	const COLOR_RED = '1';
	const COLOR_GREEN = '2';
	const COLOR_YELLOW = '3';
	const COLOR_BLUE = '4';
	const COLOR_PURPLE = '5';
	const COLOR_CYAN = '6';
	const COLOR_WHITE = '7';
	const COLOR_RESET = '9';

	const COLORING_FOREGROUND = '3';
	const COLORING_FOREGROUND_HIGH = '9';
	const COLORING_BACKGROUND = '4';
	const COLORING_BACKGROUND_HIGH = '10';

	const ATTRIBUTE_NONE = '0';
	const ATTRIBUTE_BOLD = '1';
	const ATTRIBUTE_DIM = '2';
	const ATTRIBUTE_UNDERLINE = '4';
	const ATTRIBUTE_BLINK = '5';
	const ATTRIBUTE_REVERSE = '7';
	const ATTRIBUTE_CONCEAL = '8';

	private $colorizeTable = null;


	/**
	 * Format a wanted color as an ANSI Escape Sequence, e.g. white bold foreground color is "\033[1;37m"
	 * @see https://wiki.archlinux.org/index.php/Color_Bash_Prompt#List_of_colors_for_prompt_and_Bash
	 * @see http://bluesock.org/~willg/dev/ansi.html
	 * @see  http://wiki.bash-hackers.org/scripting/terminalcodes
	 * 
	 * @param  int $color The color to use in the output (1-7)
	 * @param  string $attribute Text attribute to apply. Allowed values: 'underline', 'bold', 'blink', 'reverse', 'conceal', and 'dim'
	 * @param  string $coloring The type of coloring to apply. Allowed values: 'foreground', 'foreground_high', 'background', and 'background_high'
	 * @return string The ANSI Escape Sequence representing the wanted color
	 */
	public static function formatColor($color, $attribute = '', $coloring = 'foreground')
	{

		// Rework $color so that it can be used
		$color = (int) $color;
		if (($color < 0) || ($color > 7)) {
			$color = 0;
		}

		// Rework $coloring so that it can be used in the colorstring
		switch($coloring) {
			case 'background_high':
				$coloring = self::COLORING_BACKGROUND_HIGH;
				break;
			case 'background':
				$coloring = self::COLORING_BACKGROUND;
				break;
			case 'foreground_high':
				$coloring = self::COLORING_FOREGROUND_HIGH;
				break;
			case 'foreground':
			default:
				$coloring = self::COLORING_FOREGROUND;
				break;
		}

		// Rework $attribute so that it can be used in the colorstring
		// but only if foreground color is selected
		if ($coloring == self::COLORING_BACKGROUND) {
			$attribute = self::ATTRIBUTE_NONE;
		} else {
			switch($attribute) {
				case 'bold':
					$attribute = self::ATTRIBUTE_BOLD;
					break;
				case 'underline':
					$attribute = self::ATTRIBUTE_UNDERLINE;
					break;
				case 'dim':
					$attribute = self::ATTRIBUTE_DIM;
					break;
				case 'blink':
					$attribute = self::ATTRIBUTE_BLINK;
					break;
				case 'reverse':
					$attribute = self::ATTRIBUTE_REVERSE;
					break;
				case 'conceal':
					$attribute = self::ATTRIBUTE_CONCEAL;
					break;
				default:
					$attribute = self::ATTRIBUTE_NONE;
					break;
			}
		}

		// Build the color string and return it
		return "\033[" . $attribute . ';' . $coloring . $color . "m";

	}


	/**
	 * Return the ANSI Escape Sequence to reset the formatting
	 * @return string The ANSI Escape Sequence to reset the formatting
	 */
	public static function resetFormatting()
	{
		return "\033[0m";
	}


	/**
	 * Gets the colorize table to use
	 * @return array
	 */
	public function getColorizeTable()
	{
		if (!$this->colorizeTable) {
			$this->colorizeTable = array(
				\Monolog\Logger::DEBUG => self::formatColor(self::COLOR_WHITE),
				\Monolog\Logger::INFO => self::formatColor(self::COLOR_GREEN),
				\Monolog\Logger::NOTICE => self::formatColor(self::COLOR_CYAN),
				\Monolog\Logger::WARNING => self::formatColor(self::COLOR_YELLOW),
				\Monolog\Logger::ERROR => self::formatColor(self::COLOR_RED),
				\Monolog\Logger::CRITICAL => self::formatColor(self::COLOR_RED, 'underline'),
				\Monolog\Logger::ALERT => self::formatColor(self::COLOR_WHITE) . self::formatColor(self::COLOR_RED, '', 'background_high'),
				\Monolog\Logger::EMERGENCY => self::formatColor(self::COLOR_RED, '', 'background_high') . self::formatColor(self::COLOR_WHITE, 'blink')
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
        return $colorizeTable[$record['level']] . trim(parent::format($record)) . self::resetFormatting() . "\n";

    }

}