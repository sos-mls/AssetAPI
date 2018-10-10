<?php

/**
 * Contains the QueryController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;
use Asset\Action\Image as Action_Image;
use Asset\File\Image as File_Image;

/**
 * QueryController_Test class. A PHPUnit Test case class.
 *
 * Tests image delete functions inside of the Delete controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class QueryController_Test extends TestController
{
    const DEFAULT_FILE_PATH = TestController::COMPARISON_DIRECTORY . '/contain_aspect_true.png';
    const EXPECTED_HEIGHT_KEY = 'expected_height';
    const EXPECTED_WIDTH_KEY = 'expected_width';
    const THUMBNAIL_POST = [
        'actions' => [
            [
                Action_Image::NAME_KEY    => "thumbnail",
                Action_Image::WIDTH_KEY   => 150,
                Action_Image::HEIGHT_KEY  => 150,
                self::EXPECTED_WIDTH_KEY  => 150,
                self::EXPECTED_HEIGHT_KEY => 150
            ]
        ]
    ];

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'QueryController';
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
     * Contains an array of test files for uploading.
     * 
     * @return array An array of files
     */
    public function input_actionAsset()
    {
        $basic_test_name = 'basic_test' . time() . rand(0, 10000);
        $type_test_name = 'type_test' . time() . rand(0, 10000);
        $used_test_name = 'used_test' . time() . rand(0, 10000);

        return [
            [
                $basic_test_name,
                [
                    'uploaded_name' => $basic_test_name,
                ]
            ],
            [
                $type_test_name,
                [
                    'type' => AssetType::IMAGE,
                    'uploaded_name' => $type_test_name,
                ]
            ],
            [
                $used_test_name,
                [
                    'is_used' => Asset::IS_NOT_USED,
                    'type' => AssetType::IMAGE,
                    'uploaded_name' => $used_test_name,
                ]
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
     * Creates an asset, calls the use controller and confirms the response of the 
     * read asset.
     * 
     * @dataProvider input_actionAsset
     * 
     * @param  string $file_name Name of the file to be referenced when querying and uploading.
     * @param  array  $get       Data to provide to the query API.
     */
    public function test_actionAsset($file_name = "", $get = [])
    {
        $create_json_response = $this->createAsset($file_name);

        $_GET = $get;

        $_SERVER['REDIRECT_URL'] = '/query/asset/';
        ob_start();
        $controller = new $this->controller_name(rand(0,1000));
        Reflection::setProperty('allowGenerateHeader', $this->controller_name, $controller, false);
        Reflection::callMethod('actionAsset', $this->controller_name, [], $controller);
        $response = ob_get_contents();
        ob_end_clean();

        $json_response = str_replace("HTTP/1.1 200 OK\n", "", $response);
        $json_response = str_replace("Content-type: application/json\n", "", $json_response);

        $this->assertEquals("[" . $create_json_response . "]", $json_response);
    }

    /**
     * Tests the actionAsset method error resonse.
     */
    public function test_actionAssetError()
    {
        $expected_output = "HTTP/1.1 424 \n" .
            "Content-type: application/json\n" .
            '{"errors":{"general":["Please send a valid GET. Include type, uploaded_name or is_used"]}}';

        $this->assertControllerResponse('actionAsset',  '/query/asset/', $expected_output);
    }

    /**
     * Creates an asset using the create API.
     * 
     * @param  string $file_name Name of the file to be referenced when querying and uploading.
     * @return string            The create JSON string from the creation API.
     */
    private function createAsset($file_name = "")
    {
        $this->controller_name = 'CreateController';

        $_FILES = [
            'file' => [
                'tmp_name' => self::DEFAULT_FILE_PATH,
                'name' => $file_name
            ]
        ];

        $_POST = self::THUMBNAIL_POST;

        $_SERVER['REDIRECT_URL'] = '/create/';
        ob_start();
        $controller = new $this->controller_name(rand(0,1000));
        Reflection::setProperty('allowGenerateHeader', $this->controller_name, $controller, false);
        Reflection::callMethod('actionIndex', $this->controller_name, [], $controller);
        $response = ob_get_contents();
        ob_end_clean();

        $json_response = str_replace("HTTP/1.1 200 OK\n", "", $response);
        $create_json_response = str_replace("Content-type: application/json\n", "", $json_response);

        $this->controller_name = 'QueryController';

        return $create_json_response;
    }
}