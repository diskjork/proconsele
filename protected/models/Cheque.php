<?php

Yii::import('application.models._base.BaseCheque');

class Cheque extends BaseCheque
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}