<?php

/**
 * Contains the ReadController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * ReadController_Test class. A PHPUnit Test case class.
 *
 * Tests image delete functions inside of the Delete controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class ReadController_Test extends CDbTestCase
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
     * Gives the method, the redirect url and the expected json output.
     * 
     * @return array An array of the method name, redirect url, and expectedJSON.
     */
    public function input_actionMethodError()
    {
        return [
            [
                "actionAsset",
                "/read/asset/abc123",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Asset not found."]}}'
            ],
            [
                "actionAsset",
                "/read/asset",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Not a proper http method type, please send a GET with a name"]}}'
            ],
            [
                "actionImage",
                "/read/image/abc123",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Image not found."]}}'
            ],
            [
                "actionImage",
                "/read/image",
                "HTTP/1.1 424 \n" .
                "Content-type: application/json\n" .
                '{"errors":{"general":["Not a proper http method type, please send a GET with a name"]}}'
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
     * @dataProvider input_actionMethodError
     * 
     * @param  string $method          The action to call in the controller.
     * @param  string $redirect_url    The url that the user is coming from.
     * @param  string $expected_output The expected JSON output
     */
    public function test_actionMethodError($method = "", $redirect_url = "", $expected_output = "")
    {
        $_SERVER['REDIRECT_URL'] = $redirect_url;

        $this->expectOutputString($expected_output);

        $readController = new ReadController(rand(0,1000));
        Reflection::setProperty('generateHeader', 'ReadController', $readController, false);
        Reflection::callMethod($method, 'ReadController', [], $readController);
    }
}