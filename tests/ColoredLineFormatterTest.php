<?php

use \Bramus\Monolog\Formatter\ColoredLineFormatter;

class ColoredLineFormatterTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->clf = new ColoredLineFormatter();
    }

    protected function tearDown()
    {
        // ...
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('\Bramus\Monolog\Formatter\ColoredLineFormatter', $this->clf);
    }

    public function testReset()
    {
        $this->assertEquals($this->clf->resetFormatting(), "\033[0m");
    }

    // public function testDemo()
    // {
    //     foreach (\Monolog\Logger::getLevels() as $level) {
    //         echo $this->clf->format(array(
    //             'level' => $level,
    //             'level_name' => \Monolog\Logger::getLevelName($level),
    //             'channel' => 'DEMO',
    //             'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    //             'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), new \DateTimeZone(date_default_timezone_get() ?: 'UTC')),
    //             'context' => array(),
    //             'extra' => array(),
    //         ));
    //     }
    // }
}

// EOF
