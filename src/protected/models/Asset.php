<?php

Yii::import('application.models._base.BaseAsset');

class Asset extends BaseAsset
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}