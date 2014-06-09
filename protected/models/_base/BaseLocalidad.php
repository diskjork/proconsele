<?php

/**
 * This is the model base class for the table "localidad".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Localidad".
 *
 * Columns in table "localidad" available as properties of the model,
 * followed by relations of table "localidad" available as properties of the model.
 *
 * @property integer $idlocalidad
 * @property string $nombre
 * @property string $codigopostal
 * @property integer $provincia_idprovincia
 *
 * @property Cliente[] $clientes
 * @property Provincia $provinciaIdprovincia
 * @property Proveedor[] $proveedors
 */
abstract class BaseLocalidad extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'localidad';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Localidad|Localidades', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre, provincia_idprovincia', 'required'),
			array('provincia_idprovincia', 'numerical', 'integerOnly'=>true),
			array('nombre, codigopostal', 'length', 'max'=>45),
			array('codigopostal','length','max'=>4,'min'=>4),
			array('codigopostal', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idlocalidad, nombre, codigopostal, provincia_idprovincia', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'clientes' => array(self::HAS_MANY, 'Cliente', 'localidad_idlocalidad'),
			'provinciaIdprovincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_idprovincia'),
			'proveedors' => array(self::HAS_MANY, 'Proveedor', 'localidad_idlocalidad'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idlocalidad' => Yii::t('app', 'Idlocalidad'),
			'nombre' => Yii::t('app', 'Nombre'),
			'codigopostal' => Yii::t('app', 'Codigo postal'),
			'provincia_idprovincia' => null,
			'clientes' => null,
			'provinciaIdprovincia' => null,
			'proveedors' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idlocalidad', $this->idlocalidad);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('codigopostal', $this->codigopostal, true);
		$criteria->compare('provincia_idprovincia', $this->provincia_idprovincia);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => array('nombre' => false)),
		));
	}
	private $fullName;
	
	public function getFullName()
	{
	    return $this->nombre." -> ".$this->provinciaIdprovincia->nombre;
	}
	
}