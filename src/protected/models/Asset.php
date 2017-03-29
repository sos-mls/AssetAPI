<?php

Yii::import('application.models._base.BaseAsset');

class Asset extends BaseAsset
{
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
	 * @return string 	The local dir for assets
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
		$name = str_replace('/', '_', Yii::app()->random->file_name());
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
	 * @return string 	The asset URL.
	 */
	public function getURL() {
		return Yii::app()->params->relative_asset_dir . $this->file_name;
	}

	/**
	 * Converts all of the asset information to an array
	 * 
	 * @return array All of the asset information.
	 */
	public function toArray() {
		return [
			'public_url' => $this->getURL(),
			'type' => $this->assetType->asset_type,
			'file_name' => $this->file_name,
			'file_size' => $this->file_size,
			'uploaded_name' => $this->uploaded_name,
			'created_at' => $this->created_at,
		];
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
	 * @param  integer $ID The  ID to filter by.
	 * @return Asset 	   A reference to this.
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
}