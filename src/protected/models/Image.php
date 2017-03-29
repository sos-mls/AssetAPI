<?php

Yii::import('application.models._base.BaseImage');

class Image extends BaseImage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 *
	 *
	 * Scopes
	 *
	 * 
	 */

	/**
	 * Filters criteria by asset_id.
	 * 
	 * @param  integer $assetID The primary key fo the asset.
	 * @return Asset          [description]
	 */
	public function assetID($assetID) {
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