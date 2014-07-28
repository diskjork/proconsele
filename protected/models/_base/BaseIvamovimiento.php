<?php

/**
 * This is the model base class for the table "ivamovimiento".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Ivamovimiento".
 *
 * Columns in table "ivamovimiento" available as properties of the model,
 * followed by relations of table "ivamovimiento" available as properties of the model.
 *
 * @property integer $idivamovimiento
 * @property integer $tipomoviento
 * @property string $fecha
 * @property integer $nrocomprobante
 * @property integer $proveedor_idproveedor
 * @property integer $cliente_idcliente
 * @property string $cuitentidad
 * @property string $tipofactura
 * @property double $tipoiva
 * @property double $importeiibb
 * @property double $importeiva
 * @property double $importeneto
 * @property integer $compra_idcompra
 * @property integer $factura_idfactura
 *
 * @property Compras $compraIdcompra
 * @property Factura $facturaIdfactura
 */
abstract class BaseIvamovimiento extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ivamovimiento';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Ivamovimiento|Ivamovimientos', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('tipomoviento, fecha, nrocomprobante, tipofactura, tipoiva, importeiva, importeneto', 'required'),
			array('tipomoviento, nrocomprobante, proveedor_idproveedor, cliente_idcliente, compra_idcompra, factura_idfactura, notacredito_idnotacredito, notacreditoprov_idnotacreditoprov, notadebitoprov_idnotadebitoprov', 'numerical', 'integerOnly'=>true),
			array('tipoiva, importeiibb, importeiva, importeneto', 'numerical'),
			array('cuitentidad', 'length', 'max'=>45),
			array('tipofactura', 'length', 'max'=>1),
			array('proveedor_idproveedor, cliente_idcliente, cuitentidad, importeiibb, compra_idcompra, factura_idfactura, notacredito_idnotacredito, notacreditoprov_idnotacreditoprov, notadebitoprov_idnotadebitoprov', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idivamovimiento, tipomoviento, fecha, nrocomprobante, proveedor_idproveedor, cliente_idcliente, cuitentidad, tipofactura, tipoiva, importeiibb, importeiva, importeneto, compra_idcompra, factura_idfactura, notacredito_idnotacredito, notacreditoprov_idnotacreditoprov, notadebitoprov_idnotadebitoprov', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'compraIdcompra' => array(self::BELONGS_TO, 'Compras', 'compra_idcompra'),
			'facturaIdfactura' => array(self::BELONGS_TO, 'Factura', 'factura_idfactura'),
			'notacreditoIdnotacredito' => array(self::BELONGS_TO, 'Notacredito', 'notacredito_idnotacredito'),
			'proveedorIdproveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_idproveedor'),
			'clienteIdcliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_idcliente'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idivamovimiento' => Yii::t('app', 'Idivamovimiento'),
			'tipomoviento' => Yii::t('app', 'Tipomoviento'),
			'fecha' => Yii::t('app', 'Fecha'),
			'nrocomprobante' => Yii::t('app', 'Nrocomprobante'),
			'proveedor_idproveedor' => Yii::t('app', 'Proveedor Idproveedor'),
			'cliente_idcliente' => Yii::t('app', 'Cliente Idcliente'),
			'cuitentidad' => Yii::t('app', 'Cuitentidad'),
			'tipofactura' => Yii::t('app', 'Tipofactura'),
			'tipoiva' => Yii::t('app', 'Tipoiva'),
			'importeiibb' => Yii::t('app', 'Importeiibb'),
			'importeiva' => Yii::t('app', 'Importeiva'),
			'importeneto' => Yii::t('app', 'Importeneto'),
			'compra_idcompra' => null,
			'factura_idfactura' => null,
			'compraIdcompra' => null,
			'facturaIdfactura' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idivamovimiento', $this->idivamovimiento);
		$criteria->compare('tipomoviento', $this->tipomoviento);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('nrocomprobante', $this->nrocomprobante);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('cuitentidad', $this->cuitentidad, true);
		$criteria->compare('tipofactura', $this->tipofactura, true);
		$criteria->compare('tipoiva', $this->tipoiva);
		$criteria->compare('importeiibb', $this->importeiibb);
		$criteria->compare('importeiva', $this->importeiva);
		$criteria->compare('importeneto', $this->importeneto);
		$criteria->compare('compra_idcompra', $this->compra_idcompra);
		$criteria->compare('factura_idfactura', $this->factura_idfactura);
		$criteria->compare('proveedorIdproveedor', $this->proveedorIdproveedor);
		$criteria->compare('clienteIdcliente', $this->clienteIdcliente);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
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