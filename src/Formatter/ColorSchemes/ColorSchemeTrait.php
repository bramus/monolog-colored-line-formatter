<?php

namespace Bramus\Monolog\Formatter\ColorSchemes;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

trait ColorSchemeTrait
{

    /**
     * ANSI Wrapper which provides colors
     * @var \Bramus\Ansi\Ansi
     */
    protected $ansi = null;

    /**
     * The Color Scheme Array
     * @var array
     */
    protected $colorScheme = array();

    /*
     * Constructor
     */
    public function __construct()
    {
        // Create Ansi helper
        $this->ansi = new Ansi();
    }

    /**
     * Set the Color Scheme Array
     * @param array $colorScheme The Color Scheme Array
     */
    public function setColorizeArray(array $colorScheme)
    {
        $this->colorScheme = $colorScheme;
    }

    /**
     * Get the Color Scheme Array
     * @return array The Color Scheme Array
     */
    public function getColorizeArray()
    {
        return $this->colorScheme;
    }

    /**
     * Get the Color Scheme String for the given Level
     * @param  int $level The Logger Level
     * @return string The Color Scheme String
     */
    public function getColorizeString($level)
    {
    	return isset($this->colorScheme[$level]) ? $this->colorScheme[$level] : '';
    }

    /**
     * Get the string identifier that closes/finishes the styling
     * @return string The reset string
     */
    public function getResetString()
    {
    	return $this->ansi->reset()->get();
    }
}