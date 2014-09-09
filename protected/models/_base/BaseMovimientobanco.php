<?php

/**
 * This is the model base class for the table "movimientobanco".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Movimientobanco".
 *
 * Columns in table "movimientobanco" available as properties of the model,
 * followed by relations of table "movimientobanco" available as properties of the model.
 *
 * @property integer $idmovimientobanco
 * @property string $descripcion
 * @property string $fecha
 * @property integer $debeohaber
 * @property double $debe
 * @property double $haber
 * @property string $numerooperacion
 * @property integer $ctabancaria_idctabancaria
 * @property integer $cheque_idcheque

 * @property integer $cuenta_idcuenta
 * @property integer $asiento_idasiento
 *
 * @property Detalleasiento[] $detalleasientos
 * @property Detallecobranza[] $detallecobranzas
 * @property Detallecompra[] $detallecompras
 * @property Detalleordendepago[] $detalleordendepagos
 * @property Detallepagos[] $detallepagoses
 * @property Cheque $chequeIdcheque
 * @property Ctabancaria $ctabancariaIdctabancaria
 * @property Cuenta $cuentaIdcuenta
 * @property Detalleasiento $detalleasientoIddetalleasiento
 */
abstract class BaseMovimientobanco extends GxActiveRecord {
	public $importe;
	public $vista;
	public $fechacobro;
	public $total_debe,$total_haber;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'movimientobanco';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Movimientobanco|Movimientobancos', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('fecha, debeohaber, ctabancaria_idctabancaria, cuenta_idcuenta, descripcion', 'required'),
			array('debeohaber, ctabancaria_idctabancaria, cheque_idcheque, cuenta_idcuenta, asiento_idasiento, iddetallecobranza, iddetalleordendepago, desdeasiento, chequerechazado', 'numerical', 'integerOnly'=>true),
			array('debe, haber', 'numerical'),
			array('descripcion', 'length', 'max'=>100),
			array('numerooperacion', 'length', 'max'=>20),
			array('descripcion, debe, haber, numerooperacion, cheque_idcheque,  asiento_idasiento, iddetallecobranza, iddetalleordendepago, desdeasiento, chequerechazado', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idmovimientobanco, descripcion, fecha, debeohaber, debe, haber, numerooperacion, ctabancaria_idctabancaria, cheque_idcheque, cuenta_idcuenta, asiento_idasiento, iddetallecobranza, iddetalleordendepago, desdeasiento, chequerechazado', 'safe', 'on'=>'search'),
			array('fechacobro','safe'),
			array('fechacobro', 'length', 'max'=>20),
			array('fechacobro','compararFechas'),
		);
	}

	public function relations() {
		return array(
			'detalleasientos' => array(self::HAS_MANY, 'Detalleasiento', 'movimientobanco_idmovimientobanco'),
			'detallecobranzas' => array(self::HAS_MANY, 'Detallecobranza', 'movimientobanco_idmovimientobanco'),
			'detallecompras' => array(self::HAS_MANY, 'Detallecompra', 'movimientobanco_idmovimientobanco'),
			'detalleordendepagos' => array(self::HAS_MANY, 'Detalleordendepago', 'movimientobanco_idmovimientobanco'),
			'detallepagoses' => array(self::HAS_MANY, 'Detallepagos', 'movimientobanco_idmovimientobanco'),
			'chequeIdcheque' => array(self::BELONGS_TO, 'Cheque', 'cheque_idcheque'),
			'ctabancariaIdctabancaria' => array(self::BELONGS_TO, 'Ctabancaria', 'ctabancaria_idctabancaria'),
			'cuentaIdcuenta' => array(self::BELONGS_TO, 'Cuenta', 'cuenta_idcuenta'),
			'asientoIdasiento' => array(self::BELONGS_TO, 'Asiento', 'asiento_idasiento'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idmovimientobanco' => Yii::t('app', 'Idmovimientobanco'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'fecha' => Yii::t('app', 'Fecha'),
			'debeohaber' => Yii::t('app', 'Debeohaber'),
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'numerooperacion' => Yii::t('app', 'Numerooperacion'),
			'ctabancaria_idctabancaria' => Yii::t('app', 'Cta. bancaria'),
			'cuenta_idcuenta' => Yii::t('app', 'Cuenta contable relacionada'),
			'cheque_idcheque' => null,
			//'cuenta_idcuenta' => null,
			'asiento_idasiento' => null,
			'detalleasientos' => null,
			'detallecobranzas' => null,
			'detallecompras' => null,
			'detalleordendepagos' => null,
			'detallepagoses' => null,
			'chequeIdcheque' => null,
			'ctabancariaIdctabancaria' => null,
			'cuentaIdcuenta' => null,
			'asientoIdasiento' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idmovimientobanco', $this->idmovimientobanco);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('debeohaber', $this->debeohaber);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('numerooperacion', $this->numerooperacion, true);
		$criteria->compare('ctabancaria_idctabancaria', $this->ctabancaria_idctabancaria);
		$criteria->compare('cheque_idcheque', $this->cheque_idcheque);
		$criteria->compare('iddetalleordendepago', $this->iddetalleordendepago, true);
		$criteria->compare('iddetallecobranza', $this->iddetallecobranza, true);
		$criteria->compare('cuenta_idcuenta', $this->cuenta_idcuenta);
		$criteria->compare('asiento_idasiento', $this->asiento_idasiento);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
					'defaultOrder'=>array('fecha'=>CSort::SORT_ASC),
			)
		));
	}
//para listar los ctasbancarias cargadas en solapas	
	public function listCtasbancarias(){
		$sql= "SELECT idctabancaria,nombre FROM  ctabancaria WHERE estado=1 LIMIT 10";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$resultado = $dbCommand->queryAll();
		return $resultado;
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
public function compararFechas($attribute,$params)
	 {
	 	
	if(isset($this->fechacobro) && !empty($this->attributes['fecha'])) {
	  $valoresPrimera = explode ("/", $this->fechacobro);   
	  $valoresSegunda = explode ("/", $this->attributes['fecha']); 
	
	  $diaP = $valoresPrimera[0];  
	  $mesP = $valoresPrimera[1];  
	  $anyoP = $valoresPrimera[2]; 
	
	  $diaS = $valoresSegunda[0];  
	  $mesS = $valoresSegunda[1];  
	  $anyoS = $valoresSegunda[2];
	
	  $diasPJuliano = gregoriantojd($mesP, $diaP, $anyoP);  
	  $diasSJuliano = gregoriantojd($mesS, $diaS, $anyoS);     
	  
	  if(!checkdate($mesP, $diaP, $anyoP)){
	    // "La fecha ".$primera." no es v&aacute;lida";
	    $this->addError($attribute,'Los datos ingresados no son correctos.');
	  }elseif(!checkdate($mesS, $diaS, $anyoS)){
	    // "La fecha ".$segunda." no es v&aacute;lida";
	     $this->addError($attribute,'Los datos ingresados no son correctos.');
	  }else{
	    if(($diasPJuliano-$diasSJuliano)> 0){
	    	$this->addError($attribute,'La fecha ingresada debe ser mayor a la fecha de cobro');
	    	}
	    }
	  } 
	}
		
	public function obtenerDebeHaber($mes,$anio,$banco)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'SUM(debe) AS total_debe, SUM(haber) AS total_haber',
                );

                $criteria->condition = 'YEAR(fecha)='.$anio.' and MONTH(fecha)='.$mes.' and ctabancaria_idctabancaria='.$banco;
                $result = Movimientobanco::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        public $saldo,$descr;
     public  function generarGrillaSaldos($anio, $mes,$idcuenta){
        	      	
        	$sql1="call saldo_banco('".$anio."','".$mes."',".$idcuenta.");";
			$cant=Yii::app()->db->createCommand($sql1)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql1, array(
				'keyField' => 'idmovimientobanco', 
                'totalItemCount' => $cant,
				'sort'=>array(
					'defaultOrder' => array(
                            'fecha' => CSort::SORT_ASC, //default sort value
                        ),
					'attributes'=>array(
					             'idmovimientobanco','descr', 'debe', 'haber','saldo'
					        ),
			     ), 
 				'pagination'=>array(
			        'pageSize'=>$cant,
			    ),
				));
			return $dataProvider;
        }  

}