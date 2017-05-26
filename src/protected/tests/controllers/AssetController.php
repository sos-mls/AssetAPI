<?php

/**
 * Contains the AssetController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * AssetController_Test class. A PHPUnit Test case class.
 *
 * Tests specific functions inside of the Asset controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class AssetController_Test extends CDbTestCase
{
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
        $this->expectOutputString(
            "HTTP/1.1 200 OK\n" .
            "Content-type: application/json\n" .
            '{"info":"https:\/\/bitbucket.org\/scooblyboo\/assetapi"}'
        );

        $assetController = new AssetController(rand(0,1000));
        Reflection::setProperty('generateHeader', 'AssetController', $assetController, false);
        $assetController->actionIndex();
    }
}