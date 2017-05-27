<?php

/**
 * Contains the GarbageCollectionCommand_Test class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.commands.GarbageCollectionCommand');

use Common\Reflection;

/**
 * GarbageCollectionCommand_Test class. A PHPUnit Test case class.
 *
 * Tests image creation functions inside of the Create controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class GarbageCollectionCommand_Test extends TestController
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
     * Contains an array of test files for creating.
     * 
     * @return array An array of files
     */
    public function input_run()
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
     * Adds a file to the $_FILE variable and calls the create controller
     * 
     * @dataProvider input_run
     */
    public function test_run($file_path = "")
    {
        $garbage_collection = new GarbageCollectionCommand("some_name", "some_runner");

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
        $controller = new CreateController(rand(0,1000));
        Reflection::setProperty('allowGenerateHeader', 'CreateController', $controller, false);
        Reflection::callMethod('actionIndex', 'CreateController', [], $controller);
        $response = ob_get_contents();
        ob_end_clean();
        
        $json_response = str_replace("HTTP/1.1 200 OK\n", "", $response);
        $json_response = str_replace("Content-type: application/json\n", "", $json_response);
        $asset_json = json_decode($json_response);

        $asset = Asset::model()->fileName($asset_json->public_url)->find();
        $asset->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0] - 84600));
        $asset->save();

        $garbage_collection->run([]);

        $this->assertFalse(Asset::model()->fileName($asset_json->public_url)->exists());
    }
}