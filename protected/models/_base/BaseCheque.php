<?php

/**
 * This is the model base class for the table "cheque".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Cheque".
 *
 * Columns in table "cheque" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $idcheque
 * @property string $nrocheque
 * @property string $titular
 * @property string $cuittitular
 * @property string $fechaingreso
 * @property string $fechacobro
 * @property double $debe
 * @property double $haber
 * @property integer $debeohaber
 * @property integer $Banco_idBanco
 * @property integer $estado
 * @property integer $proveedor_idproveedor
 * @property integer $cliente_idcliente
 * @property integer $chequera_idchequera
 * @property integer $iddetallecobranza
 *
 */
abstract class BaseCheque extends GxActiveRecord {
	public $importe;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'cheque';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Cheque|Cheques', $n);
	}

	public static function representingColumn() {
		return 'titular';
	}

	public function rules() {
		return array(
			array('nrocheque, titular, fechaingreso, fechacobro, debeohaber, estado', 'required'),
			array('debeohaber, Banco_idBanco, estado, proveedor_idproveedor, cliente_idcliente, chequera_idchequera, iddetallecobranza', 'numerical', 'integerOnly'=>true),
			array('debe, haber', 'numerical'),
			array('nrocheque', 'length', 'max'=>20),
			array('titular', 'length', 'max'=>255),
			array('cuittitular', 'length', 'max'=>50),
			array('cuittitular, debe, haber, Banco_idBanco, proveedor_idproveedor, cliente_idcliente, chequera_idchequera, iddetallecobranza, iddetalleordendepago', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idcheque, nrocheque, titular, cuittitular, fechaingreso, fechacobro, debe, haber, debeohaber, Banco_idBanco, estado, proveedor_idproveedor, cliente_idcliente, chequera_idchequera, iddetallecobranza, iddetalleordendepago', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'bancoIdBanco' => array(self::BELONGS_TO, 'Banco', 'Banco_idBanco'),
			'chequeraIdchequera' => array(self::BELONGS_TO, 'Chequera', 'chequera_idchequera'),
			'clienteIdcliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_idcliente'),
			'proveedorIdproveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_idproveedor'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idcheque' => Yii::t('app', 'Idcheque'),
			'nrocheque' => Yii::t('app', 'Nrocheque'),
			'titular' => Yii::t('app', 'Titular'),
			'cuittitular' => Yii::t('app', 'Cuittitular'),
			'fechaingreso' => Yii::t('app', 'Fechaingreso'),
			'fechacobro' => Yii::t('app', 'Fechacobro'),
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'debeohaber' => Yii::t('app', 'Debeohaber'),
			'Banco_idBanco' => Yii::t('app', 'Banco Id Banco'),
			'estado' => Yii::t('app', 'Estado'),
			'proveedor_idproveedor' => Yii::t('app', 'Proveedor Idproveedor'),
			'cliente_idcliente' => Yii::t('app', 'Cliente Idcliente'),
			'chequera_idchequera' => Yii::t('app', 'Chequera Idchequera'),
			'iddetallecobranza' => Yii::t('app', 'Cobranza Idcobranza'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idcheque', $this->idcheque);
		$criteria->compare('nrocheque', $this->nrocheque, true);
		$criteria->compare('titular', $this->titular, true);
		$criteria->compare('cuittitular', $this->cuittitular, true);
		$criteria->compare('fechaingreso', $this->fechaingreso, true);
		//$criteria->compare('fechacobro', $this->fechacobro, true);
		$criteria->compare("DATE_FORMAT(fechacobro,'%d/%m/%Y')",$this->fechacobro);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('debeohaber', $this->debeohaber);
		$criteria->compare('Banco_idBanco', $this->Banco_idBanco);
		$criteria->compare('estado', $this->estado);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('chequera_idchequera', $this->chequera_idchequera);
		$criteria->compare('iddetallecobranza', $this->iddetallecobranza);
		$criteria->compare('iddetalleordendepago', $this->iddetalleordendepago);

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
	public function validarProvCliente($attribute,$params){
      	
    	if( $this->debeohaber == 0){
    		if($this->cliente_idcliente == NULL){
				$this->addError('cliente_idcliente', 'Debe seleccionar un cliente');
			}
    	}
		if( $this->debeohaber == 1){
	    		if($this->proveedor_idproveedor ==NULL){
					$this->addError('proveedor_idproveedor', 'Debe seleccionar un proveedor');
				}
	    	}
    }
    public function validarBancos($attribute,$params){
    	if($this->Banco_idBanco == 0){
    		$this->addError('Banco_idBanco', 'Debe seleccionar un Banco');
    	}
    }
	private $nombestado;
	public function getnombestado(){
		return $this->nombre." - ".$this->bancoIdBanco;
		switch ($this->estado){
				case '0':
					$text="A pagar";
					return $text;
					break;
				case '1':
					$text="Pagado";
					return $text;
					break;
				case '2':
					$text="A cobrar";
					return $text;
					break;
				case '3':
					$text="Cobrado-Caja";
					return $text;
					break;
				case '4':
					$text="Endozado";
					return $text;
					break;
				case '5':
					$text="Cobrado-Banco";
					return $text;
					break;
			}
		
	}
}