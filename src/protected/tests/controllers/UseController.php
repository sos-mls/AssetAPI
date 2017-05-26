<?php

/**
 * Contains the UseController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * UseController_Test class. A PHPUnit Test case class.
 *
 * Tests asset usage function inside of the Use controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class UseController_Test extends CDbTestCase
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
     * Tests the actionAsset method when no hashid is in the redirect url.
     */
    public function test_actionAssetNoHash()
    {
        $_SERVER['REDIRECT_URL'] = "/use/asset";

        $this->expectOutputString(
            "HTTP/1.1 424 \n" .
            "Content-type: application/json\n" .
            '{"errors":{"general":["Please send the asset file_name"]}}'
        );

        $useController = new UseController(rand(0,1000));
        Reflection::setProperty('generateHeader', 'UseController', $useController, false);
        $useController->actionAsset();
    }

    /**
     * Tests the actionAsset method when a hashid exists in the url but not in the DB.
     */
    public function test_actionAssetHashInvalid()
    {
        $_SERVER['REDIRECT_URL'] = "/use/asset/abc123";

        $this->expectOutputString(
            "HTTP/1.1 424 \n" .
            "Content-type: application/json\n" .
            '{"errors":{"general":["Asset not found."]}}'
        );

        $useController = new UseController(rand(0,1000));
        Reflection::setProperty('generateHeader', 'UseController', $useController, false);
        $useController->actionAsset();
    }
}