<?php

/**
 * This is the model base class for the table "ctacteprov".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Ctacteprov".
 *
 * Columns in table "ctacteprov" available as properties of the model,
 * followed by relations of table "ctacteprov" available as properties of the model.
 *
 * @property integer $idctacteprov
 * @property double $debe
 * @property double $haber
 * @property double $saldo
 * @property integer $proveedor_idproveedor
 *
 * @property Proveedor $proveedorIdproveedor
 * @property Detallectacteprov[] $detallectacteprovs
 * @property Ordendepago[] $ordendepagos
 */
abstract class BaseCtacteprov extends GxActiveRecord {
	public $searchprov;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ctacteprov';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Ctacteprov|Ctacteprovs', $n);
	}

	public static function representingColumn() {
		return 'idctacteprov';
	}

	public function rules() {
		return array(
			array('proveedor_idproveedor', 'required'),
			array('proveedor_idproveedor', 'numerical', 'integerOnly'=>true),
			array('debe, haber, saldo', 'numerical'),
			array('debe, haber, saldo', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idctacteprov, debe, haber, saldo, proveedor_idproveedor, searchprov', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'proveedorIdproveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_idproveedor'),
			'detallectacteprovs' => array(self::HAS_MANY, 'Detallectacteprov', 'ctacteprov_idctacteprov'),
			'ordendepagos' => array(self::HAS_MANY, 'Ordendepago', 'ctacteprov_idctacteprov'),
			
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idctacteprov' => Yii::t('app', 'Idctacteprov'),
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'saldo' => Yii::t('app', 'Saldo'),
			'proveedor_idproveedor' => null,
			'proveedorIdproveedor' => null,
			'detallectacteprovs' => null,
			'ordendepagos' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idctacteprov', $this->idctacteprov);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('saldo', $this->saldo);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		//para el filtro de clientes
		//$criteria->with = array('proveedorIdproveedor');
		//$criteria->compare('proveedorIdproveedor.nombre', $this->searchprov->nombre, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			
		));
	}
	public function search2() {
		$criteria = new CDbCriteria;

		$criteria->compare('idctacteprov', $this->idctacteprov);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('saldo', $this->saldo);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		//para el filtro de clientes
		$criteria->with = array('proveedorIdproveedor');
		$criteria->compare('nombre', $this->searchprov->nombre, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
            	'defaultOrder'=>'nombre ASC',
			),
		));
	}
	public function behaviors()
	{
	    return array(
	    	'datetimeI18NBehavior' => array('class' => 'ext.DateTimeI18NBehavior.DateTimeI18NBehavior'),
	    	'ERememberFiltersBehavior' => array(
            	'class' => 'application.components.ERememberFiltersBehavior',
               	'defaults'=>array(),           /* optional line */
               	'defaultStickOnClear'=>false   /* optional line */
           	),
	    
	   ); // 'ext' is in Yii 1.0.8 version. For early versions, use 'application.extensions' instead.
	}
}