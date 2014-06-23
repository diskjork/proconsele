<?php

/**
 * This is the model base class for the table "factura".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Factura".
 *
 * Columns in table "factura" available as properties of the model,
 * followed by relations of table "factura" available as properties of the model.
 *
 * @property integer $idfactura
 * @property string $nrodefactura
 * @property integer $tipofactura
 * @property integer $nroremito
 * @property string $fecha
 * @property integer $formadepago
 * @property integer $cliente_idcliente
 * @property integer $estado
 * @property double $descrecar
 * @property integer $tipodescrecar
 * @property double $iva
 * @property double $retencionIIBB
 * @property integer $presupuesto
 * @property integer $nropresupuesto
 * @property double $importebruto
 * @property double $ivatotal
 * @property double $cantidadproducto
 * @property integer $producto_idproducto
 * @property string $nombreproducto
 * @property double $precioproducto
 * @property double $stbruto_producto
 * @property integer $asiento_idasiento
 * @property double $impuestointerno
 * @property string $desc_imp_interno
 * @property double $importeneto
 *
 * @property Asiento[] $asientos
 * @property Detallectactecliente[] $detallectacteclientes
 * @property Asiento $asientoIdasiento
 */
abstract class BaseFactura extends GxActiveRecord {
	public $desRec, $iibb, $impInt;
	public $ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic,$nombreproducto,$maxnropresupuesto;
	public $importeTotal;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'factura';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Factura|Facturas', $n);
	}

	public static function representingColumn() {
		return 'nrodefactura';
	}

	public function rules() {
		return array(
			array('nrodefactura, tipofactura, nroremito, fecha, formadepago, cliente_idcliente, presupuesto, nropresupuesto, importebruto, ivatotal, cantidadproducto, producto_idproducto, nombreproducto, precioproducto, stbruto_producto, asiento_idasiento, importeneto', 'required'),
			array('tipofactura, nroremito, formadepago, cliente_idcliente, estado, tipodescrecar, presupuesto, nropresupuesto, producto_idproducto, asiento_idasiento', 'numerical', 'integerOnly'=>true),
			array('descrecar, iva, retencionIIBB, importebruto, ivatotal, cantidadproducto, precioproducto, stbruto_producto, impuestointerno, importeneto', 'numerical'),
			array('nrodefactura', 'length', 'max'=>45),
			array('nombreproducto, desc_imp_interno', 'length', 'max'=>100),
			array('estado, descrecar, tipodescrecar, iva, retencionIIBB, impuestointerno, desc_imp_interno', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idfactura, nrodefactura, tipofactura, nroremito, fecha, formadepago, cliente_idcliente, estado, descrecar, tipodescrecar, iva, retencionIIBB, presupuesto, nropresupuesto, importebruto, ivatotal, cantidadproducto, producto_idproducto, nombreproducto, precioproducto, stbruto_producto, asiento_idasiento, impuestointerno, desc_imp_interno, importeneto', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'asientos' => array(self::HAS_MANY, 'Asiento', 'factura_idfactura'),
			'detallectacteclientes' => array(self::HAS_MANY, 'Detallectactecliente', 'factura_idfactura'),
			'asientoIdasiento' => array(self::BELONGS_TO, 'Asiento', 'asiento_idasiento'),
			'clienteIdcliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_idcliente'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idfactura' => Yii::t('app', 'Idfactura'),
			'nrodefactura' => Yii::t('app', 'Nro de factura'),
			'tipofactura' => Yii::t('app', 'Tipo factura'),
			'nroremito' => Yii::t('app', 'Nro remito'),
			'fecha' => Yii::t('app', 'Fecha'),
			'formadepago' => Yii::t('app', 'Forma de pago'),
			'cliente_idcliente' => Yii::t('app', 'Cliente'),
			'estado' => Yii::t('app', 'Estado'),
			'descrecar' => Yii::t('app', '%'),
			'tipodescrecar' => Yii::t('app', 'Descuento - Recargo'),
			'iva' => Yii::t('app', 'IVA'),
			'retencionIIBB' => Yii::t('app', 'Percepción IIBB'),
			'presupuesto' => Yii::t('app', 'Presupuesto'),
			'nropresupuesto' => Yii::t('app', 'Nro presupuesto'),
			'importebruto' => Yii::t('app', 'T.Bruto'),
			'ivatotal' => Yii::t('app', 'Ivatotal'),
			'cantidadproducto' => Yii::t('app', 'Cantidad'),
			'producto_idproducto' => Yii::t('app', 'Código'),
			'nombreproducto' => Yii::t('app', 'Producto'),
			'precioproducto' => Yii::t('app', 'Precio'),
			'stbruto_producto' => Yii::t('app', 'Subtotal'),
			
			'asiento_idasiento' => null,
			'impuestointerno' => Yii::t('app', 'Imp. Interno'),
			'desc_imp_interno' => Yii::t('app', 'Desc Imp Interno'),
			'importeneto' => Yii::t('app', 'T.Neto'),
			'asientos' => null,
			'detallectacteclientes' => null,
			'asientoIdasiento' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idfactura', $this->idfactura);
		$criteria->compare('nrodefactura', $this->nrodefactura, true);
		$criteria->compare('tipofactura', $this->tipofactura);
		$criteria->compare('nroremito', $this->nroremito);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('formadepago', $this->formadepago);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('estado', $this->estado);
		$criteria->compare('descrecar', $this->descrecar);
		$criteria->compare('tipodescrecar', $this->tipodescrecar);
		$criteria->compare('iva', $this->iva);
		$criteria->compare('retencionIIBB', $this->retencionIIBB);
		$criteria->compare('presupuesto', $this->presupuesto);
		$criteria->compare('nropresupuesto', $this->nropresupuesto);
		$criteria->compare('importebruto', $this->importebruto);
		$criteria->compare('ivatotal', $this->ivatotal);
		$criteria->compare('cantidadproducto', $this->cantidadproducto);
		$criteria->compare('producto_idproducto', $this->producto_idproducto);
		$criteria->compare('nombreproducto', $this->nombreproducto, true);
		$criteria->compare('precioproducto', $this->precioproducto);
		$criteria->compare('stbruto_producto', $this->stbruto_producto);
		$criteria->compare('asiento_idasiento', $this->asiento_idasiento);
		$criteria->compare('impuestointerno', $this->impuestointerno);
		$criteria->compare('desc_imp_interno', $this->desc_imp_interno, true);
		$criteria->compare('importeneto', $this->importeneto);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function ultimaFactura(){
		$sql="select MAX(nrodefactura) as max from factura ";
			$nrofactura=Yii::app()->db->createCommand($sql)->queryScalar();
			return $nrofactura;
	}
	public function generarGrid($anio,$mes)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'idfactura','nrodefactura','fecha',
                	'SUM(importeneto) as importeTotal',
                	//'SUM(detallefactura.subtotal*t.iva-detallecompra.precio) as ivaTotal',
                	'cliente_idcliente','estado',
                );
				//$criteria->join = ',detallefactura';
                $criteria->condition = 'YEAR(fecha)='.$anio.' AND MONTH(fecha)='.$mes.' AND presupuesto=0';
                //$criteria->group = 'detallefactura.factura_idfactura';
                $criteria->order = 'fecha DESC';
                
                $result = Factura::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
}