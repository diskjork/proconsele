<?php

/**
 * This is the model base class for the table "compras".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Compras".
 *
 * Columns in table "compras" available as properties of the model,
 * followed by relations of table "compras" available as properties of the model.
 *
 * @property integer $idcompra
 * @property integer $nrodefactura
 * @property integer $tipofactura
 * @property integer $nroremito
 * @property string $fecha
 * @property string $descripcion
 * @property integer $formadepago
 * @property integer $proveedor_idproveedor
 * @property integer $estado
 * @property double $iva
 * @property double $percepcionIIBB
 * @property double $importebruto
 * @property double $ivatotal
 * @property double $importeneto
 * @property double $importeIIBB
 * @property integer $movimientocaja_idmovimientocaja
 * @property integer $asiento_idasiento
 * @property integer $cuenta_idcuenta
 *
 * @property Asiento[] $asientos
 * @property Asiento $asientoIdasiento
 * @property Ivamovimiento[] $ivamovimientos
 */
abstract class BaseCompras extends GxActiveRecord {
	public $iibb, $percepcionIIBB2,$vista;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'compras';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Compras|Comprases', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('nrodefactura, tipofactura, fecha, formadepago, proveedor_idproveedor, importeneto, cuenta_idcuenta', 'required'),
			array('nrodefactura, tipofactura, nroremito, formadepago, proveedor_idproveedor, estado, movimientocaja_idmovimientocaja, asiento_idasiento, cuenta_idcuenta', 'numerical', 'integerOnly'=>true),
			array('iva, percepcionIIBB, importebruto, ivatotal, importeneto, importeIIBB', 'numerical'),
			array('descripcion', 'length', 'max'=>150),
			array('nroremito, descripcion, estado, iva, percepcionIIBB, importebruto, ivatotal, importeIIBB, movimientocaja_idmovimientocaja, asiento_idasiento', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idcompra, nrodefactura, tipofactura, nroremito, fecha, descripcion, formadepago, proveedor_idproveedor, estado, iva, percepcionIIBB, importebruto, ivatotal, importeneto, importeIIBB, movimientocaja_idmovimientocaja, asiento_idasiento, cuenta_idcuenta', 'safe', 'on'=>'search'),
			array('tipofactura','validarTipoFacturaIVA'),
		);
	}

	public function relations() {
		return array(
			'asientos' => array(self::HAS_MANY, 'Asiento', 'compra_idcompra'),
			'asientoIdasiento' => array(self::BELONGS_TO, 'Asiento', 'asiento_idasiento'),
			'ivamovimientos' => array(self::HAS_MANY, 'Ivamovimiento', 'compras_idcompra'),
			'proveedorIdproveedor'=> array(self::BELONGS_TO, 'Proveedor', 'proveedor_idproveedor'),
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
			'idcompra' => Yii::t('app', 'Idcompra'),
			'nrodefactura' => Yii::t('app', 'Nro.de factura'),
			'tipofactura' => Yii::t('app', 'Tipo de factura'),
			'nroremito' => Yii::t('app', 'Nroremito'),
			'fecha' => Yii::t('app', 'Fecha'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'formadepago' => Yii::t('app', 'Forma de pago'),
			'proveedor_idproveedor' => Yii::t('app', 'Proveedor'),
			'estado' => Yii::t('app', 'Estado'),
			'iva' => Yii::t('app', 'Iva'),
			'percepcionIIBB' => Yii::t('app', 'Importe IIBB'),
			'percepcionIIBB2' => Yii::t('app', 'IIBB'),
			'importebruto' => Yii::t('app', 'Importebruto'),
			'ivatotal' => Yii::t('app', 'Importe IVA'),
			'importeneto' => Yii::t('app', 'Importe Neto'),
			'importeIIBB' => Yii::t('app', 'Importe IIBB'),
			'movimientocaja_idmovimientocaja' => Yii::t('app', 'Movimientocaja Idmovimientocaja'),
			'asiento_idasiento' => null,
			'cuenta_idcuenta' => Yii::t('app', 'Cuenta contable relacionada a la compra'),
			'asientos' => null,
			'asientoIdasiento' => null,
			'ivamovimientos' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idcompra', $this->idcompra);
		$criteria->compare('nrodefactura', $this->nrodefactura);
		$criteria->compare('tipofactura', $this->tipofactura);
		$criteria->compare('nroremito', $this->nroremito);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('formadepago', $this->formadepago);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		$criteria->compare('estado', $this->estado);
		$criteria->compare('iva', $this->iva);
		$criteria->compare('percepcionIIBB', $this->percepcionIIBB);
		$criteria->compare('importebruto', $this->importebruto);
		$criteria->compare('ivatotal', $this->ivatotal);
		$criteria->compare('importeneto', $this->importeneto);
		$criteria->compare('importeIIBB', $this->importeIIBB);
		$criteria->compare('movimientocaja_idmovimientocaja', $this->movimientocaja_idmovimientocaja);
		$criteria->compare('asiento_idasiento', $this->asiento_idasiento);
		$criteria->compare('cuenta_idcuenta', $this->cuenta_idcuenta);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
					'defaultOrder' => array('fecha' => true),
		),
		));
	}
	public function ultimaFactura(){
		$sql="SELECT MAX(nrodefactura) FROM compras;";
			$nrofactura=Yii::app()->db->createCommand($sql)->queryScalar();
			return $nrofactura;
	}
	public function generarGrid($anio,$mes)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'idcompra','nrodefactura','fecha','descripcion',
                	//'SUM(importeneto) as importeTotal',
                	//'SUM(detallefactura.subtotal*t.iva-detallecompra.precio) as ivaTotal',
                	'proveedor_idproveedor','estado','importeneto');
				//$criteria->join = ',detallefactura';
                $criteria->condition = 'YEAR(fecha)='.$anio.' AND MONTH(fecha)='.$mes;
                //$criteria->group = 'detallefactura.factura_idfactura';
                $criteria->order = 'fecha DESC';
                
                $result = Compras::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
	public function generarGrid($anio,$mes)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'idcompra','nrodefactura','fecha','descripcion',
                	//'SUM(importeneto) as importeTotal',
                	//'SUM(detallefactura.subtotal*t.iva-detallecompra.precio) as ivaTotal',
                	'proveedor_idproveedor','estado','importeneto');
				//$criteria->join = ',detallefactura';
                $criteria->condition = 'YEAR(fecha)='.$anio.' AND MONTH(fecha)='.$mes;
                //$criteria->group = 'detallefactura.factura_idfactura';
                $criteria->order = 'fecha DESC';
                
                $result = Compras::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
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
	public function validarTipoFacturaIVA($attribute,$params){
		if($this->tipofactura == 1){
			if($this->ivatotal == null) {
				$this->addError('ivatotal', 'IVA no puede ser nulo');
			}
		}
	}
}