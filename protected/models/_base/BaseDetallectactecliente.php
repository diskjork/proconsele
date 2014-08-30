<?php

/**
 * This is the model base class for the table "detallectactecliente".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Detallectactecliente".
 *
 * Columns in table "detallectactecliente" available as properties of the model,
 * followed by relations of table "detallectactecliente" available as properties of the model.
 *
 * @property integer $iddetallectactecliente
 * @property string $fecha
 * @property string $descripcion
 * @property integer $tipo
 * @property string $iddocumento
 * @property double $debe
 * @property double $haber
 * @property integer $ctactecliente_idctactecliente
 *
 * @property Cobranza[] $cobranzas
 * @property Ctactecliente $ctacteclienteIdctactecliente
 */
abstract class BaseDetallectactecliente extends GxActiveRecord {
	public $total_debe,$total_haber;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'detallectactecliente';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Detallectactecliente|Detallectacteclientes', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('fecha, tipo, ctactecliente_idctactecliente', 'required'),
			array('iddetallectactecliente, tipo, ctactecliente_idctactecliente, iddocumento, factura_idfactura, notacredito_idnotacredito, notadebito_idnotadebito, cobranza_idcobranza', 'numerical', 'integerOnly'=>true),
			array('debe, haber', 'numerical'),
			array('descripcion', 'length', 'max'=>100),
			array('descripcion, iddocumento, debe, haber, factura_idfactura, notacredito_idnotacredito, notadebito_idnotadebito,cobranza_idcobranza', 'default', 'setOnEmpty' => true, 'value' => null),
			array('iddetallectactecliente, fecha, descripcion, tipo, iddocumento, debe, haber, ctactecliente_idctactecliente, factura_idfactura, notacredito_idnotacredito, notadebito_idnotadebito, cobranza_idcobranza', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'cobranzas' => array(self::HAS_MANY, 'Cobranza', 'detallectactecliente_iddetallectactecliente'),
			'ctacteclienteIdctactecliente' => array(self::BELONGS_TO, 'Ctactecliente', 'ctactecliente_idctactecliente'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'iddetallectactecliente' => Yii::t('app', 'Iddetallectactecliente'),
			'fecha' => Yii::t('app', 'Fecha'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'tipo' => Yii::t('app', 'Tipo'),
			'iddocumento' => Yii::t('app', 'Iddocumento'),
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'ctactecliente_idctactecliente' => null,
			'cobranzas' => null,
			'ctacteclienteIdctactecliente' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('iddetallectactecliente', $this->iddetallectactecliente);
		//$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare("DATE_FORMAT(fecha,'%d/%m/%Y')",$this->fecha,true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('tipo', $this->tipo);
		$criteria->compare('iddocumento', $this->iddocumento, true);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('ctactecliente_idctactecliente', $this->ctactecliente_idctactecliente);
		$criteria->compare('cobranza_idcobranza', $this->cobranza_idcobranza);
		$criteria->compare('notacredito_idnotacredito', $this->notacredito_idnotacredito);
		$criteria->compare('notadebito_idnotadebito', $this->notadebito_idnotadebito);

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
	
	public function obtenerDebeHaber($mes,$anio,$cliente)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'SUM(debe) AS total_debe, SUM(haber) AS total_haber',
                );

                $criteria->condition = 'YEAR(fecha)='.$anio.' and MONTH(fecha)='.$mes.' and ctactecliente_idctactecliente='.$cliente;
                $result = Detallectactecliente::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
    public  $saldo;  
    // caso variable para diferenciar lo devuelto por método, 0 filtrado por año y mes, 1 lista completa 
	public  function generarGrillaSaldos($idcuenta,$anio, $mes, $caso){
        	      	
        	$sql1="call saldos(".$idcuenta.",'".$anio."','".$mes."',".$caso.");";
			$cant=Yii::app()->db->createCommand($sql1)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql1, array(
				'keyField' => 'iddetallectactecliente', 
				//'totalItemCount'=>$cant,
			    'sort'=>array(
					'defaultOrder' => array(
                            'fecha' => CSort::SORT_ASC, //default sort value
                        ),
					'attributes'=>array(
					             'iddetallectactecliente','descripcion', 'tipo','debe', 'haber','saldo'
					        ),
			     ), 
			    'pagination'=>array(
			        'pageSize'=>$cant,
			    ),
				));
			return $dataProvider;
        }
          
     public  function generarGrillaSaldos_secuencial($idcuenta,$anio, $mes, $caso){
        	      	
        	$sql1="call saldos(".$idcuenta.",'".$anio."','".$mes."',".$caso.");";
			$cant=Yii::app()->db->createCommand($sql1)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql1, array(
				'keyField' => 'iddetallectactecliente', 
                'totalItemCount' => $cant,
 				'pagination'=>array(
			        'pageSize'=>$cant,
			    ),
				));
			return $dataProvider;
        }  
}