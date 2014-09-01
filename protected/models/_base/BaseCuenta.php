<?php

/**
 * This is the model base class for the table "cuenta".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Cuenta".
 *
 * Columns in table "cuenta" available as properties of the model,
 * followed by relations of table "cuenta" available as properties of the model.
 *
 * @property integer $idcuenta
 * @property string $codigocta
 * @property string $nombre
 * @property integer $tipocuenta_idtipocuenta
 * @property integer $asentable
 *
 * @property Asiento[] $asientos
 * @property Caja[] $cajas
 * @property Tipocuenta $tipocuentaIdtipocuenta
 * @property Factura[] $facturas
 */
abstract class BaseCuenta extends GxActiveRecord {
	public $fecha,$fecha2;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'cuenta';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Cuenta|Cuentas', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('codigocta, nombre, tipocuenta_idtipocuenta, asentable', 'required'),
			array('tipocuenta_idtipocuenta, asentable', 'numerical', 'integerOnly'=>true),
			array('codigocta, nombre', 'length', 'max'=>45),
			array('idcuenta, codigocta, nombre, tipocuenta_idtipocuenta, asentable', 'safe', 'on'=>'search'),
			array('codigocta','nuevaCuentaRepetida'),
		);
	}

	public function relations() {
		return array(
			'asientos' => array(self::HAS_MANY, 'Asiento', 'cuenta_idcuenta'),
			'cajas' => array(self::HAS_MANY, 'Caja', 'cuenta_idcuenta'),
			'tipocuentaIdtipocuenta' => array(self::BELONGS_TO, 'Tipocuenta', 'tipocuenta_idtipocuenta'),
			'facturas' => array(self::HAS_MANY, 'Factura', 'cuenta_idcuenta'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idcuenta' => Yii::t('app', 'Idcuenta'),
			'codigocta' => Yii::t('app', 'Codigo cuenta'),
			'nombre' => Yii::t('app', 'Nombre'),
			'tipocuenta_idtipocuenta' => null,
			'asentable' => Yii::t('app', 'Asentable'),
			'asientos' => null,
			'cajas' => null,
			'tipocuentaIdtipocuenta' => Yii::t('app', 'Tipo de cuenta'),
			'tipocuenta_idtipocuenta' => Yii::t('app', 'Tipo de cuenta'),
			'facturas' => null,
			'fecha'=> Yii::t('app', 'Fecha de inicio'),
			'fecha2'=> Yii::t('app', 'Fecha de finalización'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idcuenta', $this->idcuenta);
		$criteria->compare('codigocta', $this->codigocta, true);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('tipocuenta_idtipocuenta', $this->tipocuenta_idtipocuenta);
		$criteria->compare('asentable', $this->asentable);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
            	'defaultOrder'=>'tipocuenta_idtipocuenta ASC',
                
            
        ),
		));
	}
	public function nuevaCuentaRepetida($attribute,$params){
		$codnueva=$this->codigocta;
		$existcuenta=Cuenta::model()->count('codigocta=:codnueva',array(':codnueva'=>$codnueva));
		
		if($existcuenta > 0){
			$this->addError('codigocta', 'Ya existe una cuenta con este código');
		}
	}
	private $codNombre;
	
	public function getcodNombre()
	{
	    return $this->codigocta." - ".$this->nombre;
	}
	public $fechaasiento, $codigocuenta, $nombrecuenta,$descripcionasiento,$idcuent,$debeT,$haberT;
	public  function generargrilladetallecuenta($idcuenta,$fecha, $fecha2){
        	
        		        	
        	$fecha = DateTime::createFromFormat('d/m/Y', $fecha);
        	$fecha=$fecha->format('Y-m-d');
        	/*$anio1=$fecha->format('Y');
        	$mes1=$fecha->format('m');
        	$dia1=$fecha->format('d');*/
        	
        	$fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2);
        	$fecha2=$fecha2->format('Y-m-d');
        	/*$anio2=$fecha2->format('Y');
        	$mes2=$fecha2->format('m');
        	$dia2=$fecha2->format('d');*/
			$sql="call saldo_cuenta(".$idcuenta.",'".$fecha."','".$fecha2."');";
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'idcuent',
			    'totalItemCount'=>$count,
			    'sort'=>array(
					'defaultOrder'=>'fechaasiento ASC'),
			        
			       
			    
			    'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
}