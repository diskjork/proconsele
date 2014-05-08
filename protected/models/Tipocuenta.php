<?php

Yii::import('application.models._base.BaseTipocuenta');

class Tipocuenta extends BaseTipocuenta
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}