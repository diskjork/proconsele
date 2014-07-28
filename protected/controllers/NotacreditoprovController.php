<?php

class NotacreditoprovController extends Controller
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
		$model=new Notacreditoprov;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notacreditoprov'])) {
			$model->attributes=$_POST['Notacreditoprov'];
		if ($model->validate()) {
					$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="NOTA CREDITO de Proveedor - Compra N°: ".$model->nrodefactura;
					if($asiento->save()){
						$model->asiento_idasiento=$asiento->idasiento;
						
						//disminuye la cta cte de proveedores por venta
						$detAs=new Detalleasiento;
						$detAs->debe=$model->importeneto;
						$detAs->cuenta_idcuenta=48;  //211100 Proveedores compras varias 
						$detAs->asiento_idasiento=$asiento->idasiento;
						$detAs->save();
						$detalleCCprov=$this->ctacte($model,$_POST['Notacreditoprov']);
						//------------------------------
						//detalle asiento de IVA - FACTURA A o B 
						$totaliva=0;
						if($model->ivatotal != null ){
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->haber=$model->ivatotal;
						$detAs2->cuenta_idcuenta=14;// cuenta 113200-cuenta Ret. y Percep. de IVA
						$detAs2->asiento_idasiento=$asiento->idasiento;
						$detAs2->save();
						}
						$totaliibb=0;
						//detalle asiento de retenciones IIBB
						if($model->importeIIBB != null){
							$detAs3=new Detalleasiento;
							$totaliibb=$model->importeIIBB;
							$detAs3->haber=$model->importeIIBB;
							$detAs3->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
							$detAs3->asiento_idasiento=$asiento->idasiento;
							$detAs3->save();
						}
						// registro de venta
							$detAs5=new Detalleasiento;
							$totalventa=$model->importeneto - $totaliva - $totaliibb ;
							$detAs5->haber=$totalventa;
							$detAs5->cuenta_idcuenta=161;//580002 -devoluciones por compras
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
						//------------------------------
							$model->save();
							if(isset($detalleCCprov)){
								$detalleCC=Detallectacteprov::model()->findByPk($detalleCCprov);
								$detalleCC->notacreditoprov_idnotacreditoprov=$model->idnotacreditoprov;
								$detalleCC->save();
							}
							$asientoNotaC=Asiento::model()->findByPk($asiento->idasiento);
							$asientoNotaC->notacreditoprov_idnotacreditoprov=$model->idnotacreditoprov;
							$asientoNotaC->save();
						$this->estadoFactura($model);
						$this->ivamovimiento($model, $_POST['Notacreditoprov']);
					}
					$this->redirect(array('admin','id'=>$model->idnotacreditoprov));
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

		if (isset($_POST['Notacreditoprov'])) {
			$model->attributes=$_POST['Notacreditoprov'];
			if ($model->save()) {
				if($modelviejo->compras_idcompras == $model->compras_idcompras){
					$this->cambioImporteAsiento($modelviejo, $model, $_POST['Notacreditoprov']['fecha']);
					$this->estadoFactura($model);
					
					if($this->cambioImporteCtaCte($modelviejo, $model, $_POST['Notacreditoprov']['fecha'])){
						$this->modificarIvamovimiento($model, $_POST['Notacreditoprov']['fecha']);
						if($_POST['Notacreditoprov']['vista'] == 2){
							$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
						}
						$this->redirect(array('admin','id'=>$model->idnotacreditoprov));
					}
				} else {
					$this->cambioDetalleAsiento($modelviejo, $model, $_POST['Notacreditoprov']['fecha']);
					$this->cambioEstadoFactura($modelviejo, $model);
					if($this->cambioImporteCtaCte($modelviejo, $model, $_POST['Notacreditoprov']['fecha'])){
						$this->modificarIvamovimiento($model, $_POST['Notacreditoprov']['fecha']);
						if($_POST['Notacreditoprov']['vista'] == 2){
							$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
						}
						$this->redirect(array('admin','id'=>$model->idnotacreditoprov));
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
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
			
			
			if($this->borrado($model) && $this->borradoIvaMov($model)){
				$factura=Compras::model()->findByPk($model->compras_idcompras);
				$factura->estado=0; //estado normal sin nota decredito
				$factura->save();
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
		$dataProvider=new CActiveDataProvider('Notacreditoprov');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notacreditoprov('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Notacreditoprov'])) {
			$model->attributes=$_GET['Notacreditoprov'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notacreditoprov the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notacreditoprov::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notacreditoprov $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='notacreditoprov-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionEnvioFactura(){
		$id=$_POST['data'];
		$factura=Compras::model()->findByPk($id);
		foreach ($factura as $key=>$valor){
			$dato[$key]=$valor;
		
		}
		echo json_encode($dato);
	}
	public function ivamovimiento($model,$datoPOST){
			$nuevo=new Ivamovimiento;
			$nuevo->fecha=$datoPOST['fecha'];
			$nuevo->tipomoviento=0; //ventas por débito fiscal
			$nuevo->nrocomprobante=$model->nronotacreditoprov;
			$nuevo->proveedor_idproveedor=$model->proveedor_idproveedor;
			$nuevo->cuitentidad=$model->proveedorIdproveedor->cuit;
			$nuevo->tipofactura=5;
			$nuevo->tipoiva=$model->iva;
			
			$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->notacreditoprov_idnotacreditoprov=$model->idnotacreditoprov;
			$nuevo->save();
			
	} 	
	public function modificarIvamovimiento($model,$fecha){
		$nuevo=Ivamovimiento::model()->find("notacreditoprov_idnotacreditoprov=:id",
				array(':id'=>$model->idnotacreditoprov));
			$nuevo->fecha=$fecha;
			$nuevo->nrocomprobante=$model->nronotacreditoprov;
			$nuevo->proveedor_idproveedor=$model->proveedor_idproveedor;
			$nuevo->cuitentidad=$model->proveedorIdproveedor->cuit;
			$nuevo->tipofactura=$model->tipofactura;
			$nuevo->tipoiva=$model->iva;
			$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->save();
			
	}	
	public function borradoIvaMov($model){
			$ivamov=Ivamovimiento::model()->find("notacreditoprov_idnotacreditoprov=:notacreditoprov",
					array(':notacreditoprov'=>$model->idnotacreditoprov));
			return $ivamov->delete();
		}	
	public function borrado($model){
			
				$ctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
				$ctacte->debe=$ctacte->debe - $model->importeneto;
				$ctacte->saldo=$ctacte->debe - $ctacte->haber;
				$ctacte->save();
				$Dctacte=Detallectacteprov::model()->find("notacreditoprov_idnotacreditoprov=:factura AND ctacteprov_idctacteprov=:ctacte",
								array(':factura'=>$model->idnotacreditoprov,
									  ':ctacte'=>$ctacte->idctacteprov));
				return $Dctacte->delete();
			
			
		}
public function actionBorrar($id){
		$model=Notacreditoprov::model()->findByPk($id);
		$factura=Compras::model()->findByPk($model->compras_idcompras);
		$factura->estado=0; //estado normal sin nota decredito
		$factura->save();
		if($this->borrado($model) && $this->borradoIvaMov($model)){
			if($model->delete()){
				echo "true";
				}
			}
	}
	
	public function ctacte($model, $datosPOST){
		$ctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
	 	$ctacte->debe=$ctacte->debe + $model->importeneto;
	 	$ctacte->saldo=$ctacte->debe - $ctacte->haber;
	 	if($ctacte->save()){
	 		$modelDeCCprov= new Detallectacteprov;
	 		$modelDeCCprov->fecha=$datosPOST['fecha'];
           	$modelDeCCprov->descripcion="NOTA CREDITO de Proveedor - Compra N°: ".(string)$model->nrodefactura;
           	$modelDeCCprov->tipo= 3; // nota de credito
           	//$modelDeCCcliente->factura_idfactura=$model->idfactura;
           	$modelDeCCprov->debe=$model->importeneto;
           	$modelDeCCprov->ctacteprov_idctacteprov=$ctacte->idctacteprov;
           	$modelDeCCprov->save();
	 		return $modelDeCCprov->iddetallectacteprov;
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
								  ':idcuenta'=>14));// cuenta 113200-cuenta Ret. y Percep. de IVA
				$DeAsIVA->haber=$nuevos->ivatotal;
				$iva=$nuevos->ivatotal;
				$DeAsIVA->save();
				
			}
			$iibb=0;
			if($viejos->importeIIBB != $nuevos->importeIIBB){
				$DeAsIIBB=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>20));// cuenta 113700 Ret. Imp. Ingresos Brutos   
				$DeAsIIBB->haber=$nuevos->importeIIBB;
				$iibb=$nuevos->importeIIBB;
				$DeAsIIBB->save();
			}
			
			
			if($viejos->importeneto != $nuevos->importeneto){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>161));//431285 -devoluciones por ventas 
				$DeAsTN->haber=$nuevos->importeneto - $iva - $iibb;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>48));  //211100 Proveedores compras varias 
				$DeAsHaber->debe=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
		}
	}
	
	public function cambioImporteCtaCte($viejos, $nuevos, $fecha){
		if($viejos->importeneto != $nuevos->importeneto){
			$DeCtaCte=Detallectacteprov::model()->find("notacreditoprov_idnotacreditoprov=:id",
						array(':id'=>$viejos->idnotacreditoprov));
			$DeCtaCte->fecha=$fecha;
			$DeCtaCte->debe=$nuevos->importeneto;
			if($DeCtaCte->save()){
				$CtaCte=Ctacteprov::model()->findByPk($viejos->proveedorIdproveedor->ctacteprov_idctacteprov);
				$CtaCte->debe=$CtaCte->debe - $viejos->importeneto + $nuevos->importeneto;
		 		$CtaCte->saldo=$CtaCte->debe - $CtaCte->haber;	
		 		return $CtaCte->save();
			}
			
		}
	}
	public function cambioDetalleAsiento($viejos, $nuevos,$fecha){
			if($viejos->fecha != $nuevos->fecha){
				$asiento=Asiento::model()->findByPk($viejos->asiento_idasiento);
				$asiento->fecha=$fecha;
				$asiento->descripcion="NOTA CREDITO de Proveedor - Compra N°: ".$nuevos->nrodefactura;
				$asiento->save();
			}
			$iva=0;
			if($viejos->ivatotal != $nuevos->ivatotal){
				$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$nuevos->asiento_idasiento,
								  ':idcuenta'=>14));// cuenta 113200-cuenta Ret. y Percep. de IVA
				$DeAsIVA->haber=$nuevos->ivatotal;
				$iva=$nuevos->ivatotal;
				$DeAsIVA->save();
			}
	//------IIBB------------
			$iibb=0;
			if(($viejos->importeIIBB == null) && ($nuevos->importeIIBB != null)){
				$detAs=new Detalleasiento;
				$detAs->haber=$nuevos->importeIIBB;
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
				$DeAsIIBB->haber=$nuevos->importeIIBB;
				$iibb=$nuevos->importeIIBB;
				$DeAsIIBB->save();
			}
	//------------	
	//-----------impInt
			/*$imp=0;	
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
			}*/
	//-------------------------
	//----------total devoluciones
			if($viejos->importeneto != $nuevos->importeneto){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>161));// -devoluciones por compras
				$DeAsTN->haber=$nuevos->importeneto - $iva -$iibb;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>48));  //211100 Proveedores compras varias 
				$DeAsHaber->debe=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
	}
	public function estadoFactura($nuevos){
		$factura=Compras::model()->findByPk($nuevos->compras_idcompras);
		if($nuevos->comprasIdcompras->importeneto == $nuevos->importeneto){
			$factura->estado=1; //compra  anulada
		} elseif($nuevos->comprasIdcompras->importeneto > $nuevos->importeneto){
			$factura->estado=2; //devolucion de mercadería 
		}
		
		$factura->save();
	}
	public function cambioEstadoFactura($viejos, $nuevos){
		$facturavieja=Compras::model()->findByPk($viejos->compras_idcompras);
		$facturavieja->estado=0;
		$facturavieja->save();
		$this->estadoFactura($nuevos);
	}
}