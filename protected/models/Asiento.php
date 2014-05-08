<?php

Yii::import('application.models._base.BaseAsiento');

class Asiento extends BaseAsiento
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}