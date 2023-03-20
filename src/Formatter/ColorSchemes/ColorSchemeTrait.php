<?php

declare(strict_types=1);

namespace Bramus\Monolog\Formatter\ColorSchemes;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\BufferWriter;
use Exception;
use Monolog\Level;

use function array_intersect_key;

trait ColorSchemeTrait
{
    /**
     * ANSI Wrapper which provides colors.
     */
    protected Ansi|null $ansi = null;

    /**
     * The Color Scheme Array.
     */
    protected array $colorScheme = [];

    /*
     * Constructor
     */
    public function __construct()
    {
        // Create Ansi helper
        $this->ansi = new Ansi(new BufferWriter());
    }

    /**
     * Set the Color Scheme Array.
     * @param array $colorScheme The Color Scheme Array
     */
    public function setColorizeArray(array $colorScheme): void
    {
        // Only store entries that exist as Monolog\Logger levels
        $colorScheme = array_intersect_key($colorScheme, array_fill_keys(Level::VALUES, null));

        // Store the filtered colorScheme
        $this->colorScheme = $colorScheme;
    }

    /**
     * Get the Color Scheme Array.
     * @return array The Color Scheme Array
     */
    public function getColorizeArray(): array
    {
        return $this->colorScheme;
    }

    /**
     * Get the Color Scheme String for the given Level.
     * @param int $level The Logger Level
     * @return string The Color Scheme String
     */
    public function getColorizeString(int $level): string
    {
        return $this->colorScheme[$level] ?? '';
    }

    /**
     * Get the string identifier that closes/finishes the styling.
     * @return string The reset string
     * @throws Exception
     */
    public function getResetString(): string
    {
        return $this->ansi->reset()->get();
    }
}
