<?php

use WPT\Tester;
use WPT\Location;

class TesterTest extends PHPUnit_Framework_TestCase {

	protected static $api_key;
	private $location;
	private $jsonData = '{"Label":"Dulles, VA USA (IE 8-11,Chrome,Firefox,Android,iOS)","location":"Dulles_MotoG","Browser":"Motorola G - Chrome","relayServer":null,"relayLocation":null,"labelShort":"Dulles, VA - Motorola G - Chrome","PendingTests":{"p1":0,"p2":0,"p3":0,"p4":0,"p5":0,"p6":0,"p7":0,"p8":0,"p9":0,"Total":1,"HighPriority":0,"LowPriority":0,"Testing":1,"Idle":7}}';

	public static function setUpBeforeClass() {

		self::$api_key = readline("\nEnter your API Key: ");
	}

	protected function setUp() {
		
		$this->location = new Location(json_decode($this->jsonData, true));	
	}

	public function testTesterSetup() {

		$tester = new Tester(self::$api_key, $this->location);

		$url = $tester->getRequestURL("www.example.com");
		
		$expected = 'http://www.webpagetest.org/runtest.php?k=' . self::$api_key . '&fvonly=1&private=1&f=json&noopt=1&timeline=1&location=Dulles_MotoG:Chrome.Cable&url=www.example.com';
		$this->assertTrue($url === $expected);
	}

	public function testTester() {

		$tester = new Tester(self::$api_key, $this->location);
		$result = $tester->runTest("www.google.com");
		
		$this->assertTrue($result !== "FAILED");
	}
}