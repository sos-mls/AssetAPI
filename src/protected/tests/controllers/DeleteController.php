<?php

/**
 * Contains the DeleteController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * DeleteController_Test class. A PHPUnit Test case class.
 *
 * Tests image delete functions inside of the Delete controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class DeleteController_Test extends CDbTestCase
{


    /**
     *
     *
     *
     * Input
     *
     *
     *
     */

    /**
     * Gives the redirect url and the expected json output.
     * 
     * @return array An array of the redirect url, and expectedJSON.
     */
    public function input_actionAssetError()
    {
        return [
            [
                "/delete/asset/abc123",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Asset not found."]}}'
            ],
            [
                "/delete/asset",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Not a proper http method type, please send the asset file_name"]}}'
            ]
        ];
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
     * Tests the actionAsset method error responses.
     *
     * @dataProvider input_actionAssetError
     * 
     * @param  string $method          The action to call in the controller.
     * @param  string $redirect_url    The url that the user is coming from.
     * @param  string $expected_output The expected JSON output
     */
    public function test_actionAssetError($redirect_url = "", $expected_output = "")
    {
        $_SERVER['REDIRECT_URL'] = $redirect_url;

        $this->expectOutputString($expected_output);

        $deleteController = new DeleteController(rand(0,1000));
        Reflection::setProperty('generateHeader', 'DeleteController', $deleteController, false);
        $deleteController->actionAsset();
    }
}