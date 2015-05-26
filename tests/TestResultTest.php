<?php

use WPT\TestResult;

class TestResultTest extends PHPUnit_Framework_TestCase {

	private $json;

	protected function setUp() {
		
		$this->json = json_decode(file_get_contents('TestResultTest.json', true), true);
	}

	public function testTestResult() {

		$result = new TestResult($this->json);

		$this->assertTrue($result->id === "150521_5S_10YE");
	}

}