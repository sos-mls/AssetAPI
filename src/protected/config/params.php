<?php

use Asset\Action\Image as Action_Image;

// this contains the application parameters that can be maintained via GUI

return [
    // this is displayed in the header section
    'title' => 'Asset Api',

    // the login duration when a user selects 'remember me'
    'loginDuration' => 3600 * 24 * 30, // 30 days

    // this is used in error pages
    'adminEmail' => 'services@skeleton.com',

    // the copyright information displayed in the footer section
    'copyrightInfo' => 'Copyright &copy; 2016 by Asset Api',

    // The date format used by the database
    'dbDateFormat' => 'Y-m-d H:i:s',

    'global_root_dir' => array_key_exists('HTTP_HOST', $_SERVER) ? 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/' : '',

    'local_asset_dir' => (getenv("DOCUMENT_ROOT") ? getenv("DOCUMENT_ROOT") : realpath(dirname(__FILE__) . '/../..')) . '/assets/',

    'relative_asset_dir' =>array_key_exists('HTTP_HOST', $_SERVER) ?  '//' . $_SERVER['HTTP_HOST'] . '/read/asset/' : '',

    'relative_image_dir' => array_key_exists('HTTP_HOST', $_SERVER) ? '//' . $_SERVER['HTTP_HOST'] . '/read/image/' : '',

    'relative_document_dir' => array_key_exists('HTTP_HOST', $_SERVER) ? '//' . $_SERVER['HTTP_HOST'] . '/read/document/' : '',

    'asset_library' => [
        'valid_image_types' => [
            IMAGETYPE_GIF,
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
        ],
        'valid_document_types' => [
            "text/plain",
            "text/csv",
            "application/vnd.ms-excel"
        ],
        'actions' => [
            [
                Action_Image::NAME_KEY              => "original",
                Action_Image::WIDTH_KEY             => 1000,
                Action_Image::HEIGHT_KEY            => 1000,
                Action_Image::KEEP_ASPECT_RATIO_KEY => true,
                Action_Image::PADDING_KEY           => false,
            ],
            [
                Action_Image::NAME_KEY   => "thumbnail",
                Action_Image::WIDTH_KEY  => 150,
                Action_Image::HEIGHT_KEY => 150
            ]
        ]
    ]
];