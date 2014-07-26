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
	public $desRec, $iibb, $impInt, $vista;
	
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
			array('nrodefactura, tipofactura,  fecha, formadepago, cliente_idcliente, presupuesto, nropresupuesto, importebruto, cantidadproducto, producto_idproducto, nombreproducto, precioproducto, stbruto_producto,  importeneto', 'required'),
			array('tipofactura,  formadepago, cliente_idcliente, estado, tipodescrecar, presupuesto, nropresupuesto, producto_idproducto, asiento_idasiento', 'numerical', 'integerOnly'=>true),
			array('descrecar, iva, retencionIIBB, importebruto, ivatotal, cantidadproducto, precioproducto, stbruto_producto, impuestointerno, importeneto, importeIIBB, importeImpInt,movimientocaja_idmovimientocaja', 'numerical'),
			array('nrodefactura,nroremito', 'length', 'max'=>45),
			array('nombreproducto, desc_imp_interno', 'length', 'max'=>100),
			array('estado, descrecar, tipodescrecar, iva, retencionIIBB, impuestointerno, desc_imp_interno,ivatotal, importeIIBB, importeImpInt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idfactura, nrodefactura, tipofactura, nroremito, fecha, formadepago, cliente_idcliente, estado, descrecar, tipodescrecar, iva, retencionIIBB, presupuesto, nropresupuesto, importebruto, ivatotal, cantidadproducto, producto_idproducto, nombreproducto, precioproducto, stbruto_producto, asiento_idasiento, impuestointerno, desc_imp_interno, importeneto,importeIIBB, importeImpInt, movimientocaja_idmovimientocaja', 'safe', 'on'=>'search'),
			array('nrodefactura','validarNrofactura','on'=>'insert'),
		);
	}

	public function relations() {
		return array(
			'asientos' => array(self::HAS_MANY, 'Asiento', 'factura_idfactura'),
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
			'idfactura' => Yii::t('app', 'Idfactura'),
			'nrodefactura' => Yii::t('app', 'Nro de factura'),
			'tipofactura' => Yii::t('app', 'Tipo factura'),
			'nroremito' => Yii::t('app', 'Nro remito'),
			'fecha' => Yii::t('app', 'Fecha'),
			'formadepago' => Yii::t('app', 'Forma de pago'),
			'cliente_idcliente' => Yii::t('app', 'Cliente'),
			'estado' => Yii::t('app', 'Estado'),
			'descrecar' => Yii::t('app', 'Porcentaje'),
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
		//$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('DATE_FORMAT(fecha,"%d/%m/%Y")',$this->fecha,true);
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
		$criteria->compare('importeIIBB', $this->importeIIBB);
		$criteria->compare('importeImpInt', $this->importeImpInt);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
					'defaultOrder' => array('fecha' => true),
		),
		));
	}
	public function ultimaFactura(){
		$sql="SELECT MAX(nrodefactura) FROM factura;";
			$nrofactura=Yii::app()->db->createCommand($sql)->queryScalar();
			return $nrofactura;
	}
	public function generarGrid($anio,$mes)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'idfactura','nrodefactura','fecha',
                	//'SUM(importeneto) as importeTotal',
                	//'SUM(detallefactura.subtotal*t.iva-detallecompra.precio) as ivaTotal',
                	'cliente_idcliente','estado','importeneto');
				//$criteria->join = ',detallefactura';
                $criteria->condition = 'YEAR(fecha)='.$anio.' AND MONTH(fecha)='.$mes.' AND presupuesto=0';
                //$criteria->group = 'detallefactura.factura_idfactura';
                $criteria->order = 'fecha DESC';
                
                $result = Factura::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
	public function reportefactura($anio)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=01,importeneto,0)) AS ene',
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=02,importeneto,0)) AS feb',
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=03,importeneto,0)) AS mar',
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=04,importeneto,0)) AS abr',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=05,importeneto,0)) AS may',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=06,importeneto,0)) AS jun',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=07,importeneto,0)) AS jul',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=08,importeneto,0)) AS ago',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=09,importeneto,0)) AS sep',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=10,importeneto,0)) AS oct',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=11,importeneto,0)) AS nov',
					'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=12,importeneto,0)) AS dic',
                );

                $criteria->condition = 'YEAR(fecha)='.$anio;
                //$criteria->condition = 'cliente_idcliente IN (select cliente_idcliente from cliente where tipocliente_idtipocliente in (select idtipocliente from tipocliente order by idtipocliente))';
                //$criteria->group = 'producto_idproducto';
                //$criteria->order = 'cliente_idcliente IN (select cliente_idcliente from cliente order by nombre desc)';
                
                $result = Factura::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }    
    public function reportefacturaIVA($anio)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=01,ivatotal,0)) AS ene',
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=02,ivatotal,0)) AS feb',
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=03,ivatotal,0)) AS mar',
                	'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=04,ivatotal,0)) AS abr',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=05,ivatotal,0)) AS may',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=06,ivatotal,0)) AS jun',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=07,ivatotal,0)) AS jul',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=08,ivatotal,0)) AS ago',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=09,ivatotal,0)) AS sep',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=10,ivatotal,0)) AS oct',
	                'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=11,ivatotal,0)) AS nov',
					'SUM(if(YEAR(fecha)='.$anio.' and MONTH(fecha)=12,ivatotal,0)) AS dic',
                );

                $criteria->condition = 'YEAR(fecha)='.$anio;
                //$criteria->condition = 'cliente_idcliente IN (select cliente_idcliente from cliente where tipocliente_idtipocliente in (select idtipocliente from tipocliente order by idtipocliente))';
                //$criteria->group = 'producto_idproducto';
                //$criteria->order = 'cliente_idcliente IN (select cliente_idcliente from cliente order by nombre desc)';
                
                $result = Factura::model()->find($criteria); 
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
	public function validarNrofactura($attribute,$params){
		$check=Factura::model()->find("nrodefactura=:id",array(':id'=>$this->nrodefactura));
		if(isset($check->idfactura)){
			$this->addError('nrofactura', 'El número de factura existe');
	}
	}
private $nombrefactura;
	public function getnombrefactura(){
		if($this->estado == 1){
			$estado=" - Anulada con N.C.";
		}elseif($this->estado == 2){ 
			$estado=" - Con N.C. por Dev.Mer.";
		}else {
			$estado="";
		}	
		return "Fecha:".$this->fecha." Nro.".$this->nrodefactura." - Importe: $".$this->importeneto."".$estado;
	}
}