<?php

/**
 * This is the model base class for the table "tipodecontribuyente".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Tipodecontribuyente".
 *
 * Columns in table "tipodecontribuyente" available as properties of the model,
 * followed by relations of table "tipodecontribuyente" available as properties of the model.
 *
 * @property integer $idtipocontribuyente
 * @property string $nombre
 * @property double $iva
 *
 * @property Cliente[] $clientes
 * @property Proveedor[] $proveedors
 */
abstract class BaseTipodecontribuyente extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tipodecontribuyente';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tipodecontribuyente|Tipodecontribuyentes', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre, iva', 'required'),
			array('iva', 'numerical'),
			array('nombre', 'length', 'max'=>45),
			array('idtipocontribuyente, nombre, iva', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'clientes' => array(self::HAS_MANY, 'Cliente', 'tipodecontribuyente_idtipocontribuyente'),
			'proveedors' => array(self::HAS_MANY, 'Proveedor', 'tipodecontribuyente_idtipocontribuyente'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idtipocontribuyente' => Yii::t('app', 'Idtipocontribuyente'),
			'nombre' => Yii::t('app', 'Descripción'),
			'iva' => Yii::t('app', 'Iva'),
			'clientes' => null,
			'proveedors' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idtipocontribuyente', $this->idtipocontribuyente);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('iva', $this->iva);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}