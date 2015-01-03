<?php

class ColoredLineFormatterTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {

		$this->clf = new \Bramus\Monolog\Formatter\ColoredLineFormatter();

	}

	protected function tearDown() {
		// ...
	}

	public function testInstantiation() {

		$this->assertInstanceOf('\Bramus\Monolog\Formatter\ColoredLineFormatter', $this->clf);

	}

}

// EOF
