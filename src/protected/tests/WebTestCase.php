<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends \PHPUnit_Framework_TestCase {
	private $restful_api;

	/**
	 * Sets up before each test method runs.
	 */
	protected function setUp() {
		$restful_api = new ApiController(1);
	}

	public function test_true()
	{
		
	}
}