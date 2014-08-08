<?php

class NotadebitoprovController extends Controller
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
		$model=new Notadebitoprov;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

	if (isset($_POST['Notadebitoprov'])) {
			$model->attributes=$_POST['Notadebitoprov'];
			if ($model->validate()) {
			$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="NOTA DEBITO - Proveedor N°: ".$model->nronotadebitoprov." - ".$model->proveedorIdproveedor;
					if($asiento->save()){
						$model->asiento_idasiento=$asiento->idasiento;
						
						$detAs=new Detalleasiento;
						$detAs->haber=$model->importeneto;
						$detalleCCprov=$this->ctacte($model,$_POST['Notadebitoprov']);
						$detAs->cuenta_idcuenta=48;  //211100 Proveedores compras varias 
						$detAs->asiento_idasiento=$asiento->idasiento;
						$detAs->save();
						
						$totaliva=0;
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->debe=$model->ivatotal;
						$detAs2->cuenta_idcuenta=13;//113100 Iva - Crédito Fiscal
						$detAs2->asiento_idasiento=$asiento->idasiento;
						$detAs2->save();
						
						// registro de la cuenta contable relacionada
							$detAs5=new Detalleasiento;
							$totalventa=$model->importeneto - $totaliva;
							$detAs5->debe=$totalventa;
							$detAs5->cuenta_idcuenta=$model->cuenta_idcuenta; 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
						//------------------------------
							$model->save();
							
							if(isset($detalleCCprov)){
								$detalleCC=Detallectacteprov::model()->findByPk($detalleCCprov);
								$detalleCC->notadebitoprov_idnotadebitoprov=$model->idnotadebitoprov;
								$detalleCC->save();
							}
							$asientoNot=Asiento::model()->findByPk($asiento->idasiento);
							$asientoNot->notadebitoprov_idnotadebitoprov=$model->idnotadebitoprov;
							$asientoNot->save();
							$this->ivamovimiento($model, $_POST['Notadebitoprov']);
					}
				
				
				
				$this->redirect(array('admin','id'=>$model->idnotadebitoprov));
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

		if (isset($_POST['Notadebitoprov'])) {
			$model->attributes=$_POST['Notadebitoprov'];
			if ($model->save()) {
				if($model->proveedor_idproveedor != $modelviejo->proveedor_idproveedor){
					$this->cambioProveedor($modelviejo,$model);
				}
				if($model->nronotadebitoprov != $modelviejo->nronotadebitoprov){
					$this->cambioNombreAsiento($model);
				}
				$this->cambioImporteAsiento($modelviejo,$model,$_POST['Notadebitoprov']['fecha']);
				if($this->cambioImporteCtaCte($modelviejo, $model, $_POST['Notadebitoprov']['fecha'])){
					$this->modificarIvamovimiento($model, $_POST['Notadebitoprov']['fecha']);
					$this->redirect(array('admin','id'=>$model->idnotadebitoprov));
				}
				$this->redirect(array('admin','id'=>$model->idnotadebitoprov));
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
		$dataProvider=new CActiveDataProvider('Notadebitoprov');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notadebitoprov('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Notadebitoprov'])) {
			$model->attributes=$_GET['Notadebitoprov'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notadebitoprov the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notadebitoprov::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notadebitoprov $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='notadebitoprov-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionBorrar($id){
		$model=Notadebitoprov::model()->findByPk($id);
		
		if($this->borrado($model) && $this->borradoIvaMov($model)){
			if($model->delete()){
				echo "true";
				}
			}
	}
	public function ctacte($model, $datosPOST){
		$ctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
	 	$ctacte->haber=$ctacte->haber + $model->importeneto;
	 	$ctacte->saldo=$ctacte->debe - $ctacte->haber;
	 	if($ctacte->save()){
	 		$modelDeCCprov= new Detallectacteprov;
	 		$modelDeCCprov->fecha=$datosPOST['fecha'];
           	$modelDeCCprov->descripcion="NOTA DEBITO - Proveedor N°: ".(string)$model->nronotadebitoprov." - ".$model->proveedorIdproveedor;
           	$modelDeCCprov->tipo= 2; //nota de débito
           	//$modelDeCCprov->factura_idfactura=$model->idfactura;
           	$modelDeCCprov->haber=$model->importeneto;
           	$modelDeCCprov->ctacteprov_idctacteprov=$ctacte->idctacteprov;
           	$modelDeCCprov->save();
	 		return $modelDeCCprov->iddetallectacteprov;
	 	} else {
	 		return false;
	 	}
	}
	public function ivamovimiento($model,$datoPOST){
			$nuevo=new Ivamovimiento;
			$nuevo->fecha=$datoPOST['fecha'];
			$nuevo->tipomoviento=1; //venta crédito fiscal de iva
			$nuevo->nrocomprobante=$model->nronotadebitoprov;
			$nuevo->proveedor_idproveedor=$model->proveedor_idproveedor;
			$nuevo->cuitentidad=$model->proveedorIdproveedor->cuit;
			$nuevo->tipofactura=6; //nota de debito
			$nuevo->tipoiva=$model->iva;
			//$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->notadebitoprov_idnotadebitoprov=$model->idnotadebitoprov;
			$nuevo->save();
			
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
								  ':idcuenta'=>13));//113100 Iva - Crédito Fiscal
				$DeAsIVA->debe=$nuevos->ivatotal;
				$iva=$nuevos->ivatotal;
				$DeAsIVA->save();
				
			}
			
			if(($viejos->importeneto != $nuevos->importeneto) || ($viejos->cuenta_idcuenta != $nuevos->cuenta_idcuenta)){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>$viejos->cuenta_idcuenta));
				$DeAsTN->cuenta_idcuenta=$nuevos->cuenta_idcuenta;						
				$DeAsTN->debe=$nuevos->importeneto - $iva ;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>48));//211100 Proveedores compras varias 
				$DeAsHaber->haber=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
		}
	}
	
	public function cambioImporteCtaCte($viejos, $nuevos, $fecha){
		if($viejos->importeneto != $nuevos->importeneto){
			$DeCtaCte=Detallectacteprov::model()->find("notadebitoprov_idnotadebitoprov=:id",
						array(':id'=>$viejos->idnotadebitoprov));
			$DeCtaCte->fecha=$fecha;
			$DeCtaCte->haber=$nuevos->importeneto;
			if($DeCtaCte->save()){
				$CtaCte=Ctacteprov::model()->findByPk($viejos->proveedorIdproveedor->ctacteprov_idctacteprov);
				$CtaCte->haber=$CtaCte->haber - $viejos->importeneto + $nuevos->importeneto;
		 		$CtaCte->saldo=$CtaCte->debe - $CtaCte->haber;	
		 		return $CtaCte->save();
			}
			
		}
	}
	public function cambioProveedor($viejos,$nuevos){
		if($viejos->proveedor_idproveedor != $nuevos->proveedor_idproveedor){
			$CtaCtevieja=Ctacteprov::model()->findByPk($viejos->proveedorIdproveedor->ctacteprov_idctacteprov);
			$CtaCtevieja->haber=$CtaCtevieja->haber - $viejos->importeneto;
		 	$CtaCtevieja->saldo=$CtaCtevieja->debe - $CtaCtevieja->haber;
		 	$CtaCtevieja->save();
		 	$Ctactenueva=Ctacteprov::model()->findByPk($nuevos->proveedorIdproveedor->ctacteprov_idctacteprov);
		 	$Ctactenueva->haber=$Ctactenueva->haber + $nuevos->importeneto;
		 	$Ctactenueva->saldo=$Ctactenueva->debe - $Ctactenueva->haber;
		 	$Ctactenueva->save();
		 	$DeCC=Detallectacteprov::model()->find("notadebitoprov_idnotadebitoprov=:id",
						array(':id'=>$viejos->idnotadebitoprov));
			$DeCC->descripcion="NOTA DEBITO - Proveedor N°: ".(string)$nuevos->nronotadebitoprov." - ".$nuevos->proveedorIdproveedor;
			$DeCC->haber=$nuevos->importeneto;
           	$DeCC->ctacteprov_idctacteprov=$Ctactenueva->idctacteprov;
           	$DeCC->save();
		 	
		}
	}
	public function modificarIvamovimiento($model,$fecha){
		$nuevo=Ivamovimiento::model()->find("notadebitoprov_idnotadebitoprov=:id",
				array(':id'=>$model->idnotadebitoprov));
			$nuevo->fecha=$fecha;
			$nuevo->nrocomprobante=$model->nronotadebitoprov;
			$nuevo->proveedor_idproveedor=$model->proveedor_idproveedor;
			$nuevo->cuitentidad=$model->proveedorIdproveedor->cuit;
			//$nuevo->tipofactura=$model->tipofactura;
			$nuevo->tipoiva=$model->iva;
			//$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->save();
			
	}
	public function borradoIvaMov($model){
			$ivamov=Ivamovimiento::model()->find("notadebitoprov_idnotadebitoprov=:notadebitoprov",
					array(':notadebitoprov'=>$model->idnotadebitoprov));
			return $ivamov->delete();
		}	
	public function borrado($model){
			
				$ctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
				$ctacte->haber=$ctacte->haber - $model->importeneto;
				$ctacte->saldo=$ctacte->debe - $ctacte->haber;
				$ctacte->save();
				$Dctacte=Detallectacteprov::model()->find("notadebitoprov_idnotadebitoprov=:factura AND ctacteprov_idctacteprov=:ctacte",
								array(':factura'=>$model->idnotadebitoprov,
									  ':ctacte'=>$ctacte->idctacteprov));
				return $Dctacte->delete();
			
	}	
		public function cambioNombreAsiento($nuevo){
			$asiento=Asiento::model()->find("notadebitoprov_idnotadebitoprov=:id",array(':id'=>$nuevo->idnotadebitoprov));
			$asiento->descripcion="NOTA DEBITO - Proveedor N°: ".$nuevo->nronotadebitoprov." - ".$nuevo->proveedorIdproveedor;
			//$asiento->fecha=$fecha;
			$asiento->save();
			
		}
		
}