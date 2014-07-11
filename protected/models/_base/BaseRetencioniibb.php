<?php

/**
 * This is the model base class for the table "retencioniibb".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Retencioniibb".
 *
 * Columns in table "retencioniibb" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $idretencionIIBB
 * @property integer $nrocomprobante
 * @property integer $cliente_idcliente
 * @property string $fecha
 * @property string $comp_relacionado
 * @property double $importe
 * @property double $tasa
 *
 */
abstract class BaseRetencioniibb extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'retencioniibb';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Retencioniibb|Retencioniibbs', $n);
	}

	public static function representingColumn() {
		return 'fecha';
	}

	public function rules() {
		return array(
			array('nrocomprobante, cliente_idcliente, fecha, importe, detallecobranza_iddetallecobranza', 'required'),
			array('nrocomprobante, cliente_idcliente, detallecobranza_iddetallecobranza', 'numerical', 'integerOnly'=>true),
			array('importe, tasa', 'numerical'),
			array('comp_relacionado', 'length', 'max'=>45),
			array('comp_relacionado, tasa', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idretencionIIBB, nrocomprobante, cliente_idcliente, fecha, comp_relacionado, importe, tasa, detallecobranza_iddetallecobranza', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idretencionIIBB' => Yii::t('app', 'Idretencion Iibb'),
			'nrocomprobante' => Yii::t('app', 'Nrocomprobante'),
			'cliente_idcliente' => Yii::t('app', 'Cliente Idcliente'),
			'fecha' => Yii::t('app', 'Fecha'),
			'comp_relacionado' => Yii::t('app', 'Comp Relacionado'),
			'importe' => Yii::t('app', 'Importe'),
			'tasa' => Yii::t('app', 'Tasa'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idretencionIIBB', $this->idretencionIIBB);
		$criteria->compare('nrocomprobante', $this->nrocomprobante);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('comp_relacionado', $this->comp_relacionado, true);
		$criteria->compare('importe', $this->importe);
		$criteria->compare('tasa', $this->tasa);
		$criteria->compare('detallecobranza_iddetallecobranza', $this->detallecobranza_iddetallecobranza);

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