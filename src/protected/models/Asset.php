<?php

/**
 * Contains the Asset class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseAsset');


/**
 * The Asset class.
 *
 * Tracks files of a certain type along, and their usage (if they should
 * be collected from the garbage or not).
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class Asset extends BaseAsset
{
    const IS_NOT_USED = 0;
    const IS_USED = 1;

    /**
     *
     *
     * Static Methods
     * 
     * 
     */

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * Gets the asset directory for saving assets locally.
     * @return string   The local dir for assets
     */
    public static function getAssetDir() {
        return str_replace('//', '/', Yii::app()->params->local_asset_dir);
    }

    /**
     * Gets the assets name from the directory given.
     * @param  string $destination The destination or location of the asset
     * @return string              The name of the asset
     */
    public static function getAssetName($destination) {
        return str_replace(Asset::getAssetDir(), "", $destination);
    }

    /**
     * Generates a destination for the Asset.
     * @return string The destition of the file on the server
     */
    public static function generateDestination() {
        $name = str_replace('/', '_', Yii::app()->random->fileName());
        return self::getAssetDir() . $name;
    }

    /**
     *
     *
     * Object Methods
     *
     * 
     */

    /**
     * Gets the URL to the asset.
     * 
     * @return string   The asset URL.
     */
    public function getURL() {
        return Yii::app()->params->relative_asset_dir . $this->file_name;
    }

    /**
     * Converts all of the asset information to an array.
     *
     * The asset contains not only information about its "self" but also all of the
     * files assocaited with it.
     * 
     * @return array All of the asset information.
     */
    public function toArray() {
        $file_array = $this->getFiles();
        $file_array_key = $this->assetType->asset_type . 's';

        return [
            'public_url'    => $this->getURL(),
            'type'          => $this->assetType->asset_type,
            'file_name'     => $this->file_name,
            'uploaded_name' => $this->uploaded_name,
            'is_used'       => $this->is_used,
            'created_at'    => $this->created_at,
            $file_array_key => $file_array,
        ];
    }

    /**
     * Gets all of the files assocaited with the asset depending on the file type.
     *
     * If the file type is of an image it gets all of the images associated with the
     * asset, otherwise it returns a empty array.
     * 
     * @return array All of the files associated with the asset.
     */
    public function getFiles() {
        $files = [];

        if ($this->assetType->asset_type == AssetType::IMAGE) {
            foreach ($this->images as $image) {
                $files[] = $image->toArray();
            }
        }

        return $files;
    }

    /**
     * Deletes all of the associated files and their respective db representations.
     *
     * Goes through all of the current files assocaited with this asset and unlinks the
     * file from the server and deletes its database instance.
     */
    public function deleteFiles() {
        if ($this->assetType->asset_type == AssetType::IMAGE) {
            foreach ($this->images as $image) {
                $absolute_file_path = self::getAssetDir() . $image->file_name;
                unlink($absolute_file_path);
                $image->delete();
            }
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
     * Filters criteria by ID.
     * 
     * @param  integer $ID The ID to filter by.
     * @return Asset       A reference to this.
     */
    public function ID($ID) {
        $this->getDbCriteria()->compare('t.asset_id', $ID);
        return $this;
    }

    /**
     * Filters criteria by file_name.
     * 
     * @param  string $file_name The file name to filter by.
     * @return Asset             A reference to this.
     */
    public function fileName($file_name) {
        $this->getDbCriteria()->compare('t.file_name', $file_name);
        return $this;
    }

    /**
     * Filters the assets that are older than a day old and have not been used yet.
     * 
     * @return Asset A reference to this.
     */
    public function notUsedGarbage() {
        $this->getDbCriteria()->compare('t.is_used', self::IS_NOT_USED);
        $this->getDbCriteria()->compare(
            't.created_at',
            '<' . date(Yii::app()->params->dbDateFormat, strtotime('-80 minutes'))
        );

        return $this;
    }
}