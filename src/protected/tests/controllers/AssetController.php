<?php

/**
 * Contains the AssetController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * AssetController_Test class. A PHPUnit Test case class.
 *
 * Tests specific functions inside of the Asset controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class AssetController_Test extends TestController
{

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'AssetController';
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
     * Tests the actionIndex method.
     */
    public function test_actionIndex()
    {
        $expectedOutput = "HTTP/1.1 200 OK\n" .
            "Content-type: application/json\n" .
            '{"info":"https:\/\/bitbucket.org\/scooblyboo\/assetapi"}';

        $this->assertControllerResponse('actionIndex', '/asset/', $expectedOutput);
    }
}