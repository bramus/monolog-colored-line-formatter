<?php

declare(strict_types=1);

namespace Bramus\Monolog\Formatter\ColorSchemes;

use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use Exception;
use Monolog\Level;

class TrafficLight implements ColorSchemeInterface
{
    /**
     * Use the ColorScheme and alias its constructor.
     */
    use ColorSchemeTrait {
        ColorSchemeTrait::__construct as private __constructTrait;
    }

    /**
     * [__construct description].
     * @throws Exception
     */
    public function __construct()
    {
        // Call Trait Constructor, so that we have $this->ansi available
        $this->__constructTrait();

        // Our Color Scheme
        $this->setColorizeArray([
            Level::Debug->value => $this->ansi->sgr([SGR::COLOR_FG_GREEN, SGR::STYLE_INTENSITY_FAINT])->get(),
            Level::Info->value => $this->ansi->sgr([SGR::COLOR_FG_GREEN, SGR::STYLE_INTENSITY_NORMAL])->get(),
            Level::Notice->value => $this->ansi->sgr([SGR::COLOR_FG_GREEN, SGR::STYLE_INTENSITY_BRIGHT])->get(),
            Level::Warning->value => $this->ansi->sgr([SGR::COLOR_FG_YELLOW, SGR::STYLE_INTENSITY_FAINT])->get(),
            Level::Error->value => $this->ansi->sgr([SGR::COLOR_FG_YELLOW, SGR::STYLE_INTENSITY_NORMAL])->get(),
            Level::Critical->value => $this->ansi->sgr([SGR::COLOR_FG_RED, SGR::STYLE_INTENSITY_NORMAL])->get(),
            Level::Alert->value => $this->ansi->sgr([SGR::COLOR_FG_RED_BRIGHT, SGR::STYLE_INTENSITY_BRIGHT])->get(),
            Level::Emergency->value => $this->ansi->sgr(
                [SGR::COLOR_FG_RED_BRIGHT, SGR::STYLE_INTENSITY_BRIGHT, SGR::STYLE_BLINK]
            )->get(),
        ]);
    }
}
