<?php

class DefaultController extends CController
{
	const DEFAULT_LAYOUT = 'default';

	public $layout = self::DEFAULT_LAYOUT;

	public function actionIndex()
	{
		$this->render('/default/index');
	}
}
