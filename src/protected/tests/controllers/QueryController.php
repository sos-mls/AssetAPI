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
    const EXPECTED_HEIGHT_KEY = 'expected_height';
    const EXPECTED_WIDTH_KEY = 'expected_width';

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
        $uploaded_aspect_name = 'contain_aspect_true' . time();
        return [
            [
                TestController::COMPARISON_DIRECTORY . '/contain_aspect_true.png',
                $uploaded_aspect_name,
                [
                    'actions' => [
                        [
                            Action_Image::NAME_KEY    => "thumbnail",
                            Action_Image::WIDTH_KEY   => 150,
                            Action_Image::HEIGHT_KEY  => 150,
                            self::EXPECTED_WIDTH_KEY  => 150,
                            self::EXPECTED_HEIGHT_KEY => 150
                        ]
                    ]
                ],
                [
                    'uploaded_name' => $uploaded_aspect_name,
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
     * @param  string $file_path The path to a file
     */
    public function test_actionAsset($file_path = "", $file_name, $post, $get)
    {
        $this->controller_name = 'CreateController';

        $_FILES = [
            'file' => [
                'tmp_name' => $file_path,
                'name' => $file_name
            ]
        ];

        $_POST = $post;

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
        // $query_json = json_decode($json_response);

        $this->assertEquals($json_response, "[" . $create_json_response . "]");

    }

    /**
     * Confirms that the asset images created are of same style as the actions passed 
     * in the post.
     * 
     * @param  Asset  $asset The asset created.
     */
    private function assertCreationEquals(Asset $asset) {
        foreach ($_POST['actions'] as $action) {

            if (count($asset->images) > 0)
            {
                $size_exists = false;
                foreach ($asset->images as $image) {
                    if ($image->width <= $action[self::EXPECTED_WIDTH_KEY] + 1 &&
                        $image->width >= $action[self::EXPECTED_WIDTH_KEY] - 1 &&
                        $image->height <= $action[self::EXPECTED_HEIGHT_KEY] + 1 &&
                        $image->height >= $action[self::EXPECTED_HEIGHT_KEY] - 1) {
                        $size_exists = true;
                    }
                }   
                $this->assertTrue($size_exists);
            }

        }
    }
}