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
						$netogravado=$model->netogravado;
						$D_R=0;
						if(($model->facturaIdfactura->descrecar != null) && ($model->facturaIdfactura->tipodescrecar != null)){
							
							if($model->facturaIdfactura->tipodescrecar == 0){
								$D_R=$netogravado * ($model->facturaIdfactura->descrecar /100) * -1;
								
							}else {
								$D_R=$netogravado * ($model->facturaIdfactura->descrecar /100);
							}
						}
					
						
						//disminuye la cta cte de deudores por venta
						$detAs=new Detalleasiento;
						$detAs->haber=$model->importeneto;
						$detAs->cuenta_idcuenta=11;  //112100 deudores por venta
						$detAs->asiento_idasiento=$asiento->idasiento;
						$detAs->save();
						$detalleCCcliente=$this->ctacte($model,$_POST['Notacredito']);
					//----------------------Descuento-------------
						if($D_R < 0){
							$model->tipodescrecar=0;
							$DeAsDesc=new Detalleasiento;
							$DeAsDesc->haber=$D_R * -1;
							$DeAsDesc->cuenta_idcuenta=143; //434090 Descuentos cedidos
							$DeAsDesc->asiento_idasiento=$asiento->idasiento;
							$DeAsDesc->save();
						}
						//------------------------------
						//detalle asiento de IVA - FACTURA A o B 
						$totaliva=0;
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->debe=$model->ivatotal;
						$detAs2->cuenta_idcuenta=68; //215100 IVA - Débito Fiscal
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
						//detalle asiento de percepcion iva
						if($model->importe_per_iva != null){
							$detAs5=new Detalleasiento;
							$totaliibb=$model->importe_per_iva;
							$detAs5->debe=$model->importe_per_iva;
							$detAs5->cuenta_idcuenta=14; // cuenta 113200 Ret. y Percep. de IVA							    
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
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
							$detAs5->debe=$model->netogravado;
							$detAs5->cuenta_idcuenta=$model->productoIdproducto->cuenta_idcuenta; 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
					//----------- Recargo -------
							if($D_R > 0){
							$model->tipodescrecar=1;
							$DeAsRecar=new Detalleasiento;
							$DeAsRecar->debe=$D_R;
							$DeAsRecar->cuenta_idcuenta=161; // recargos por ventas
							$DeAsRecar->asiento_idasiento=$asiento->idasiento;
							$DeAsRecar->save();
							}
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
					$this->cambioDescuentoRecargo($modelviejo, $model);
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
		$this->redirect(array('admin'));
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
			if($viejos->fecha != $nuevos->fecha){
				$asiento=Asiento::model()->findByPk($viejos->asiento_idasiento);
				$asiento->fecha=$fecha;
				$asiento->save();
			}
		if($viejos->importeneto != $nuevos->importeneto){
			
			$iva=0;
			if($viejos->ivatotal != $nuevos->ivatotal){
				$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>68)); //215100 IVA - Débito Fiscal
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
			if($viejos->importe_per_iva != $nuevos->importe_per_iva){
				$DeAsIMP=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>14)); // cuenta 113200 Ret. y Percep. de IVA	
				$DeAsIMP->debe=$nuevos->importe_per_iva;
				
				$DeAsIMP->save();
			}
			if(($viejos->facturaIdfactura->descrecar != null) && ($viejos->facturaIdfactura->tipodescrecar != null)){
							$netogravado=$nuevos->netogravado;
							if($viejos->facturaIdfactura->tipodescrecar == 0){
								$D_R= $netogravado * ($viejos->facturaIdfactura->descrecar /100) * -1;
								
							}else {
								$D_R=$netogravado * ($model->facturaIdfactura->descrecar /100);
							}
						}
			if($D_R < 0){
				$DeAsDes=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>143)); //434090 Descuentos cedidos
				$DeAsDes->haber=$D_R * -1;
				$DeAsDes->save();			
			} else {
				$DeAsDes=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>161)); // recargos por ventas
				$DeAsDes->debe=$D_R ;
				$DeAsDes->save();
			}
			if($viejos->importeneto != $nuevos->importeneto){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>$viejos->productoIdproducto->cuenta_idcuenta));//disminuye la venta
				$DeAsTN->debe=$nuevos->netogravado;
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
								  ':idcuenta'=>68)); //215100 IVA - Débito Fiscal
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
	//------_per_iva------------
			$perciva=0;
			if(($viejos->importe_per_iva == null) && ($nuevos->importe_per_iva != null)){
				$detAs=new Detalleasiento;
				$detAs->debe=$nuevos->importe_per_iva;
				$detAs->cuenta_idcuenta=14; // cuenta 113200 Ret. y Percep. de IVA
				$detAs->asiento_idasiento=$viejos->asiento_idasiento;
				$perciva=$nuevos->importe_per_iva;
				$detAs->save();
			}
			if(($viejos->importe_per_iva != null) && ($nuevos->importe_per_iva == null)){
				$DeAs_per_iva=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>14));
				$DeAs_per_iva->delete();
			}
			if(($viejos->importe_per_iva != null) && ($nuevos->importe_per_iva != null)){
				$DeAs_per_iva=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>14));
				$DeAs_per_iva->debe=$nuevos->importe_per_iva;
				$perciva=$nuevos->importe_per_iva;
				$DeAs_per_iva->save();
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
								  ':idcuenta'=>$viejos->productoIdproducto->cuenta_idcuenta)); 
				$DeAsTN->debe=$nuevos->netogravado;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>11));//112100 deudores por venta
				$DeAsHaber->haber=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
	}
	
	public function cambioDescuentoRecargo($viejos,$nuevos){
			
			if($viejos->facturaIdfactura->descrecar != $nuevos->facturaIdfactura->descrecar){
				if(($viejos->facturaIdfactura->descrecar == null) && ($nuevos->facturaIdfactura->descrecar != null)){
					if($nuevos->facturaIdfactura->tipodescrecar == 0){
						$DeAsDesc=new Detalleasiento;
						$DeAsDesc->haber= $nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsDesc->cuenta_idcuenta=143; //434090 Descuentos cedidos
						$DeAsDesc->asiento_idasiento=$viejos->asiento_idasiento;
						$DeAsDesc->save();						
					} else {
						$DeAsRecar=new Detalleasiento;
						$DeAsRecar->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsRecar->cuenta_idcuenta=161; // recargos por ventas
						$DeAsRecar->asiento_idasiento=$viejos->asiento_idasiento;
						$DeAsRecar->save();
					}
				} elseif(($viejos->facturaIdfactura->descrecar != null) && ($nuevos->facturaIdfactura->descrecar == null)){
					if($viejos->facturaIdfactura->tipodescrecar == 0){
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->delete();
					} else {
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->delete();
					}
				} elseif(($viejos->facturaIdfactura->descrecar != null) && ($nuevos->facturaIdfactura->descrecar != null)){
					if(($viejos->facturaIdfactura->tipodescrecar == 0) && ($nuevos->facturaIdfactura->tipodescrecar == 1)){
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->haber=null;
						$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsDesc->cuenta_idcuenta=161; // recargos por ventas
						$DeAsDesc->update();
					} elseif(($viejos->facturaIdfactura->tipodescrecar == 1) && ($nuevos->facturaIdfactura->tipodescrecar == 0)){
						$DeAsDescR=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDescR->debe=null;
						$DeAsDescR->haber=$nuevos->netogravado * ($nuevos->descrecar/100);					
						$DeAsDescR->cuenta_idcuenta=143; //434090 Descuentos cedidos
						$DeAsDescR->update();
					} elseif(($viejos->facturaIdfactura->tipodescrecar == $nuevos->facturaIdfactura->tipodescrecar)){
						if($viejos->facturaIdfactura->tipodescrecar == 0){
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						} else {
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						}
					}
				}
			} elseif(($viejos->facturaIdfactura->descrecar == $nuevos->facturaIdfactura->descrecar) && ($viejos->facturaIdfactura->descrecar != null)){
				if(($viejos->facturaIdfactura->tipodescrecar == 0) && ($nuevos->facturaIdfactura->tipodescrecar == 1)){
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->haber=null;
						$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsDesc->cuenta_idcuenta=161; // recargos por ventas
						$DeAsDesc->update();
					} elseif(($viejos->facturaIdfactura->tipodescrecar == 1) && ($nuevos->facturaIdfactura->tipodescrecar == 0)){
						$DeAsDescR=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDescR->debe=null;
						$DeAsDescR->haber=$nuevos->netogravado * ($nuevos->descrecar/100);					
						$DeAsDescR->cuenta_idcuenta=143; //434090 Descuentos cedidos
						$DeAsDescR->update();
					} elseif(($viejos->facturaIdfactura->tipodescrecar == $nuevos->facturaIdfactura->tipodescrecar)){
						if($viejos->facturaIdfactura->tipodescrecar == 0){
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						} else {
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						}
					}
				
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
			$nuevo->tipomoviento=0; //disminuye el débito fiscal
			$nuevo->nrocomprobante=$model->nronotacredito;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			$nuevo->tipofactura=3;
			$nuevo->tipoiva=$model->iva;
			if($model->importe_per_iva != 0 ){
			$nuevo->importe_per_iva=$model->importe_per_iva * -1;
			} else {
				$nuevo->importe_per_iva=null;
			}
			if($model->importeIIBB != 0){
			$nuevo->importeiibb=$model->importeIIBB * -1;
			} else {
				$nuevo->importeiibb=null;
			}
			$nuevo->importeiva=$model->ivatotal * -1;
			$nuevo->importeneto=$model->importeneto * -1; //importe total
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
			$nuevo->importe_per_iva=$model->importe_per_iva * -1;
			//$nuevo->tipoiva=$model->iva;
			$nuevo->importeiibb=$model->importeIIBB * -1;
			$nuevo->importeiva=$model->ivatotal * -1;
			$nuevo->importeneto=$model->importeneto * -1;
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
	public function labelMotivo($data, $row){	
		if($data->factura_idfactura == null){
			return "-";
		} else {
			if($data->cantidadproducto == $data->facturaIdfactura->cantidadproducto){
				return "Anulación Factura";
			}else {
				return "Devolución mercadería";
			}
			
		}
		
	}	
	public function labelDescripcion($data, $row){	
		
		if($data->factura_idfactura == null){
			return "-";
		} else {
			
				return "Relac. a la Factura Nro: ".$data->facturaIdfactura->nrodefactura." - ".$data->clienteIdcliente;
			}
			
		}
		
	public function actionImprimirNotaCredito($id) {
            
            $this->layout='//layouts/imprimir'; // defines el archivo protected/views/layouts/imprimir.php como layout por defecto sólo para esta acción.
            
            $notacredito = Notacredito::model()->findByPk($id); // agregas el código a ejecutar que cargará los datos que enviarás a la vista y que generarán tu factura
           
            //CON HTML2PDF
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            
            $html2pdf=Yii::app()->ePdf->mpdf('utf-8', 'Letter-L');
			$html2pdf->ignore_invalid_utf8 = true;
            $html2pdf = new HTML2PDF('P', 'A4', 'es');
	        $html2pdf->WriteHTML($this->render('imprimirNotaCredito', array('notacredito'=>$notacredito), true));
	        $html2pdf->Output();
 
            //$this->renderPartial('imprimirFactura',array('factura'=>$factura),false,true);
                        
        }
	
}