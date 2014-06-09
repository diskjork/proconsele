<?php

Yii::import('application.models._base.BaseProveedor');

class Proveedor extends BaseProveedor
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}