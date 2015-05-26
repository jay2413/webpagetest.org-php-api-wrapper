<?php namespace WPT;


class TestResult extends Test {

	/**
	 * Location Object
	 */
	//public $location;

	/**
	 * Overrides the parent method to extract
	 * the test runs and the averages.
	 *
	 * @param array 	// Associative array containing test data
	 */
	public function set(array $res) {

		$tRuns = $res['runs'];
		$tAvg = $res['average'];

		parent::set($res);

	}
}