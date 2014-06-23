<?php

Yii::import('application.models._base.BaseProducto');

class Producto extends BaseProducto
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}