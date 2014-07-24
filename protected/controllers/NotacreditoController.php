<?php

class NotacreditoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column3';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			array('auth.filters.AuthFilter'),
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Notacredito;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notacredito'])) {
			$model->attributes=$_POST['Notacredito'];
//----------------------			
		if ($model->validate()) {
					$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="NOTA CREDITO - de Factura N°: ".$model->nrodefactura;
					if($asiento->save()){
						$model->asiento_idasiento=$asiento->idasiento;
						
						//disminuye la cta cte de deudores por venta
						$detAs=new Detalleasiento;
						$detAs->haber=$model->importeneto;
						$detAs->cuenta_idcuenta=11;  //112100 deudores por venta
						$detAs->asiento_idasiento=$asiento->idasiento;
						$detAs->save();
						$detalleCCcliente=$this->ctacte($model,$_POST['Notacredito']);
						//------------------------------
						//detalle asiento de IVA - FACTURA A o B 
						$totaliva=0;
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->debe=$model->ivatotal;
						$detAs2->cuenta_idcuenta=14;// cuenta 113200-cuenta Ret. y Percep. de IVA
						$detAs2->asiento_idasiento=$asiento->idasiento;
						$detAs2->save();
						
						$totaliibb=0;
						//detalle asiento de retenciones IIBB
						if($model->importeIIBB != null){
							$detAs3=new Detalleasiento;
							$totaliibb=$model->importeIIBB;
							$detAs3->debe=$model->importeIIBB;
							$detAs3->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
							$detAs3->asiento_idasiento=$asiento->idasiento;
							$detAs3->save();
						}
						//detalle asiento de impuesto interno
						$totalimpint=0;
						if($model->importeImpInt != null){
							$detAs4=new Detalleasiento;
							$totalimpint=$model->importeImpInt;
							$detAs4->debe=$model->importeImpInt;
							$detAs4->cuenta_idcuenta=101; //cuenta 431190 Impuestos internos						      Impuestos Internos            						
							$detAs4->asiento_idasiento=$asiento->idasiento;
							$detAs4->save();
						}
						// registro de venta
							$detAs5=new Detalleasiento;
							$totalventa=$model->importeneto - $totaliva - $totaliibb - $totalimpint;
							$detAs5->debe=$totalventa;
							$detAs5->cuenta_idcuenta=160;//431285 -devoluciones por ventas 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
						//------------------------------
							$model->save();
							if(isset($detalleCCcliente)){
								$detalleCC=Detallectactecliente::model()->findByPk($detalleCCcliente);
								$detalleCC->notacredito_idnotacredito=$model->idnotacredito;
								$detalleCC->save();
							}
							$asientoNotaC=Asiento::model()->findByPk($asiento->idasiento);
							$asientoNotaC->notacredito_idnotacredito=$model->idnotacredito;
							$asientoNotaC->save();
						$this->estadoFactura($model);
						$this->ivamovimiento($model, $_POST['Notacredito']);
					}
						
				$this->redirect(array('admin','id'=>$model->idnotacredito));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$modelviejo=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notacredito'])) {
			$model->attributes=$_POST['Notacredito'];
			if ($model->save()) {
				if($modelviejo->factura_idfactura == $model->factura_idfactura){
					$this->cambioImporteAsiento($modelviejo, $model, $_POST['Notacredito']['fecha']);
					$this->estadoFactura($model);
					
					if($this->cambioImporteCtaCte($modelviejo, $model, $_POST['Notacredito']['fecha'])){
						$this->modificarIvamovimiento($model, $_POST['Notacredito']['fecha']);
						if($_POST['Notacredito']['vista'] == 2){
							$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
						}
						$this->redirect(array('admin','id'=>$model->idnotacredito));
					}
				} else {
					$this->cambioDetalleAsiento($modelviejo, $model, $_POST['Notacredito']['fecha']);
					$this->cambioEstadoFactura($modelviejo, $model);
					if($this->cambioImporteCtaCte($modelviejo, $model, $_POST['Notacredito']['fecha'])){
						$this->modificarIvamovimiento($model, $_POST['Notacredito']['fecha']);
						if($_POST['Notacredito']['vista'] == 2){
							$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
						}
						$this->redirect(array('admin','id'=>$model->idnotacredito));
					}
				}
				
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$model=$this->loadModel($id);
			$factura=Factura::model()->findByPk($model->factura_idfactura);
			$factura->estado=0; //estado normal sin nota decredito
			$factura->save();
			// we only allow deletion via POST request
			if($this->borrado($model) && $this->borradoIvaMov($model)){
			$this->loadModel($id)->delete();
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Notacredito');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notacredito('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Notacredito'])) {
			$model->attributes=$_GET['Notacredito'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notacredito the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notacredito::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notacredito $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='notacredito-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionEnvioFactura(){
		$id=$_POST['data'];
		$factura=Factura::model()->findByPk($id);
		foreach ($factura as $key=>$valor){
			$dato[$key]=$valor;
		
		}
		echo json_encode($dato);
	}
	public function actionBorrar($id){
		$model=Notacredito::model()->findByPk($id);
		$factura=Factura::model()->findByPk($model->factura_idfactura);
		$factura->estado=0; //estado normal sin nota decredito
		$factura->save();
		if($this->borrado($model) && $this->borradoIvaMov($model)){
			if($model->delete()){
				echo "true";
				}
			}
	}
	
	public function ctacte($model, $datosPOST){
		$ctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
	 	$ctacte->haber=$ctacte->haber + $model->importeneto;
	 	$ctacte->saldo=$ctacte->debe - $ctacte->haber;
	 	if($ctacte->save()){
	 		$modelDeCCcliente= new Detallectactecliente;
	 		$modelDeCCcliente->fecha=$datosPOST['fecha'];
           	$modelDeCCcliente->descripcion="NOTA CREDITO -De Factura Venta N°: ".(string)$model->nrodefactura;
           	$modelDeCCcliente->tipo= 3;
           	//$modelDeCCcliente->factura_idfactura=$model->idfactura;
           	$modelDeCCcliente->haber=$model->importeneto;
           	$modelDeCCcliente->ctactecliente_idctactecliente=$ctacte->idctactecliente;
           	$modelDeCCcliente->save();
	 		return $modelDeCCcliente->iddetallectactecliente;
	 	} else {
	 		return false;
	 	}
	}
	public function cambioImporteAsiento($viejos, $nuevos, $fecha){
		if($viejos->importeneto != $nuevos->importeneto){
			if($viejos->fecha != $nuevos->fecha){
				$asiento=Asiento::model()->findByPk($viejos->asiento_idasiento);
				$asiento->fecha=$fecha;
				$asiento->save();
			}
			$iva=0;
			if($viejos->ivatotal != $nuevos->ivatotal){
				$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>14));// cuenta 113200-cuenta Ret. y Percep. de IVA
				$DeAsIVA->debe=$nuevos->ivatotal;
				$iva=$nuevos->ivatotal;
				$DeAsIVA->save();
				
			}
			$iibb=0;
			if($viejos->importeIIBB != $nuevos->importeIIBB){
				$DeAsIIBB=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>20));// cuenta 113700 Ret. Imp. Ingresos Brutos   
				$DeAsIIBB->debe=$nuevos->importeIIBB;
				$iibb=$nuevos->importeIIBB;
				$DeAsIIBB->save();
			}
			
			$impInt=0;
			if($viejos->importeImpInt != $nuevos->importeImpInt){
				$DeAsIMP=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>101));//cuenta 431190 Impuestos internos   
				$DeAsIMP->debe=$nuevos->importeImpInt;
				$impInt=$nuevos->importeImpInt;
				$DeAsIMP->save();
			}
			if($viejos->importeneto != $nuevos->importeneto){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>160));//431285 -devoluciones por ventas 
				$DeAsTN->debe=$nuevos->importeneto - $iva - $impInt - $iibb;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>11));//112100 deudores por venta
				$DeAsHaber->haber=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
		}
	}
	
	public function cambioImporteCtaCte($viejos, $nuevos, $fecha){
		if($viejos->importeneto != $nuevos->importeneto){
			$DeCtaCte=Detallectactecliente::model()->find("notacredito_idnotacredito=:id",
						array(':id'=>$viejos->idnotacredito));
			$DeCtaCte->fecha=$fecha;
			$DeCtaCte->haber=$nuevos->importeneto;
			if($DeCtaCte->save()){
				$CtaCte=Ctactecliente::model()->findByPk($viejos->clienteIdcliente->ctactecliente_idctactecliente);
				$CtaCte->haber=$CtaCte->haber - $viejos->importeneto + $nuevos->importeneto;
		 		$CtaCte->saldo=$CtaCte->debe - $CtaCte->haber;	
		 		return $CtaCte->save();
			}
			
		}
	}
	public function cambioDetalleAsiento($viejos, $nuevos,$fecha){
			if($viejos->fecha != $nuevos->fecha){
				$asiento=Asiento::model()->findByPk($viejos->asiento_idasiento);
				$asiento->fecha=$fecha;
				$asiento->descripcion="NOTA CREDITO - de Factura N°: ".$nuevos->nrodefactura;
				$asiento->save();
			}
			$iva=0;
			if($viejos->ivatotal != $nuevos->ivatotal){
				$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$nuevos->asiento_idasiento,
								  ':idcuenta'=>14));// cuenta 113200-cuenta Ret. y Percep. de IVA
				$DeAsIVA->debe=$nuevos->ivatotal;
				$iva=$nuevos->ivatotal;
				$DeAsIVA->save();
			}
	//------IIBB------------
			$iibb=0;
			if(($viejos->importeIIBB == null) && ($nuevos->importeIIBB != null)){
				$detAs=new Detalleasiento;
				$detAs->debe=$nuevos->importeIIBB;
				$detAs->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
				$detAs->asiento_idasiento=$viejos->asiento_idasiento;
				$iibb=$nuevos->importeIIBB;
				$detAs->save();
			}
			if(($viejos->importeIIBB != null) && ($nuevos->importeIIBB == null)){
				$DeAsIIBB=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>20));// cuenta 113700 Ret. Imp. Ingresos Brutos   
				$DeAsIIBB->delete();
			}
			if(($viejos->importeIIBB != null) && ($nuevos->importeIIBB != null)){
				$DeAsIIBB=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>20));// cuenta 113700 Ret. Imp. Ingresos Brutos   
				$DeAsIIBB->debe=$nuevos->importeIIBB;
				$iibb=$nuevos->importeIIBB;
				$DeAsIIBB->save();
			}
	//------------	
	//-----------impInt
			$imp=0;	
			if(($viejos->importeImpInt == null) && ($nuevos->importeImpInt != null)){
				$detAs4=new Detalleasiento;
				$detAs4->debe=$nuevos->importeImpInt;
				$detAs4->cuenta_idcuenta=101; //cuenta 431190 Impuestos internos						      Impuestos Internos            						
				$detAs4->asiento_idasiento=$viejos->asiento_idasiento;
				$imp=$nuevos->importeImpInt;
				$detAs4->save();
			}
			if(($viejos->importeImpInt != null) && ($nuevos->importeImpInt == null)){
				
				$DeAsImp=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>101));//cuenta 431190 Impuestos internos   
				$DeAsImp->delete();
				
			}
			if(($viejos->importeImpInt != null) && ($nuevos->importeImpInt != null)){
				$DeAsIMP=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>101));//cuenta 431190 Impuestos internos   
				$DeAsIMP->debe=$nuevos->importeImpInt;
				$imp=$nuevos->importeImpInt;
				$DeAsIMP->save();
			}
	//-------------------------
	//----------total devoluciones
			if($viejos->importeneto != $nuevos->importeneto){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>160));//431285 -devoluciones por ventas 
				$DeAsTN->debe=$nuevos->importeneto - $iva - $imp - $iibb;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>11));//112100 deudores por venta
				$DeAsHaber->haber=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
	}
	public function estadoFactura($nuevos){
		$factura=Factura::model()->findByPk($nuevos->factura_idfactura);
		if($nuevos->facturaIdfactura->cantidadproducto == $nuevos->cantidadproducto){
			$factura->estado=1; //factura anulada
		} elseif($nuevos->facturaIdfactura->cantidadproducto > $nuevos->cantidadproducto){
			$factura->estado=2; //devolucion de mercadería 
		}
			
		$factura->save();
		
	}
	public function cambioEstadoFactura($viejos, $nuevos){
		$facturavieja=Factura::model()->findByPk($viejos->factura_idfactura);
		$facturavieja->estado=0;
		$facturavieja->save();
		$this->estadoFactura($nuevos);
	}
	public function ivamovimiento($model,$datoPOST){
			$nuevo=new Ivamovimiento;
			$nuevo->fecha=$datoPOST['fecha'];
			$nuevo->tipomoviento=1; //compras por credito fiscal
			$nuevo->nrocomprobante=$model->nronotacredito;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			$nuevo->tipofactura=3;
			$nuevo->tipoiva=$model->iva;
			
			$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->notacredito_idnotacredito=$model->idnotacredito;
			$nuevo->save();
			
	} 	
	public function modificarIvamovimiento($model,$fecha){
		$nuevo=Ivamovimiento::model()->find("notacredito_idnotacredito=:id",
				array(':id'=>$model->idnotacredito));
			$nuevo->fecha=$fecha;
			$nuevo->nrocomprobante=$model->nronotacredito;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			//$nuevo->tipofactura=$model->tipofactura;
			//$nuevo->tipoiva=$model->iva;
			$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->save();
			
	}	
	public function borradoIvaMov($model){
			$ivamov=Ivamovimiento::model()->find("notacredito_idnotacredito=:notacredito",
					array(':notacredito'=>$model->idnotacredito));
			return $ivamov->delete();
		}	
	public function borrado($model){
			
				$ctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
				$ctacte->haber=$ctacte->haber - $model->importeneto;
				$ctacte->saldo=$ctacte->debe - $ctacte->haber;
				$ctacte->save();
				$Dctacte=Detallectactecliente::model()->find("notacredito_idnotacredito=:factura AND ctactecliente_idctactecliente=:ctacte",
								array(':factura'=>$model->idnotacredito,
									  ':ctacte'=>$ctacte->idctactecliente));
				return $Dctacte->delete();
			
			
		}
}