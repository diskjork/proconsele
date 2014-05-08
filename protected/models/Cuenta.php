<?php

Yii::import('application.models._base.BaseCuenta');

class Cuenta extends BaseCuenta
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}