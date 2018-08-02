<?php

/**
 * Contains the AssetType_Test class.
 * 
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * AssetType_Test class. A PHPUnit Test case class.
 *
 * Tests specific functions inside of the AssetType model class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class AssetType_Test extends CDbTestCase
{
    const COMPARISON_DIRECTORY = 'src/protected/tests/test_comparison';

    protected $fixtures=array(
        'asset_types'=>'AssetType'
    );

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
     * A lsit of files with their expected AssetType
     * 
     * @return array An array of Orientation
     */
    public function input_getType()
    {
        return [
            [
                self::COMPARISON_DIRECTORY . '/big_file.jpg',
                AssetType::IMAGE
            ],
            [
                self::COMPARISON_DIRECTORY . '/contain_aspect_true.png',
                AssetType::IMAGE
            ],
            [
                self::COMPARISON_DIRECTORY . '/default_image.png',
                AssetType::IMAGE
            ],
            [
                self::COMPARISON_DIRECTORY . '/big_buck_bunny.mp4',
                AssetType::VIDEO
            ],
            [
                self::COMPARISON_DIRECTORY . '/big_buck_bunny.ogv',
                AssetType::VIDEO
            ],
            [
                self::COMPARISON_DIRECTORY . '/big_buck_bunny.webm',
                AssetType::VIDEO
            ],
            [
                self::COMPARISON_DIRECTORY . '/sample_iTunes.mov',
                AssetType::VIDEO
            ],
            [
                self::COMPARISON_DIRECTORY . '/test-mpeg.mpg',
                AssetType::VIDEO
            ],
            [
                self::COMPARISON_DIRECTORY . '/eckroth-coffeehouse_conversation.txt',
                AssetType::DOCUMENT
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
     * Tests the forge.
     *
     * @dataProvider input_getType
     *
     * @param  string  $path          The file path.
     * @param  array   $expected_type The expected Asset Type.
     */
    public function test_getType($path, $expected_type)
    {
        $asset_type = AssetType::getType($path);
        $this->assertEquals($expected_type, $asset_type->asset_type);
    }
}