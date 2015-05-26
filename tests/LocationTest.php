<?php

use WPT\Location;

class LocationTest extends PHPUnit_Framework_TestCase {

	public function testLocation() {

		$jsonData = '{"Label":"Dulles, VA USA (IE 8-11,Chrome,Firefox,Android,iOS)","location":"Dulles_MotoG","Browser":"Motorola G - Chrome","relayServer":null,"relayLocation":null,"labelShort":"Dulles, VA - Motorola G - Chrome","PendingTests":{"p1":0,"p2":0,"p3":0,"p4":0,"p5":0,"p6":0,"p7":0,"p8":0,"p9":0,"Total":1,"HighPriority":0,"LowPriority":0,"Testing":1,"Idle":7}}';
		$rs = json_decode($jsonData, true);

		$loc = new Location($rs);

		$this->assertTrue($loc->label === "Dulles, VA USA (IE 8-11,Chrome,Firefox,Android,iOS)");
		$this->assertTrue($loc->location === "Dulles_MotoG");
		$this->assertTrue($loc->browser === "Motorola G - Chrome");
		$this->assertTrue($loc->highPriority == 0);
		$this->assertTrue($loc->lowPriority == 0);
		$this->assertTrue($loc->testing == 1);
		$this->assertTrue($loc->idle == 7);

		$this->assertTrue($loc->p1 == 0);
		$this->assertTrue($loc->p9 == 0);

	}
}