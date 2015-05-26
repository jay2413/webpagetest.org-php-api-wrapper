<?php namespace WPT;


class TestRun extends Test {

	/**
	 * Raw data of the test run
	 * @var
	 */
	public $rawData;

	/**
	 * Overrides the parent method to extract
	 * the request and resource URLs.
	 *
	 * @param array 	// Associative array containing test data
	 */
	public function set(array $res) {
		
		$this->rawData = $res;

		$this->{'requests'} = ( isset($res['requests']) )? $res['requests'] : array();
		$images = ( isset($res['images']) ) ? $res['images'] : array();
		$rd = ( isset($res['rawData']) ) ? $res['rawData'] : array();

		// Set the images member variables
		foreach($images as $key => $value)
			$this->{$key} = $value;

		// Set the rawData member variables
		foreach($rd as $key => $value)
			$this->{$key} = $value;

		parent::set($res);

	}
}