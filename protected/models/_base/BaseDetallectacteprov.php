<?php

/**
 * This is the model base class for the table "detallectacteprov".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Detallectacteprov".
 *
 * Columns in table "detallectacteprov" available as properties of the model,
 * followed by relations of table "detallectacteprov" available as properties of the model.
 *
 * @property integer $iddetallectacteprov
 * @property string $fecha
 * @property string $descripcion
 * @property integer $tipo
 * @property integer $iddocumento
 * @property double $debe
 * @property double $haber
 * @property integer $ctacteprov_idctacteprov
 *
 * @property Ctacteprov $ctacteprovIdctacteprov
 */
abstract class BaseDetallectacteprov extends GxActiveRecord {
	public $total_debe,$total_haber;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'detallectacteprov';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Detallectacteprov|Detallectacteprovs', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('fecha, tipo, ctacteprov_idctacteprov', 'required'),
			array('tipo, iddocumento, ctacteprov_idctacteprov, compra_idcompra, notacreditoprov_idnotacreditoprov, notadebitoprov_idnotadebitoprov, ordendepago_idordendepago', 'numerical', 'integerOnly'=>true),
			array('debe, haber', 'numerical'),
			array('descripcion', 'length', 'max'=>100),
			array('descripcion, iddocumento, debe, haber, compra_idcompra, notacreditoprov_idnotacreditoprov, notadebitoprov_idnotadebitoprov, ordendepago_idordendepago', 'default', 'setOnEmpty' => true, 'value' => null),
			array('iddetallectacteprov, fecha, descripcion, tipo, iddocumento, debe, haber, ctacteprov_idctacteprov, compra_idcompra, notacreditoprov_idnotacreditoprov, notadebitoprov_idnotadebitoprov, ordendepago_idordendepago', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'ctacteprovIdctacteprov' => array(self::BELONGS_TO, 'Ctacteprov', 'ctacteprov_idctacteprov'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'iddetallectacteprov' => Yii::t('app', 'Iddetallectacteprov'),
			'fecha' => Yii::t('app', 'Fecha'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'tipo' => Yii::t('app', 'Tipo'),
			'iddocumento' => Yii::t('app', 'Iddocumento'),
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'ctacteprov_idctacteprov' => null,
			'ctacteprovIdctacteprov' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('iddetallectacteprov', $this->iddetallectacteprov);
		//$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare("DATE_FORMAT(fecha,'%d/%m/%Y')",$this->fecha,true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('tipo', $this->tipo);
		$criteria->compare('iddocumento', $this->iddocumento);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('ctacteprov_idctacteprov', $this->ctacteprov_idctacteprov);
		$criteria->compare('notacreditoprov_idnotacreditoprov', $this->notacreditoprov_idnotacreditoprov);
		$criteria->compare('notadebitoprov_idnotadebitoprov', $this->notadebitoprov_idnotadebitoprov);
		$criteria->compare('ordendepago_idordendepago', $this->ordendepago_idordendepago);

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
	
	public function obtenerDebeHaber($mes,$anio,$proveedor)
        {
                $criteria=new CDbCriteria;
                
                $criteria->select = array(
                	'SUM(debe) AS total_debe, SUM(haber) AS total_haber',
                );

                $criteria->condition = 'YEAR(fecha)='.$anio.' and MONTH(fecha)='.$mes.' and ctacteprov_idctacteprov='.$proveedor;
                $result = Detallectacteprov::model()->find($criteria); 
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
   	public  $saldo;  
    // caso variable para diferenciar lo devuelto por método, 0 filtrado por año y mes, 1 lista completa 
	public  function generarGrillaSaldos($idcuenta,$anio, $mes, $caso){
        	      	
        	$sql1="call saldos_prov(".$idcuenta.",'".$anio."','".$mes."',".$caso.");";
			$cant=Yii::app()->db->createCommand($sql1)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql1, array(
				'keyField' => 'iddetallectacteprov', 
				//'totalItemCount'=>$cant,
			    'sort'=>array(
					'defaultOrder'=>'fecha ASC'),
			      
			    'pagination'=>array(
			        'pageSize'=>$cant,
			    ),
				));
			return $dataProvider;
        }
          
     public  function generarGrillaSaldos_secuencial($idcuenta,$anio, $mes, $caso){
        	      	
        	$sql1="call saldos_prov(".$idcuenta.",'".$anio."','".$mes."',".$caso.");";
			$cant=Yii::app()->db->createCommand($sql1)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql1, array(
				'keyField' => 'iddetallectacteprov', 
				//'totalItemCount'=>$cant,
			    'sort'=>array(
					'defaultOrder'=>array('fecha'=>CSort::SORT_DESC),
			      ),
			    'pagination'=>array(
			        'pageSize'=>$cant,
			    ),
				));
			return $dataProvider;
        }  
}