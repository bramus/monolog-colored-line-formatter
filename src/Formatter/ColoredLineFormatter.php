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

	const CODE_FOREGROUND = '3';
	const CODE_FOREGROUND_HIGH = '9';
	const CODE_BACKGROUND = '4';
	const CODE_BACKGROUND_HIGH = '10';

	const FORMATTING_NONE = '';
	const FORMATTING_BOLD = '1;';
	const FORMATTING_UNDERLINE = '4;';

	private $colorizeTable = null;


	/**
	 * Format a color to its Bash string, e.g. white foreground color is "\033[37m"
	 * @see https://wiki.archlinux.org/index.php/Color_Bash_Prompt#List_of_colors_for_prompt_and_Bash for list of colors
	 * 
	 * @param  int $color The color to use in the output (1-7)
	 * @param  string $formatting Extra formatting to apply. Allowed values: 'underline' and 'bold'
	 * @param  string $type The type of color. Allowed values: 'foreground', 'foreground_high', 'background', and 'background_high'
	 * @return string The Bash string representing the color
	 */
	public function formatColor($color, $formatting = '', $type = 'foreground')
	{

		// Rework $color so that it can be used
		$color = (int) $color;
		if (($color < 0) || ($color > 7)) {
			$color = 0;
		}

		// Rework $type so that it can be used in the colorstring
		switch($type) {
			case 'background_high':
				$type = self::CODE_BACKGROUND_HIGH;
				break;
			case 'background':
				$type = self::CODE_BACKGROUND;
				break;
			case 'foreground_high':
				$type = self::CODE_FOREGROUND_HIGH;
				break;
			case 'foreground':
			default:
				$type = self::CODE_FOREGROUND;
				break;
		}

		// Rework $formatting so that it can be used in the colorstring
		// but only if foreground color is selected
		if ($type == self::CODE_BACKGROUND) {
			$formatting = self::FORMATTING_NONE;
		} else {
			switch($formatting) {
				case 'bold':
					$formatting = self::FORMATTING_BOLD;
					break;
				case 'underline':
					$formatting = self::FORMATTING_UNDERLINE;
					break;
				default:
					$formatting = self::FORMATTING_NONE;
					break;
			}
		}

		// Build the color string and return it
		return "\033[" . $formatting . $type . $color . "m";

	}


	/**
	 * Return the bash string to reset the color
	 * @return string The Bash string representing the color reset
	 */
	public function resetColor()
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
				\Monolog\Logger::DEBUG => $this->formatColor(self::COLOR_WHITE),
				\Monolog\Logger::INFO => $this->formatColor(self::COLOR_GREEN),
				\Monolog\Logger::NOTICE => $this->formatColor(self::COLOR_CYAN),
				\Monolog\Logger::WARNING => $this->formatColor(self::COLOR_YELLOW),
				\Monolog\Logger::ERROR => $this->formatColor(self::COLOR_RED, 'underline'),
				\Monolog\Logger::CRITICAL => $this->formatColor(self::COLOR_RED, 'bold'),
				\Monolog\Logger::ALERT => $this->formatColor(self::COLOR_WHITE) . $this->formatColor(self::COLOR_RED, '', 'background'),
				\Monolog\Logger::EMERGENCY => $this->formatColor(self::COLOR_WHITE, 'bold') . $this->formatColor(self::COLOR_RED, '', 'background')
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
        return $colorizeTable[$record['level']] . parent::format($record) . $this->resetColor();

    }

}