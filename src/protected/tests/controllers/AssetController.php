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
            '{"api":{"create":"https:\/\/github.com\/sos-mls\/AssetAPI\/wiki\/API-Create","use":"https:\/\/github.com\/sos-mls\/AssetAPI\/wiki\/API-Use","read":"https:\/\/github.com\/sos-mls\/AssetAPI\/wiki\/API-Read","delete":"https:\/\/github.com\/sos-mls\/AssetAPI\/wiki\/API-Delete"},"settings":"https:\/\/github.com\/sos-mls\/AssetAPI\/wiki\/Settings","testing":"https:\/\/github.com\/sos-mls\/AssetAPI\/wiki\/Testing"}';

        $this->assertControllerResponse('actionIndex', '/asset/', $expectedOutput);
    }
}