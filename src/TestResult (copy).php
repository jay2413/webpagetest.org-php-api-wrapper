<?php namespace WPT;


class TestResult {

	/**
	 * Location Object
	 */
	//public $location;

	/**
	 * Default constructor. Accepts an optional
	 * parameter of an associative array containing
	 * values for a given WebPageTest.org test.
	 * It is assumed that the array is formatted
	 * according to the API doc.
	 *
	 * @param array 	// Associative array containing test data
	 */
	public function __construct(array $res = array())
	{
		if(count($res) != 0)
			$this->set($res);
	}

	/**
	 * Sets the aforementioned member variables
	 * with the values as given by the passed
	 * associative array.
	 *
	 * @param array 	// Associative array containing test data
	 */
	public function set(array $res) {

		$tRuns = $res['runs'];
		$tAvg = $res['average'];

		$member_var_array = $this->cleanArray($res);
		
		foreach($member_var_array as $key => $value)
			$this->{$key} = $value;

	}

	/**
	 * Returns an array with all other arrays
	 * removed.
	 *
	 * @return array
	 */
	private function cleanArray(array $data) {

		foreach($data as $key => $value)
			if(gettype($data[$key]) === "array")
				unset($data[$key]);

		return $data;
	}
}