<?php

use WPT\TestRun;

class TestRunTest extends PHPUnit_Framework_TestCase {

	private $firstView;

	private $repeatView;

	protected function setUp() {
		
		$this->firstView = json_decode(file_get_contents('TestRunFirstViewTest.json', true), true);
		$this->repeatView = json_decode(file_get_contents('TestRunRepeatViewTest.json', true), true);
	}

	public function testFirstView() {

		$fv = new TestRun($this->firstView);

		$this->assertTrue($fv->URL === "http://www.google.com");
		$this->assertTrue($fv->loadTime == 2068);
		$this->assertTrue(count($fv->requests) == 13);
	}

	public function testRepeatView() {

		$fv = new TestRun($this->repeatView);

		$this->assertTrue($fv->URL === "http://www.google.com");
		$this->assertTrue($fv->loadTime == 1182);
		$this->assertTrue(count($fv->requests) == 3);
	}


}