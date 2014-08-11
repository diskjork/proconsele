<?php

/**
 * This is the model base class for the table "ctactecliente".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Ctactecliente".
 *
 * Columns in table "ctactecliente" available as properties of the model,
 * followed by relations of table "ctactecliente" available as properties of the model.
 *
 * @property integer $idctactecliente
 * @property integer $cliente_idcliente
 * @property double $debe
 * @property double $haber
 * @property double $saldo
 *
 * @property Cliente $clienteIdcliente
 * @property Detallectactecliente[] $detallectacteclientes
 */
abstract class BaseCtactecliente extends GxActiveRecord {
	public $searchcliente;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ctactecliente';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Ctactecliente|Ctacteclientes', $n);
	}

	public static function representingColumn() {
		return 'idctactecliente';
	}

	public function rules() {
		return array(
			array('cliente_idcliente', 'required'),
			array('cliente_idcliente', 'numerical', 'integerOnly'=>true),
			array('debe, haber, saldo', 'numerical'),
			array('debe, haber, saldo', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idctactecliente, cliente_idcliente, debe, haber, saldo', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'clienteIdcliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_idcliente'),
			'detallectacteclientes' => array(self::HAS_MANY, 'Detallectactecliente', 'ctactecliente_idctactecliente'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idctactecliente' => Yii::t('app', 'Idctactecliente'),
			'cliente_idcliente' => null,
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'saldo' => Yii::t('app', 'Saldo'),
			'clienteIdcliente' => null,
			'detallectacteclientes' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idctactecliente', $this->idctactecliente);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('saldo', $this->saldo);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function search2() {
		$criteria = new CDbCriteria;

		$criteria->compare('idctactecliente', $this->idctactecliente);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('saldo', $this->saldo);
		
		//para el filtro de clientes
		$criteria->with = array('clienteIdcliente');
		$criteria->compare('nombre', $this->searchcliente->nombre, true);

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