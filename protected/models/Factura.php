<?php

Yii::import('application.models._base.BaseFactura');

class Factura extends BaseFactura
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}