<?php

/**
 * This is the model base class for the table "{{asset_type}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AssetType".
 *
 * Columns in table "{{asset_type}}" available as properties of the model,
 * followed by relations of table "{{asset_type}}" available as properties of the model.
 *
 * @property integer $asset_type_id
 * @property string $asset_type
 *
 * @property Asset[] $assets
 */
abstract class BaseAssetType extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{asset_type}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AssetType|AssetTypes', $n);
	}

	public static function representingColumn() {
		return 'asset_type';
	}

	public function rules() {
		return array(
			array('asset_type', 'required'),
			array('asset_type', 'length', 'max'=>32),
			array('asset_type_id, asset_type', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'assets' => array(self::HAS_MANY, 'Asset', 'asset_type_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'asset_type_id' => Yii::t('app', 'Asset Type'),
			'asset_type' => Yii::t('app', 'Asset Type'),
			'assets' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('asset_type_id', $this->asset_type_id);
		$criteria->compare('asset_type', $this->asset_type, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}