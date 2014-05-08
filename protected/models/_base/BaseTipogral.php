<?php

/**
 * This is the model base class for the table "tipogral".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Tipogral".
 *
 * Columns in table "tipogral" available as properties of the model,
 * followed by relations of table "tipogral" available as properties of the model.
 *
 * @property integer $idtipogral
 * @property string $nombre
 *
 * @property Tipocuenta[] $tipocuentas
 */
abstract class BaseTipogral extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tipogral';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tipogral|Tipograls', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>45),
			array('idtipogral, nombre', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'tipocuentas' => array(self::HAS_MANY, 'Tipocuenta', 'tipogral_idtipogral'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idtipogral' => Yii::t('app', 'Idtipogral'),
			'nombre' => Yii::t('app', 'Nombre'),
			'tipocuentas' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idtipogral', $this->idtipogral);
		$criteria->compare('nombre', $this->nombre, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}