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

class UseController_Test extends TestController
{

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'UseController';
    }

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
                "/use/asset/abc123",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Asset not found."]}}'
            ],
            [
                "/use/asset",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Please send the asset file_name"]}}'
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
     * Tests the actionAsset method error response.
     *
     * @dataProvider input_actionAssetError
     *
     * @param  string $redirect_url    The url that the user is coming from.
     * @param  string $expected_output The expected JSON output
     */
    public function test_actionAssetError($redirect_url = "", $expected_output = "")
    {
        $this->assertControllerResponse('actionAsset',  $redirect_url, $expected_output);
    }
}