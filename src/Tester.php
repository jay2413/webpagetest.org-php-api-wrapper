<?php namespace WPT;

use WPT\Location;

class Tester {

	/**
	 * Base URL of the WebpageTest.org test api
	 *
	 * @var
	 */
	const BASE_URL = 'http://www.webpagetest.org/runtest.php?';

	/**
	 * Holds the Location to be used to run the test.
	 *
	 * @var
	 */
	private $location;

	/**
	 * Sets the defualt browser to use
	 *
	 * @var
	 */
	protected $browser = "Chrome";

	/**
	 * Sets the defualt speed type to use
	 *
	 * @var
	 */
	protected $speed = "Cable";

	/**
	 * Sets the defualt API options
	 *
	 * @var
	 */
	protected $options = array(
		'k'			=> '',
		'fvonly' 	=> 1,
		'private' 	=> 1,
		'f' 		=> 'json',
		'noopt' 	=> 1,
		'timeline' 	=> 1
		);


	/**
	 * Creates a new WPT instance. Requires a WPT API key and
	 * a Location object. Accepts an optional associative array
	 * of options to be used. This assumes the options are 
	 * valid as per the API specifications. See:
	 * https://sites.google.com/a/webpagetest.org/docs/advanced-features/webpagetest-restful-apis
	 *
	 * @param string 	// WebPageTest API Key
	 * @param Location 	// Location to be used
	 * @param array 	// Associative array of options to be applied
	 */
	public function __construct($api_key, Location $loc, array $opts = array())
	{
		$this->location = $loc;

		unset($opts['f']); // Ensure there was no attempt to override the respone type

		$this->options = array_merge($this->options, $opts);
		$this->options['k'] = $api_key;
	}

	/**
	 * Override the default browser setting by
	 * setting the browser to the given browser.
	 *
	 * @param string 	// Browser to be used
	 */
	public function setBrowser($myBrowser)
	{
		$this->browser = $myBrowser;
	}

	/**
	 * Override the default speed setting by
	 * setting the speed to the given speed.
	 *
	 * @param string 	// Speed to be used
	 */
	public function setSpeed($mySpeed)
	{
		$this->speed = $mySpeed;
	}

	/**
	 * Builds and returns the full API URL
	 * to be used for this request.
	 *
	 * @param string 	// The URL to be tested
	 * @return string 	// The URL to request
	 */
	public function getRequestURL($url) {
		
		$str = self::BASE_URL;

		$this->options['location'] = $this->location->location . ":" .
			$this->browser . "." . $this->speed;

		foreach($this->options as $key => $value)
			$str .= $key . '=' . $value . '&';

		$str .= 'url=' . $url;

		return $str;
	}

	/**
	 * Contacts the WebPageTest.org tester API
	 * and initiates a test.
	 *
	 * @param string 	// The URL to be tested
	 * @return array 	
	 */
	public function runTest($url) {
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL, $this->getRequestURL($url));
		// Execute
		$result = curl_exec($ch);
		// Closing
		curl_close($ch);

		$rs = json_decode($result, true);

		if($rs['statusCode'] == 200) {

			foreach($rs['data'] as $key => $value)
				$this->{$key} = $value;

			return $rs['data']['testId'];
		}
		else
			return "FAILED";

	}

}