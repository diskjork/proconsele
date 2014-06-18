<?php

/**
 * This is the model base class for the table "detallecobranza".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Detallecobranza".
 *
 * Columns in table "detallecobranza" available as properties of the model,
 * followed by relations of table "detallecobranza" available as properties of the model.
 *
 * @property integer $iddetallecobranza
 * @property integer $tipocobranza
 * @property double $importe
 * @property string $transferenciabanco
 * @property string $chequefechacobro
 * @property string $chequefechaemision
 * @property string $nrocheque
 * @property integer $chequebanco
 * @property string $chequetitular
 * @property string $chequecuittitular
 * @property integer $cobranza_idcobranza
 * @property integer $movimientobanco_idmovimientobanco
 * @property integer $movimientocaja_idmovimientocaja
 * @property integer $cheque_idcheque
 *
 * @property Cheque $chequeIdcheque
 * @property Cobranza $cobranzaIdcobranza
 * @property Movimientobanco $movimientobancoIdmovimientobanco
 * @property Movimientocaja $movimientocajaIdmovimientocaja
 */
abstract class BaseDetallecobranza extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'detallecobranza';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Detallecobranza|Detallecobranzas', $n);
	}

	public static function representingColumn() {
		return 'transferenciabanco';
	}

	public function rules() {
		return array(
			array('tipocobranza, importe', 'required'),
			array('tipocobranza, chequebanco, cobranza_idcobranza, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja, cheque_idcheque', 'numerical', 'integerOnly'=>true),
			array('importe', 'numerical'),
			array('transferenciabanco, chequetitular, chequecuittitular', 'length', 'max'=>100),
			array('nrocheque', 'length', 'max'=>20),
			array('chequefechacobro, chequefechaemision', 'safe'),
			array('transferenciabanco, chequefechacobro, chequefechaemision, nrocheque, chequebanco, chequetitular, chequecuittitular, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja, cheque_idcheque', 'default', 'setOnEmpty' => true, 'value' => null),
			array('iddetallecobranza, tipocobranza, importe, transferenciabanco, chequefechacobro, chequefechaemision, nrocheque, chequebanco, chequetitular, chequecuittitular, cobranza_idcobranza, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja, cheque_idcheque', 'safe', 'on'=>'search'),
			array('tipocobranza','validarDatosCheque'),
			array('tipocobranza','validarDatosTransfe'),
		);
	}

	public function relations() {
		return array(
			'chequeIdcheque' => array(self::BELONGS_TO, 'Cheque', 'cheque_idcheque'),
			'cobranzaIdcobranza' => array(self::BELONGS_TO, 'Cobranza', 'cobranza_idcobranza'),
			'movimientobancoIdmovimientobanco' => array(self::BELONGS_TO, 'Movimientobanco', 'movimientobanco_idmovimientobanco'),
			'movimientocajaIdmovimientocaja' => array(self::BELONGS_TO, 'Movimientocaja', 'movimientocaja_idmovimientocaja'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'iddetallecobranza' => Yii::t('app', 'Iddetallecobranza'),
			'tipocobranza' => Yii::t('app', 'Tipocobranza'),
			'importe' => Yii::t('app', 'Importe'),
			'transferenciabanco' => Yii::t('app', 'Banco'),
			'chequefechacobro' => Yii::t('app', 'Fecha cobro'),
			'chequefechaemision' => Yii::t('app', 'Fecha Imision'),
			'nrocheque' => Yii::t('app', 'Nro.cheque'),
			'chequebanco' => Yii::t('app', 'Banco'),
			'chequetitular' => Yii::t('app', 'Titular'),
			'chequecuittitular' => Yii::t('app', 'CUIT titular'),
			'cobranza_idcobranza' => null,
			'movimientobanco_idmovimientobanco' => null,
			'movimientocaja_idmovimientocaja' => null,
			'cheque_idcheque' => null,
			'chequeIdcheque' => null,
			'cobranzaIdcobranza' => null,
			'movimientobancoIdmovimientobanco' => null,
			'movimientocajaIdmovimientocaja' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('iddetallecobranza', $this->iddetallecobranza);
		$criteria->compare('tipocobranza', $this->tipocobranza);
		$criteria->compare('importe', $this->importe);
		$criteria->compare('transferenciabanco', $this->transferenciabanco, true);
		$criteria->compare('chequefechacobro', $this->chequefechacobro, true);
		$criteria->compare('chequefechaemision', $this->chequefechaemision, true);
		$criteria->compare('nrocheque', $this->nrocheque, true);
		$criteria->compare('chequebanco', $this->chequebanco);
		$criteria->compare('chequetitular', $this->chequetitular, true);
		$criteria->compare('chequecuittitular', $this->chequecuittitular, true);
		$criteria->compare('cobranza_idcobranza', $this->cobranza_idcobranza);
		$criteria->compare('movimientobanco_idmovimientobanco', $this->movimientobanco_idmovimientobanco);
		$criteria->compare('movimientocaja_idmovimientocaja', $this->movimientocaja_idmovimientocaja);
		$criteria->compare('cheque_idcheque', $this->cheque_idcheque);

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
	public function validarDatosCheque($attribute,$params){
      	
    	if( $this->tipocobranza == 1){
    		
    		switch (true){
    			case ($this->chequebanco == null):
    				$this->addError('chequebanco', 'Banco No puede ser nulo');
    				break;
    			case ($this->chequefechaingreso == null):
    				$this->addError('chequefechaingreso', 'Fecha Ingreso No puede ser nulo');
    				break;
    			case ($this->chequetitular == null):
    				$this->addError('chequetitular', 'Titular no puede ser nulo');
    				break;
    			case ($this->chequecuittitular == null):
    				$this->addError('chequecuittitular', 'CUIT no puede ser nulo');
    				break;
    			case ($this->chequefechacobro == null):
    				$this->addError('chequefechacobro', 'Fecha Cobro No puede ser nulo');
    				break;
    			case ($this->nrocheque == null):
    				$this->addError('nrocheque', 'Nro. Cheque No puede ser nulo');
    				break;
    			
    		}
    	}
    }
	public function validarDatosTransfe($attribute,$params){
      	
    	if( $this->tipocobranza == 2 && $this->transferenciabanco == null){
   				$this->addError('transferenciabanco', 'No puede ser nulo');
  			}
    }
}