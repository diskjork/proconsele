<?php

/**
 * This is the model base class for the table "asiento".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Asiento".
 *
 * Columns in table "asiento" available as properties of the model,
 * followed by relations of table "asiento" available as properties of the model.
 *
 * @property integer $idasiento
 * @property string $fecha
 * @property string $descripcion
 *
 * @property Detalleasiento[] $detalleasientos
 */
abstract class BaseAsiento extends GxActiveRecord {
	public $totaldebe, $totalhaber;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'asiento';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Asiento|Asientos', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('fecha, descripcion', 'required'),
			array('descripcion', 'length', 'max'=>255),
			array('descripcion, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idasiento, fecha, descripcion, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja', 'safe', 'on'=>'search'),
			array('totaldebe, totalhaber','safe'),
			array('totaldebe, totalhaber','validarPartidaDoble'),
		);
	}

	public function relations() {
		return array(
			'detalleasientos' => array(self::HAS_MANY, 'Detalleasiento', 'asiento_idasiento'),
			'movimientobancoIdmovimientobanco' => array(self::BELONGS_TO, 'Movimientobanco', 'movimientobanco_idmovimientobanco'),
			'movimientocajaIdmovimientocaja'=> array(self::BELONGS_TO, 'Movimientocaja', 'movimientocaja_idmovimientocaja'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idasiento' => Yii::t('app', 'Idasiento'),
			'fecha' => Yii::t('app', 'Fecha'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'detalleasientos' => null,
		);
	}
	
	public function validarPartidaDoble($attribute,$params){
               
               if($this->totaldebe != $this->totalhaber){
               	$this->addError('debe','partida doble');
                        
               }
    }
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idasiento', $this->idasiento);
		$criteria->compare('fecha', $this->fecha, true);
		//$criteria->compare("DATE_FORMAT(fecha,'%d/%m/%Y')",$this->fecha);
		$criteria->compare('descripcion', $this->descripcion, true);

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