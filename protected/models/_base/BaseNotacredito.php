<?php

/**
 * This is the model base class for the table "notacredito".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Notacredito".
 *
 * Columns in table "notacredito" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $idnotacredito
 * @property integer $nrodefactura
 * @property string $fecha
 * @property integer $formadepago
 * @property integer $cliente_idcliente
 * @property integer $estado
 * @property double $descrecar
 * @property integer $tipodescrecar
 * @property double $iva
 * @property double $retencionIIBB
 * @property double $cantidadproducto
 * @property integer $producto_idproducto
 * @property string $nombreproducto
 * @property double $precioproducto
 * @property double $stbruto_producto
 * @property integer $asiento_idasiento
 * @property double $impuestointerno
 * @property string $desc_imp_interno
 * @property double $importebruto
 * @property double $ivatotal
 * @property double $importeneto
 * @property double $importeIIBB
 * @property double $importeImpInt
 * @property integer $factura_idfactura
 * @property integer $tipofactura
 * @property string $nronotacredito
 *
 */
abstract class BaseNotacredito extends GxActiveRecord {
	public $desRec, $iibb, $impInt, $vista, $perciva;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'notacredito';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Notacredito|Notacreditos', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('fecha, formadepago, cliente_idcliente, cantidadproducto, producto_idproducto, nombreproducto, precioproducto, stbruto_producto, importebruto, importeneto,  tipofactura, nronotacredito', 'required'),
			array('nrodefactura, formadepago, cliente_idcliente, estado, tipodescrecar, producto_idproducto, asiento_idasiento, factura_idfactura, tipofactura', 'numerical', 'integerOnly'=>true),
			array('descrecar, iva, retencionIIBB, cantidadproducto, precioproducto, stbruto_producto, impuestointerno, importebruto, ivatotal, importeneto, importeIIBB, importeImpInt, netogravado, percepcion_iva, importe_per_iva', 'numerical'),
			array('nombreproducto, desc_imp_interno', 'length', 'max'=>100),
			array('nronotacredito', 'length', 'max'=>55),
			array('estado, descrecar, tipodescrecar, iva, retencionIIBB, asiento_idasiento, impuestointerno, desc_imp_interno, ivatotal, importeIIBB, importeImpInt, netogravado, percepcion_iva, importe_per_iva', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idnotacredito, nrodefactura, fecha, formadepago, cliente_idcliente, estado, descrecar, tipodescrecar, iva, retencionIIBB, cantidadproducto, producto_idproducto, nombreproducto, precioproducto, stbruto_producto, asiento_idasiento, impuestointerno, desc_imp_interno, importebruto, ivatotal, importeneto, importeIIBB, importeImpInt, factura_idfactura, tipofactura, nronotacredito, netogravado, percepcion_iva, importe_per_iva', 'safe', 'on'=>'search'),
			array('factura_idfactura','validarFactura','on'=>'insert'),
		);
	}

	public function relations() {
		return array(
		'facturaIdfactura'=> array(self::BELONGS_TO, 'Factura', 'factura_idfactura'),
		'detallectacteclientes' => array(self::HAS_MANY, 'Detallectactecliente', 'factura_idfactura'),
			'asientoIdasiento' => array(self::BELONGS_TO, 'Asiento', 'asiento_idasiento'),
			'clienteIdcliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_idcliente'),
			'productoIdproducto' => array(self::BELONGS_TO, 'Producto', 'producto_idproducto'),
			'cajaIdcaja' => array(self::BELONGS_TO, 'Caja', 'formadepago'),
			'movimientocajaIdmovimientocaja'=> array(self::BELONGS_TO, 'Movimientocaja', 'movimientocaja_idmovimientocaja'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idnotacredito' => Yii::t('app', 'Idnotacredito'),
			'nrodefactura' => Yii::t('app', 'Nro Factura'),
			'fecha' => Yii::t('app', 'Fecha'),
			'formadepago' => Yii::t('app', 'Forma de pago'),
			'cliente_idcliente' => Yii::t('app', 'Cliente'),
			'estado' => Yii::t('app', 'Estado'),
			'descrecar' => Yii::t('app', 'Descrecar'),
			'tipodescrecar' => Yii::t('app', 'Tipodescrecar'),
			'iva' => Yii::t('app', 'Iva'),
			'retencionIIBB' => Yii::t('app', 'Retencion IIBB'),
			'cantidadproducto' => Yii::t('app', 'Cantidadproducto'),
			'producto_idproducto' => Yii::t('app', 'Producto Idproducto'),
			'nombreproducto' => Yii::t('app', 'Nombreproducto'),
			'precioproducto' => Yii::t('app', 'Precioproducto'),
			'stbruto_producto' => Yii::t('app', 'Stbruto Producto'),
			'asiento_idasiento' => Yii::t('app', 'Asiento Idasiento'),
			'impuestointerno' => Yii::t('app', 'Impuesto interno'),
			'desc_imp_interno' => Yii::t('app', 'Desc Imp Interno'),
			'importebruto' => Yii::t('app', 'Importebruto'),
			'ivatotal' => Yii::t('app', 'Ivatotal'),
			'importeneto' => Yii::t('app', 'Importeneto'),
			'importeIIBB' => Yii::t('app', 'Importe Iibb'),
			'importeImpInt' => Yii::t('app', 'Importe Imp Int'),
			'factura_idfactura' => Yii::t('app', 'Factura relacionada a la Nota de crédito'),
			'tipofactura' => Yii::t('app', 'Tipo de factura'),
			'nronotacredito' => Yii::t('app', 'Nro. Nota crédito'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idnotacredito', $this->idnotacredito);
		$criteria->compare('nrodefactura', $this->nrodefactura);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('formadepago', $this->formadepago);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('estado', $this->estado);
		$criteria->compare('descrecar', $this->descrecar);
		$criteria->compare('tipodescrecar', $this->tipodescrecar);
		$criteria->compare('iva', $this->iva);
		$criteria->compare('retencionIIBB', $this->retencionIIBB);
		$criteria->compare('cantidadproducto', $this->cantidadproducto);
		$criteria->compare('producto_idproducto', $this->producto_idproducto);
		$criteria->compare('nombreproducto', $this->nombreproducto, true);
		$criteria->compare('precioproducto', $this->precioproducto);
		$criteria->compare('stbruto_producto', $this->stbruto_producto);
		$criteria->compare('asiento_idasiento', $this->asiento_idasiento);
		$criteria->compare('impuestointerno', $this->impuestointerno);
		$criteria->compare('desc_imp_interno', $this->desc_imp_interno, true);
		$criteria->compare('importebruto', $this->importebruto);
		$criteria->compare('ivatotal', $this->ivatotal);
		$criteria->compare('importeneto', $this->importeneto);
		$criteria->compare('importeIIBB', $this->importeIIBB);
		$criteria->compare('importeImpInt', $this->importeImpInt);
		$criteria->compare('factura_idfactura', $this->factura_idfactura);
		$criteria->compare('tipofactura', $this->tipofactura);
		$criteria->compare('nronotacredito', $this->nronotacredito, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
					'defaultOrder'=>array('fecha'=>CSort::SORT_ASC),
			)
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
			$check=Factura::model()->find("idfactura=:id AND (estado=1 OR estado=2)",array(':id'=>$this->factura_idfactura));
			if(isset($check->idfactura)){
				$this->addError('factura_idfactura', 'La factura ya tiene una Nota de Credito Emitida');
		}
	}
}