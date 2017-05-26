<?php

/**
 * Contains the CreateController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * CreateController_Test class. A PHPUnit Test case class.
 *
 * Tests image creation functions inside of the Create controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class CreateController_Test extends TestController
{

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'CreateController';
    }

    /**
     *
     *
     *
     * Test
     *
     *
     *
     */

    /**
     * Tests the actionIndex method errpr resonse.
     */
    public function test_actionIndexError()
    {
        $expected_output = "HTTP/1.1 424 \n" .
            "Content-type: application/json\n" .
            '{"errors":{"general":["Not a proper http method type, please send a FILE"]}}';

        $this->assertControllerResponse('actionIndex',  '/create/', $expected_output);
    }
}