<?php namespace WPT;

class Location {

	/**
	 * Boolean flag to label the location as mobile or not
	 * @var
	 */	
	private $is_mobile;

	/**
	 * Holds the id of the test location
	 * @var
	 */
	public $id;

	/**
	 * Holds the label of the test location
	 * @var
	 */
	public $label;

	/**
	 * Holds the location of the test location
	 * @var
	 */
	public $location;

	/**
	 * Holds the browser type the test location
	 * @var
	 */
	public $browser;

	/**
	 * Holds the number of high priority tests
	 * currently running
	 * @var
	 */
	public $highPriority;

	/**
	 * Holds the number of low priority tests
	 * currently running
	 * @var
	 */
	public $lowPriority;

	/**
	 * Holds the number of normal priority tests
	 * currently running
	 * @var
	 */
	public $testing;

	/**
	 * Holds the number of idle testers
	 * @var
	 */
	public $idle;



	/**
	 * Default constructor. Accepts an optional
	 * parameter of an associative array containing
	 * values for a given WebPageTest.org test
	 * location. It is assumed that the array is
	 * formatted according to the API doc.
	 *
	 * @param array 	// Associative array containing test location data
	 */
	public function __construct(array $loc = array())
	{
		if(count($loc) != 0)
			$this->set($loc);
	}

	/**
	 * Sets the aforementioned member variables
	 * with the values as given by the passed
	 * associative array.
	 *
	 * @param array 	// Associative array containing test location data
	 */
	public function set(array $loc) {

		$this->label = $loc['Label'];
		$this->location = $loc['location'];
		$this->browser = $loc['Browser'];
		$this->idle = array_pop($loc['PendingTests']);
		$this->testing = array_pop($loc['PendingTests']);
		$this->lowPriority = array_pop($loc['PendingTests']);
		$this->highPriority = array_pop($loc['PendingTests']);
		array_pop($loc['PendingTests']);

		$this->id = $this->location . ":" . $this->browser;

		foreach($loc['PendingTests'] as $key => $value)
			$this->{$key} = $value;

		$this->is_mobile = (strpos($this->label, "Android") !== false || strpos($this->label, "iOS") !== false);

	}

	/**
	 * Method to return a boolean a flag
	 * determining if the Location is
	 * is mobile or not.
	 *
	 * @return bool
	 */
	public function isMobile() {

		return $this->is_mobile;
	}
}