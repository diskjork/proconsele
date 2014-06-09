<?php

Yii::import('application.models._base.BaseCliente');

class Cliente extends BaseCliente
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}