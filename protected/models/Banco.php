<?php

Yii::import('application.models._base.BaseBanco');

class Banco extends BaseBanco
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}