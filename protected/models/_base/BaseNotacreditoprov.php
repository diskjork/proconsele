<?php

/**
 * This is the model base class for the table "notacreditoprov".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Notacreditoprov".
 *
 * Columns in table "notacreditoprov" available as properties of the model,
 * followed by relations of table "notacreditoprov" available as properties of the model.
 *
 * @property integer $idnotacreditoprov
 * @property integer $nrodefactura
 * @property integer $tipofactura
 * @property string $fecha
 * @property string $descripcion
 * @property integer $proveedor_idproveedor
 * @property integer $estado
 * @property double $iva
 * @property double $percepcionIIBB
 * @property double $importebruto
 * @property double $ivatotal
 * @property double $importeneto
 * @property double $importeIIBB
 * @property integer $asiento_idasiento
 
 * @property integer $compras_idcompras
 * @property string $nronotacreditoprov
 *
 * @property Asiento[] $asientos
 */
abstract class BaseNotacreditoprov extends GxActiveRecord {
	public $iibb,$vista;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'notacreditoprov';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Notacreditoprov|Notacreditoprovs', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array(' tipofactura, fecha, proveedor_idproveedor, importeneto,  nronotacreditoprov, compras_idcompras', 'required'),
			array('nrodefactura, tipofactura, proveedor_idproveedor, estado, asiento_idasiento', 'numerical', 'integerOnly'=>true),
			array('iva, percepcionIIBB, importebruto, ivatotal, importeneto, importeIIBB', 'numerical'),
			array('descripcion', 'length', 'max'=>150),
			array('nronotacreditoprov', 'length', 'max'=>45),
			array('descripcion, estado, iva, percepcionIIBB, importebruto, ivatotal, importeIIBB, asiento_idasiento', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idnotacreditoprov, nrodefactura, tipofactura, fecha, descripcion, proveedor_idproveedor, estado, iva, percepcionIIBB, importebruto, ivatotal, importeneto, importeIIBB, asiento_idasiento,  compras_idcompras, nronotacreditoprov', 'safe', 'on'=>'search'),
			array('factura_idfactura','validarFactura','on'=>'insert'),
	);
	}

	public function relations() {
		return array(
			'asientos' => array(self::HAS_MANY, 'Asiento', 'notacreditoprov_idnotacreditoprov'),
			'proveedorIdproveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_idproveedor'),
			'comprasIdcompras' => array(self::BELONGS_TO, 'Compras', 'compras_idcompras'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idnotacreditoprov' => Yii::t('app', 'Idnotacreditoprov'),
			'nrodefactura' => Yii::t('app', 'Nro factura'),
			'tipofactura' => Yii::t('app', 'Tipo factura'),
			'fecha' => Yii::t('app', 'Fecha'),
			'descripcion' => Yii::t('app', 'Descripción'),
			'proveedor_idproveedor' => Yii::t('app', 'Proveedor'),
			'estado' => Yii::t('app', 'Estado'),
			'iva' => Yii::t('app', 'IVA'),
			'percepcionIIBB' => Yii::t('app', 'IIBB'),
			'importebruto' => Yii::t('app', 'Importebruto'),
			'ivatotal' => Yii::t('app', 'Importe IVA'),
			'importeneto' => Yii::t('app', 'Importeneto'),
			'importeIIBB' => Yii::t('app', 'Importe Iibb'),
			'asiento_idasiento' => Yii::t('app', 'Asiento '),
			
			'compras_idcompras' => Yii::t('app', 'Compra Relacionada'),
			'nronotacreditoprov' => Yii::t('app', 'Nro. Nota crédito'),
			'asientos' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idnotacreditoprov', $this->idnotacreditoprov);
		$criteria->compare('nrodefactura', $this->nrodefactura);
		$criteria->compare('tipofactura', $this->tipofactura);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		$criteria->compare('estado', $this->estado);
		$criteria->compare('iva', $this->iva);
		$criteria->compare('percepcionIIBB', $this->percepcionIIBB);
		$criteria->compare('importebruto', $this->importebruto);
		$criteria->compare('ivatotal', $this->ivatotal);
		$criteria->compare('importeneto', $this->importeneto);
		$criteria->compare('importeIIBB', $this->importeIIBB);
		$criteria->compare('asiento_idasiento', $this->asiento_idasiento);
		
		$criteria->compare('compras_idcompras', $this->compras_idcompras);
		$criteria->compare('nronotacreditoprov', $this->nronotacreditoprov, true);

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
	public function validarFactura($attribute,$params){
			$check=Compras::model()->find("idcompra=:id AND (estado=1 OR estado=2)",array(':id'=>$this->compras_idcompras));
			if(isset($check->idcompra)){
				$this->addError('compras_idcompras', 'La Factura - Compra ya tiene una Nota de Credito Emitida');
		}
	}
}