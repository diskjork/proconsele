<?php

/**
 * This is the model base class for the table "detalleasiento".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Detalleasiento".
 *
 * Columns in table "detalleasiento" available as properties of the model,
 * followed by relations of table "detalleasiento" available as properties of the model.
 *
 * @property integer $iddetalleasiento
 * @property double $debe
 * @property double $haber
 * @property integer $cuenta_idcuenta
 * @property integer $asiento_idasiento
 * @property integer $proveedor_idproveedor
 * @property integer $cliente_idcliente
 * @property string $iddocumento
 * @property integer $movimientobanco_idmovimientobanco
 * @property integer $movimientocaja_idmovimientocaja
 * @property integer $cheque_idcheque
 *
 * @property Cheque[] $cheques
 * @property Asiento $asientoIdasiento
 * @property Cliente $clienteIdcliente
 * @property Cuenta $cuentaIdcuenta
 * @property Movimientobanco $movimientobancoIdmovimientobanco
 * @property Movimientocaja $movimientocajaIdmovimientocaja
 * @property Proveedor $proveedorIdproveedor
 * @property Cheque $chequeIdcheque
 * @property Movimientobanco[] $movimientobancos
 * @property Movimientocaja[] $movimientocajas
 */
abstract class BaseDetalleasiento extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'detalleasiento';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Detalleasiento|Detalleasientos', $n);
	}

	public static function representingColumn() {
		return 'iddetalleasiento';
	}

	public function rules() {
		return array(
			array('cuenta_idcuenta', 'required'),
			array('cuenta_idcuenta, asiento_idasiento, proveedor_idproveedor, cliente_idcliente, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja, cheque_idcheque, iddetallecobranza, iddetalleordendepago', 'numerical', 'integerOnly'=>true),
			array('debe, haber', 'numerical'),
			array('iddocumento', 'length', 'max'=>20),
			array('operacion_manual', 'length', 'max'=>30),
			array('debe, haber, proveedor_idproveedor, cliente_idcliente, iddocumento, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja, cheque_idcheque, iddetallecobranza, iddetalleordendepago, operacion_manual', 'default', 'setOnEmpty' => true, 'value' => null),
			array('iddetalleasiento, debe, haber, cuenta_idcuenta, asiento_idasiento, proveedor_idproveedor, cliente_idcliente, iddocumento, movimientobanco_idmovimientobanco, movimientocaja_idmovimientocaja, cheque_idcheque, iddetallecobranza, iddetalleordendepago, operacion_manual', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'cheques' => array(self::HAS_MANY, 'Cheque', 'detalleasiento_iddetalleasiento'),
			'asientoIdasiento' => array(self::BELONGS_TO, 'Asiento', 'asiento_idasiento'),
			'clienteIdcliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_idcliente'),
			'cuentaIdcuenta' => array(self::BELONGS_TO, 'Cuenta', 'cuenta_idcuenta'),
			'movimientobancoIdmovimientobanco' => array(self::BELONGS_TO, 'Movimientobanco', 'movimientobanco_idmovimientobanco'),
			'movimientocajaIdmovimientocaja' => array(self::BELONGS_TO, 'Movimientocaja', 'movimientocaja_idmovimientocaja'),
			'proveedorIdproveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_idproveedor'),
			'chequeIdcheque' => array(self::BELONGS_TO, 'Cheque', 'cheque_idcheque'),
			'movimientobancos' => array(self::HAS_MANY, 'Movimientobanco', 'detalleasiento_iddetalleasiento'),
			'movimientocajas' => array(self::HAS_MANY, 'Movimientocaja', 'detalleasiento_iddetalleasiento'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'iddetalleasiento' => Yii::t('app', 'Iddetalleasiento'),
			'debe' => Yii::t('app', 'Debe'),
			'haber' => Yii::t('app', 'Haber'),
			'cuenta_idcuenta' => Yii::t('app', 'Cuenta contable'),
			'asiento_idasiento' => null,
			'proveedor_idproveedor' => null,
			'cliente_idcliente' => null,
			'iddocumento' => Yii::t('app', 'Iddocumento'),
			'movimientobanco_idmovimientobanco' => null,
			'movimientocaja_idmovimientocaja' => null,
			'cheque_idcheque' => null,
			'cheques' => null,
			'asientoIdasiento' => null,
			'clienteIdcliente' => null,
			'cuentaIdcuenta' => null,
			'movimientobancoIdmovimientobanco' => null,
			'movimientocajaIdmovimientocaja' => null,
			'proveedorIdproveedor' => null,
			'chequeIdcheque' => null,
			'movimientobancos' => null,
			'movimientocajas' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('iddetalleasiento', $this->iddetalleasiento);
		$criteria->compare('debe', $this->debe);
		$criteria->compare('haber', $this->haber);
		$criteria->compare('cuenta_idcuenta', $this->cuenta_idcuenta);
		$criteria->compare('asiento_idasiento', $this->asiento_idasiento);
		$criteria->compare('proveedor_idproveedor', $this->proveedor_idproveedor);
		$criteria->compare('cliente_idcliente', $this->cliente_idcliente);
		$criteria->compare('iddocumento', $this->iddocumento, true);
		$criteria->compare('movimientobanco_idmovimientobanco', $this->movimientobanco_idmovimientobanco);
		$criteria->compare('movimientocaja_idmovimientocaja', $this->movimientocaja_idmovimientocaja);
		$criteria->compare('cheque_idcheque', $this->cheque_idcheque);
		$criteria->compare('iddetallecobranza', $this->iddetallecobranza);
		$criteria->compare('iddetalleordendepago', $this->iddetalleordendepago);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			
		));
	}
		
		public  function generarArrayDEBE($anio, $mes){
       		$sql='SELECT cuenta.codigocta as codigo,cuenta.nombre AS cuenta, SUM( detalleasiento.debe ) AS debe 
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
					AND MONTH( asiento.fecha ) ='.$mes.'
					AND detalleasiento.asiento_idasiento = asiento.idasiento
					AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta
					GROUP BY cuenta.nombre
					';
       		$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    //'totalItemCount'=>$count,
			    'sort'=>array(
			        'attributes'=>array(
			             'codigo', 'cuenta', 'debe',
			        ),
			    ),
			   'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
		public  function generarArrayHABER($anio, $mes){
        	
        	//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_user')->queryScalar();
			$sql='SELECT cuenta.codigocta AS codigo, 
						 cuenta.nombre AS cuenta, 
						 SUM( detalleasiento.haber ) AS haber
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
					AND MONTH( asiento.fecha ) ='.$mes.'
					AND detalleasiento.asiento_idasiento = asiento.idasiento
					AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta
					GROUP BY cuenta.nombre ';
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    //'totalItemCount'=>$count,
			    'sort'=>array(
			        'attributes'=>array(
			             'codigo', 'cuenta', 'haber'
			        ),
			    ),
			   'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
		
        public  function generarAsientos($anio, $mes){
        	
        	
			$sql='SELECT asiento.fecha AS fecha, 
						 asiento.idasiento AS asiento, 
						 cuenta.codigocta AS codigo, 
						 cuenta.nombre AS nombre, 
						 detalleasiento.debe AS debe, 
						 detalleasiento.haber AS haber,
						 asiento.descripcion AS descripcion
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
							AND MONTH( asiento.fecha ) ='.$mes.'
							AND detalleasiento.asiento_idasiento = asiento.idasiento
							AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta';
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    'totalItemCount'=>$count,
			    'sort'=>array(
					'defaultOrder'=>array('fecha'=>CSort::SORT_ASC),
			        'attributes'=>array(
			             'fecha','asiento','nombre', 'codigo' , 'haber','debe', 'descripcion'
			        ),
			    ),
			    'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
        
	public  function generarArrayDEBE_anual($anio){
       		$sql='SELECT cuenta.codigocta as codigo,cuenta.nombre AS cuenta, SUM( detalleasiento.debe ) AS debe 
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
					AND detalleasiento.asiento_idasiento = asiento.idasiento
					AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta
					GROUP BY cuenta.nombre
					';
       		$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    //'totalItemCount'=>$count,
			    'sort'=>array(
			        'attributes'=>array(
			             'codigo', 'cuenta', 'debe',
			        ),
			    ),
			   'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
		public  function generarArrayHABER_anual($anio){
        	
        	//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_user')->queryScalar();
			$sql='SELECT cuenta.codigocta AS codigo, 
						 cuenta.nombre AS cuenta, 
						 SUM( detalleasiento.haber ) AS haber
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
					AND detalleasiento.asiento_idasiento = asiento.idasiento
					AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta
					GROUP BY cuenta.nombre ';
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    //'totalItemCount'=>$count,
			    'sort'=>array(
			        'attributes'=>array(
			             'codigo', 'cuenta', 'haber'
			        ),
			    ),
			   'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
        
	public  function generarAsientos_anual($anio){
        	
        	
			$sql='SELECT asiento.fecha AS fecha, 
						 asiento.idasiento AS asiento, 
						 cuenta.codigocta AS codigo, 
						 cuenta.nombre AS nombre, 
						 detalleasiento.debe AS debe, 
						 detalleasiento.haber AS haber,
						 asiento.descripcion AS descripcion
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
							AND detalleasiento.asiento_idasiento = asiento.idasiento
							AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta';
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    'totalItemCount'=>$count,
			    'sort'=>array(
					'defaultOrder'=>array('fecha'=>CSort::SORT_ASC),
			        'attributes'=>array(
			             'fecha','asiento','nombre', 'codigo' , 'haber','debe', 'descripcion'
			        ),
			    ),
			    'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        }
		public  function generarArraySALDOS_mes($anio,$mes){
        	
        	//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_user')->queryScalar();
			$sql='SELECT cuenta.codigocta AS codigo, 
						 cuenta.nombre AS cuenta, 
						 SUM( detalleasiento.debe ) AS debe,
						 SUM( detalleasiento.haber ) AS haber
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
					AND MONTH( asiento.fecha ) ='.$mes.'
					AND detalleasiento.asiento_idasiento = asiento.idasiento
					AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta
					GROUP BY cuenta.nombre ';
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    //'totalItemCount'=>$count,
			    'sort'=>array(
					'defaultOrder'=>array('codigo'=>CSort::SORT_ASC),
			        'attributes'=>array(
			             'codigo', 'cuenta', 'debe','haber'
			        ),
			    ),
			   'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        } 
        public  function generarArraySALDOS_anio($anio){
        	
        	//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_user')->queryScalar();
			$sql='SELECT cuenta.codigocta AS codigo, 
						 cuenta.nombre AS cuenta, 
						 SUM( detalleasiento.debe ) AS debe,
						 SUM( detalleasiento.haber ) AS haber
					FROM asiento, cuenta, detalleasiento
					WHERE YEAR( asiento.fecha ) ='.$anio.'
					AND detalleasiento.asiento_idasiento = asiento.idasiento
					AND detalleasiento.cuenta_idcuenta = cuenta.idcuenta
					GROUP BY cuenta.nombre ';
			$count=Yii::app()->db->createCommand($sql)->queryScalar();
			$dataProvider=new CSqlDataProvider($sql, array(
			    //'totalItemCount'=>$count,
			    'sort'=>array(
					'defaultOrder'=>array('codigo'=>CSort::SORT_ASC),
			        'attributes'=>array(
			             'codigo', 'cuenta', 'debe','haber'
			        ),
			    ),
			   'pagination'=>array(
			        'pageSize'=>$count,
			    ),
				));
			return $dataProvider;
        } 
}