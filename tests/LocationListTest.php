<?php

use WPT\LocationList;

class LocationListTest extends PHPUnit_Framework_TestCase {

	private $locations;

	public function setUp() {
		$this->locations = new LocationList();
	}

	public function testGetList() {

		$locs = $this->locations->getList();

		$this->assertTrue(isset($locs[0]->label));
	}

	public function testMobileList() {

		$found = false;
		$mobileLocs = $this->locations->getMobileList();

		foreach($mobileLocs as $loc)
			if($loc->isMobile() && 
				(strpos($loc->label, "Android") === false || strpos($loc->label, "iOS") === false))
				$found = true;
	
		$this->assertFalse($found);
	}

	public function testDesktopList() {

		$found = false;
		$desktopLocs = $this->locations->getDesktopList();

		foreach($desktopLocs as $loc)
			if(!$loc->isMobile() && 
				(strpos($loc->label, "Android") !== false || strpos($loc->label, "iOS") !== false))
				$found = true;
	
		$this->assertFalse($found);
	}
}