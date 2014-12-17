<?php

namespace Bramus\Monolog\Formatter;

/**
 * A Colored Line Formatter for Monolog
 */
class ColoredLineFormatter extends \Monolog\Formatter\LineFormatter {

	protected static $colors = array(
		'BLACK' => "\033[30m",
		'RED' => "\033[31m",
		'GREEN' => "\033[32m",
		'YELLOW' => "\033[33m",
		'BLUE' => "\033[34m",
		'PURPLE' => "\033[35m",
		'CYAN' => "\033[36m",
		'WHITE' => "\033[37m",

		'BOLDBLACK' => "\033[1;30m",
		'BOLDRED' => "\033[1;31m",
		'BOLDGREEN' => "\033[1;32m",
		'BOLDYELLOW' => "\033[1;33m",
		'BOLDBLUE' => "\033[1;34m",
		'BOLDPURPLE' => "\033[1;35m",
		'BOLDCYAN' => "\033[1;36m",
		'BOLDWHITE' => "\033[1;37m",

		'BGBLACK' => "\033[40m",
		'BGRED' => "\033[41m",
		'BGGREEN' => "\033[42m",
		'GBYELLOW' => "\033[43m",
		'BGBLUE' => "\033[44m",
		'BGPURPLE' => "\033[45m",
		'BGCYAN' => "\033[46m",
		'BGWHITE' => "\033[47m",

		'COLOROFF' => "\033[0m"
	);

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {

		$colorizetable = array(
			\Monolog\Logger::DEBUG => static::$colors['WHITE'] . static::$colors['BGBLACK'],
			\Monolog\Logger::INFO => static::$colors['GREEN'] . static::$colors['BGBLACK'],
			\Monolog\Logger::NOTICE => static::$colors['CYAN'] . static::$colors['BGBLACK'],
			\Monolog\Logger::WARNING => static::$colors['YELLOW'] . static::$colors['BGBLACK'],
			\Monolog\Logger::ERROR => static::$colors['RED'] . static::$colors['BGBLACK'],
			\Monolog\Logger::CRITICAL => static::$colors['BOLDRED'] . static::$colors['BGBLACK'],
			\Monolog\Logger::ALERT => static::$colors['WHITE'] . static::$colors['BGRED'],
			\Monolog\Logger::EMERGENCY => static::$colors['BOLDWHITE'] . static::$colors['BGRED']
		);

        return $colorizetable[$record['level']] . parent::format($record) . static::$colors['COLOROFF'];
    }

}