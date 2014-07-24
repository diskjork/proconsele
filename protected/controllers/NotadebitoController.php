<?php

class NotadebitoController extends Controller
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
		$model=new Notadebito;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notadebito'])) {
			$model->attributes=$_POST['Notadebito'];
			if ($model->validate()) {
			$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="NOTA DEBITO N°: ".$model->nronotadebito;
					if($asiento->save()){
						$model->asiento_idasiento=$asiento->idasiento;
						
						$detAs=new Detalleasiento;
						$detAs->debe=$model->importeneto;
						$detalleCCcliente=$this->ctacte($model,$_POST['Notadebito']);
						$detAs->cuenta_idcuenta=11;  //112100 deudores por venta
						$detAs->asiento_idasiento=$asiento->idasiento;
						$detAs->save();
						
						$totaliva=0;
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->haber=$model->ivatotal;
						$detAs2->cuenta_idcuenta=14;// cuenta 113200-cuenta Ret. y Percep. de IVA
						$detAs2->asiento_idasiento=$asiento->idasiento;
						$detAs2->save();
						
						// registro de la cuenta contable relacionada
							$detAs5=new Detalleasiento;
							$totalventa=$model->importeneto - $totaliva;
							$detAs5->haber=$totalventa;
							$detAs5->cuenta_idcuenta=$model->cuenta_idcuenta; 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
						//------------------------------
							$model->save();
							
							if(isset($detalleCCcliente)){
								$detalleCC=Detallectactecliente::model()->findByPk($detalleCCcliente);
								$detalleCC->notadebito_idnotadebito=$model->idnotadebito;
								$detalleCC->save();
							}
							$asientoNot=Asiento::model()->findByPk($asiento->idasiento);
							$asientoNot->notadebito_idnotadebito=$model->idnotadebito;
							$asientoNot->save();
							$this->ivamovimiento($model, $_POST['Notadebito']);
					}
				
				
				
				$this->redirect(array('admin','id'=>$model->idnotadebito));
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

		if (isset($_POST['Notadebito'])) {
			$model->attributes=$_POST['Notadebito'];
			if ($model->save()) {
				$this->cambioImporteAsiento($modelviejo,$model,$_POST['Notadebito']['fecha']);
				if($this->cambioImporteCtaCte($modelviejo, $model, $_POST['Notadebito']['fecha'])){
					$this->modificarIvamovimiento($model, $_POST['Notadebito']['fecha']);
					$this->redirect(array('view','id'=>$model->idnotadebito));
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
		$dataProvider=new CActiveDataProvider('Notadebito');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notadebito('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Notadebito'])) {
			$model->attributes=$_GET['Notadebito'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notadebito the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notadebito::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notadebito $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='notadebito-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionBorrar($id){
		$model=Notadebito::model()->findByPk($id);
		
		if($this->borrado($model) && $this->borradoIvaMov($model)){
			if($model->delete()){
				echo "true";
				}
			}
	}
	public function ctacte($model, $datosPOST){
		$ctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
	 	$ctacte->debe=$ctacte->debe + $model->importeneto;
	 	$ctacte->saldo=$ctacte->debe - $ctacte->haber;
	 	if($ctacte->save()){
	 		$modelDeCCcliente= new Detallectactecliente;
	 		$modelDeCCcliente->fecha=$datosPOST['fecha'];
           	$modelDeCCcliente->descripcion="NOTA DEBITO N°: ".(string)$model->nronotadebito." - ".$model->clienteIdcliente;
           	$modelDeCCcliente->tipo= 2; //nota de debito
           	//$modelDeCCcliente->factura_idfactura=$model->idfactura;
           	$modelDeCCcliente->debe=$model->importeneto;
           	$modelDeCCcliente->ctactecliente_idctactecliente=$ctacte->idctactecliente;
           	$modelDeCCcliente->save();
	 		return $modelDeCCcliente->iddetallectactecliente;
	 	} else {
	 		return false;
	 	}
	}
	public function ivamovimiento($model,$datoPOST){
			$nuevo=new Ivamovimiento;
			$nuevo->fecha=$datoPOST['fecha'];
			$nuevo->tipomoviento=0; //venta debito fiscal de iva
			$nuevo->nrocomprobante=$model->nronotadebito;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			$nuevo->tipofactura=4; //nota de debito
			$nuevo->tipoiva=$model->iva;
			//$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->notadebito_idnotadebito=$model->idnotadebito;
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
								  ':idcuenta'=>14));// cuenta 113200-cuenta Ret. y Percep. de IVA
				$DeAsIVA->haber=$nuevos->ivatotal;
				$iva=$nuevos->ivatotal;
				$DeAsIVA->save();
				
			}
			
			if(($viejos->importeneto != $nuevos->importeneto) || ($viejos->cuenta_idcuenta != $nuevos->cuenta_idcuenta)){
				$DeAsTN=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>$viejos->cuenta_idcuenta));
				$DeAsTN->cuenta_idcuenta=$nuevos->cuenta_idcuenta;						
				$DeAsTN->haber=$nuevos->importeneto - $iva ;
				$DeAsTN->save();
				
				$DeAsHaber=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
							array(':idasiento'=>$viejos->asiento_idasiento,
								  ':idcuenta'=>11));//112100 deudores por venta
				$DeAsHaber->debe=$nuevos->importeneto;
				$DeAsHaber->save();
				
			}
		}
	}
	
	public function cambioImporteCtaCte($viejos, $nuevos, $fecha){
		if($viejos->importeneto != $nuevos->importeneto){
			$DeCtaCte=Detallectactecliente::model()->find("notadebito_idnotadebito=:id",
						array(':id'=>$viejos->idnotadebito));
			$DeCtaCte->fecha=$fecha;
			$DeCtaCte->debe=$nuevos->importeneto;
			if($DeCtaCte->save()){
				$CtaCte=Ctactecliente::model()->findByPk($viejos->clienteIdcliente->ctactecliente_idctactecliente);
				$CtaCte->debe=$CtaCte->debe - $viejos->importeneto + $nuevos->importeneto;
		 		$CtaCte->saldo=$CtaCte->debe - $CtaCte->haber;	
		 		return $CtaCte->save();
			}
			
		}
	}
	
	public function modificarIvamovimiento($model,$fecha){
		$nuevo=Ivamovimiento::model()->find("notadebito_idnotadebito=:id",
				array(':id'=>$model->idnotadebito));
			$nuevo->fecha=$fecha;
			$nuevo->nrocomprobante=$model->nronotadebito;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			//$nuevo->tipofactura=$model->tipofactura;
			$nuevo->tipoiva=$model->iva;
			//$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->save();
			
	}
	public function borradoIvaMov($model){
			$ivamov=Ivamovimiento::model()->find("notadebito_idnotadebito=:notadebito",
					array(':notadebito'=>$model->idnotadebito));
			return $ivamov->delete();
		}	
	public function borrado($model){
			
				$ctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
				$ctacte->debe=$ctacte->debe - $model->importeneto;
				$ctacte->saldo=$ctacte->debe - $ctacte->haber;
				$ctacte->save();
				$Dctacte=Detallectactecliente::model()->find("notadebito_idnotadebito=:factura AND ctactecliente_idctactecliente=:ctacte",
								array(':factura'=>$model->idnotadebito,
									  ':ctacte'=>$ctacte->idctactecliente));
				return $Dctacte->delete();
			
			
		}	
}