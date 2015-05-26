<?php namespace WPT;

use WPT\Location;

class LocationList {

	/**
	 * Base URL of the WebpageTest.org location list
	 *
	 * @var
	 */
	const BASE_URL = 'http://www.webpagetest.org/getLocations.php?f=json';

	/**
	 * Holds a boolean value flag that is set
	 * to true or false depedning on a successful
	 * list retrieval.
	 *
	 * @var
	 */
	private $success;

	/**
	 * Holds an array of Locations
	 * @var
	 */
	private $locations;

	/**
	 * Default constructor. Initializes the
	 * locations array to an empty set.
	 */
	public function __construct()
	{
		$this->locations = array();

		$locs = $this->getLocationList();

		foreach($locs as $loc)
			array_push($this->locations, new Location($loc));
	}

	/**
	 * Returns an array of Location objects
	 * of the current list of testers.
	 *
	 * @return array 	// Array of Location objects
	 */
	public function getList() 
	{
		//$this->locations = array(); 	// Clear array in case called twice

		

		return $this->locations;
	}

	/**
	 * Contacts the WebPageTest.org locations API
	 * and retrieves the current list of testers.
	 * If unsuccessful, returns an empty array.
	 * This method also sets the $success flag  
	 * based on the result of API call.
	 *
	 * @return array 	// Associative array of testers
	 */
	private function getLocationList() {
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL, self::BASE_URL);
		// Execute
		$result = curl_exec($ch);
		// Closing
		curl_close($ch);

		$rs = json_decode($result, true);
		$this->success = ($rs['statusCode'] == 200) ? true : false;

		if(!$this->success)
			return array();

		return $rs['data'];
	}

	/**
	 * Returns an array of Location objects
	 * of the current list of Mobile testers.
	 *
	 * @return array 	// Array of Location objects
	 */
	public function getMobileList() {

		$mobileLocs = array();

		$locs = $this->getList();

		foreach($locs as $loc)
			if($loc->isMobile())
				array_push($mobileLocs, $loc);

		return $mobileLocs;
	}

	/**
	 * Returns an array of Location objects
	 * of the current list of Desktop testers.
	 *
	 * @return array 	// Array of Location objects
	 */
	public function getDesktopList() {

		$desktopLocs = array();

		$locs = $this->getList();

		foreach($locs as $loc)
			if(!$loc->isMobile())
				array_push($desktopLocs, $loc);

		return $desktopLocs;
	}
}