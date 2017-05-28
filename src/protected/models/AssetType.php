<?php

/**
 * Contains the AssetType class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseAssetType');

/**
 * The AssetType class.
 *
 * Tracks the current type of an asset and determines the type given the
 * asset itself.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class AssetType extends BaseAssetType
{
    const IMAGE = 'image';
    const VIDEO = 'video';
    const FILE  = 'file';

    private static $_valid_video_types = [
        'video/mp4',
        'video/mpeg',
        'application/ogg',
        'video/webm',
        'video/quicktime'
    ];

    private static $_valid_image_types = [
        IMAGETYPE_GIF,
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
    ];

    /**
     *
     *
     * Static Methods
     *
     *
     */
    
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Gets the Asset type from the current file path.
     *
     * @param  string $absolute_file_path The file path of the image on the server.
     * @return AssetType                  A representation of the type of file given.
     */
    public static function getType($absolute_file_path)
    {
        if (in_array(mime_content_type($absolute_file_path), self::$_valid_video_types)) {
            return self::model()->assetType(self::VIDEO)->find();
        } else if (in_array(exif_imagetype($absolute_file_path), self::$_valid_image_types)) {
            return self::model()->assetType(self::IMAGE)->find();
        } else {
            return self::model()->assetType(self::FILE)->find();
        }
    }

    /**
     *
     *
     * Scopes
     *
     *
     */
    
    /**
     * Filters criteria by asset_type of the asset type.
     *
     * @param  string $asset_type The asset_type of the asset type.
     * @return Asset_Type         A reference to this.
     */
    public function assetType($asset_type)
    {
        $this->getDbCriteria()->compare('t.asset_type', $asset_type);
        return $this;
    }
}