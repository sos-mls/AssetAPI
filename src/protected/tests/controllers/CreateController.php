<?php

/**
 * Contains the CreateController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

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
     * Input
     *
     *
     *
     */

    /**
     * Contains an array of test files for creating.
     * 
     * @return array An array of files
     */
    public function input_actionAssetCreate()
    {
        return [
            [
                TestController::COMPARISON_DIRECTORY . '/contain_aspect_true.png'
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
     * Tests the actionIndex method errpr resonse.
     */
    public function test_actionIndexError()
    {
        $expected_output = "HTTP/1.1 424 \n" .
            "Content-type: application/json\n" .
            '{"errors":{"general":["Not a proper http method type, please send a FILE"]}}';

        $this->assertControllerResponse('actionIndex',  '/create/', $expected_output);
    }

    /**
     * Adds a file to the $_FILE variable and calls the create controller
     * 
     * @dataProvider input_actionAssetCreate
     */
    public function test_actionAssetCreate($file_path = "")
    {
        $_FILES = [
            'file' => [
                'tmp_name' => $file_path,
                'name' => 'Hello'
            ]
        ];

        $expected_output = "HTTP/1.1 200 OK\n" .
                "Content-type: application/json\n" .
                '{"success":"Asset will be deleted."}';

        $_SERVER['REDIRECT_URL'] = '/create/';
        ob_start();
        $controller = new $this->controller_name(rand(0,1000));
        Reflection::setProperty('allowGenerateHeader', $this->controller_name, $controller, false);
        Reflection::callMethod('actionIndex', $this->controller_name, [], $controller);
        $response = ob_get_contents();
        ob_end_clean();
        
        $json_response = str_replace("HTTP/1.1 200 OK\n", "", $response);
        $json_response = str_replace("Content-type: application/json\n", "", $json_response);
        $asset_json = json_decode($json_response);
        
        $this->assertTrue(Asset::model()->fileName($asset_json->public_url)->exists());
    }
}