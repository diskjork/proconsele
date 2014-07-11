<?php

class ComprasController extends Controller
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
			'accessControl', // perform access control for CRUD operations
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
		$model=new Compras;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Compras'])) {
			$model->attributes=$_POST['Compras'];
		if ($model->validate()) {
					
					$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="Factura ".$this->tipoFactura($model->tipofactura)." Compra N°: ".$model->nrodefactura." -  ".$model->proveedorIdproveedor;
					$totaliva=0;
					$totaliibb=0;
					if($asiento->save()){
						
						$model->asiento_idasiento=$asiento->idasiento;
						
						if($model->tipofactura == 1){
							$detAs2=new Detalleasiento;
							$totaliva=$model->ivatotal;
							$detAs2->debe=$model->ivatotal; //por que el iva es un credito fiscal
							$detAs2->cuenta_idcuenta=14;// cuenta 113200-cuenta Ret. y Percep. de IVA
							$detAs2->asiento_idasiento=$asiento->idasiento;
							$detAs2->save();
							
							
							//detalle asiento de retenciones IIBB
							if($model->importeIIBB != null){
								$detAs3=new Detalleasiento;
								$totaliibb=$model->importeIIBB;
								$detAs3->debe=$model->importeIIBB; //percepción IIBB a favor de la empresa
								$detAs3->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
								$detAs3->asiento_idasiento=$asiento->idasiento;
								$detAs3->save();
							}
						}
						// registro de la compra dependiendo de cuenta_idcuenta
							$detAs5=new Detalleasiento;
							$totalcompra=$model->importeneto - $totaliva - $totaliibb;
							$detAs5->debe=$totalcompra;
							$detAs5->cuenta_idcuenta=$model->cuenta_idcuenta; 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
						//------------------------------
						// Para asentar la otra parte del asiento "FORMA DE PAGO"
							$detAs=new Detalleasiento;
							$detAs->haber=$model->importeneto;
							//forma de pago 
							if($model->formadepago != 99999){//es pago con alguna caja?
									$detAs->cuenta_idcuenta=$model->cajaIdcaja->cuenta_idcuenta;
									$movCaja= $this->movCaja($model,$_POST['Compras']);
								} elseif($model->formadepago == 99999){//es en cta corriente
									$detalleCprov=$this->ctacte($model,$_POST['Compras']);
									$detAs->cuenta_idcuenta=48;  //211100 Proveedores compras varias 
							}
							$detAs->asiento_idasiento=$asiento->idasiento;
							$detAs->save();
						//------------------------------	
							$model->save();
							if(isset($movCaja)){
								$modelmovcaja=Movimientocaja::model()->findByPk($movCaja);
								$modelmovcaja->idcompra=$model->idcompra;
								$modelmovcaja->save();
								$modelF=Compras::model()->findByPk($model->idcompra);
								$modelF->movimientocaja_idmovimientocaja=$movCaja;
								$modelF->save();
							}
							if(isset($detalleCprov)){
								$detalleCC=Detallectacteprov::model()->findByPk($detalleCprov);
								$detalleCC->compra_idcompra=$model->idcompra;
								$detalleCC->save();
							}
							$asientoCompra=Asiento::model()->findByPk($asiento->idasiento);
							$asientoCompra->compra_idcompra=$model->idcompra;
							$asientoCompra->save();
							if($model->tipofactura == 1){
							$this->ivamovimiento($model, $_POST['Compras']);
							}
					}
				$this->redirect(array('admin','id'=>$model->idcompra));
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
		$modeloviejo=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Compras'])) {
			$model->attributes=$_POST['Compras'];
			//die();
			if ($model->save()) {
				
				//se modifica la forma de pago pero no el tipo de factura
				if(($model->formadepago != $modeloviejo->formadepago) && ($modeloviejo->tipofactura == $model->tipofactura)){
					$this->updateDatosAsiento($modeloviejo, $model, $_POST['Compras']);
					$this->updateCambioFormadepago($modeloviejo, $model, $_POST['Compras']);
					if($modeloviejo->tipofactura == 1){
						$this->updateImpuestos($modeloviejo, $model);
						$this->updateTotalAsVta($modeloviejo, $model);
						
				    } else {
				    	$this->updateTotalAsVta($modeloviejo, $model);
				    }
				    $this->updateIvaMovimiento($modeloviejo, $model, $_POST['Compras']['fecha']);
					if($_POST['Factura']['vista'] == 2){
						$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
				    $this->redirect(array('admin','id'=>$model->idcompra));
				}
				//se modifica el tipofactura pero no la forma de pago
				if(($model->formadepago == $modeloviejo->formadepago) && ($modeloviejo->tipofactura != $model->tipofactura)){
					$this->updateDatosAsiento($modeloviejo, $model, $_POST['Compras']);
					//todo el debe
					$this->cambioTipofactura($modeloviejo, $model, $_POST['Compras']);
					//todo el haber
					$this->updateHaberAsiento($modeloviejo, $model, $_POST['Compras']);
					$this->updateIvaMovimiento($modeloviejo, $model, $_POST['Compras']['fecha']);
					if($_POST['Factura']['vista'] == 2){
						$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
					$this->redirect(array('admin','id'=>$model->idcompra));
				}
				//se modifican formadepago y tipofactura
				if(($model->formadepago != $modeloviejo->formadepago) && ($modeloviejo->tipofactura != $model->tipofactura)){
					$this->updateDatosAsiento($modeloviejo, $model, $_POST['Compras']);
					$this->updateCambioFormadepago($modeloviejo, $model, $_POST['Compras']);
					$this->cambioTipofactura($modeloviejo, $model, $_POST['Compras']);
					if($model->tipofactura == 1){
						$this->updateImpuestos($modeloviejo, $model);
					} 
				   $this->updateIvaMovimiento($modeloviejo, $model, $_POST['Compras']['fecha']);
					if($_POST['Factura']['vista'] == 2){
						$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
				   $this->redirect(array('admin','id'=>$model->idcompra));
				}
				//que solo se actualizen algunos campos menos formadepago y tipofactura
				if(($model->formadepago == $modeloviejo->formadepago) && ($modeloviejo->tipofactura == $model->tipofactura)){
				$this->updateDatosAsiento($modeloviejo, $model, $_POST['Compras']);
				if($modeloviejo->tipofactura == 1){
						$this->updateImpuestos($modeloviejo, $model);
						$this->updateTotalAsVta($modeloviejo, $model);
				    } else {
				    	$this->updateTotalAsVta($modeloviejo, $model);
				    }
				$this->updateHaberAsiento($modeloviejo, $model, $_POST['Compras']);
				$this->updateIvaMovimiento($modeloviejo, $model, $_POST['Compras']['fecha']);
				if($_POST['Factura']['vista'] == 2){
					$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
				}
				$this->redirect(array('admin','id'=>$model->idcompra));
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
			if($this->borrado($model)){
				if($model->tipofactura == 1){
					if($this->borradoIvaMov($model)){
						$this->loadModel($id)->delete();
					}
				}
			
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
		$dataProvider=new CActiveDataProvider('Compras');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Compras('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Compras'])) {
			$model->attributes=$_GET['Compras'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Compras the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Compras::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Compras $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='compras-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
public function movCaja($model,$datosPOST){
		$mov=new Movimientocaja;
		$mov->descripcion="Factura ".$this->tipoFactura($model->tipofactura)." Compra N°: ".$model->nrodefactura." -  ".$model->proveedorIdproveedor;
		$mov->fecha=$datosPOST['fecha'];
		$mov->debeohaber=0;
		$mov->haber=$model->importeneto;
		$mov->caja_idcaja=$model->formadepago;
		//$mov->asiento_idasiento=$modelasiento->idasiento;
		$mov->cuenta_idcuenta=$model->cuenta_idcuenta; //para la cuenta relacionada a la venta del producto vendido.
		//el id_de_trabajo lo guardo luego de hacer el save() del modelo de factura para relacionarlos.
		$mov->save();
		return $mov->idmovimientocaja;
	}
	public function ctacte($model, $datosPOST){
		$ctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
	 	$ctacte->debe=$ctacte->debe + $model->importeneto;
	 	$ctacte->saldo=$ctacte->debe - $ctacte->haber;
	 	if($ctacte->save()){
	 		$modelDeCprov= new Detallectacteprov;
	 		$modelDeCprov->fecha=$datosPOST['fecha'];
           	$modelDeCprov->descripcion="Factura ".$this->tipoFactura($model->tipofactura)." Compra N°: ".$model->nrodefactura." -  ".$model->proveedorIdproveedor;
           	$modelDeCprov->tipo= 0;
           	//$modelDeCprov->iddocumento=$model->idfactura;
           	$modelDeCprov->debe=$model->importeneto;
           	$modelDeCprov->ctacteprov_idctacteprov=$ctacte->idctacteprov;
           	$modelDeCprov->save();
	 		return $modelDeCprov->iddetallectacteprov;
	 	} else {
	 		return false;
	 	}
	}
	
	//método que realiza el cambio de forma de pago (movimientocaja, asiento, ctactecliente)


	
	public function updateCambioFormadepago($model,$nuevodatos,$datosPOST){ //$model=datos viejos
		if($nuevodatos->formadepago != 99999){ // el nuevo es movimiento de caja
				//asiento
				if($model->formadepago == 99999){
				$DTasientoCC=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>48,
												  ':asiento'=>$model->asiento_idasiento));
				}else {
				$DTasientoCC=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>$model->cajaIdcaja->cuenta_idcuenta,
												  ':asiento'=>$model->asiento_idasiento));	
				}
				
																				
				$DTasientoCC->cuenta_idcuenta=$nuevodatos->cajaIdcaja->cuenta_idcuenta;
				$DTasientoCC->haber=$nuevodatos->importeneto;
				$DTasientoCC->save();
				
				/*$this->updateImpuestos($model, $nuevodatos);	
				$this->updateTotalAsVta($model, $nuevodatos);
				*/
				
				//nuevo movimiento caja
				$movCajaNuevo=$this->movCaja($nuevodatos,$datosPOST);
				if(isset($movCajaNuevo)){
					$modelmovcaja=Movimientocaja::model()->findByPk($movCajaNuevo);
								$modelmovcaja->idcompra=$model->idcompra;
								$modelmovcaja->save();
				}
				
				$modelNuevo=Compras::model()->findByPk($model->idcompra);
				$modelNuevo->movimientocaja_idmovimientocaja=$modelmovcaja->idmovimientocaja;
				$modelNuevo->save();
				//para decrementar y borrar el detalle de ctacteprov
				$Nctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
	 			$Nctacte->debe=$Nctacte->debe - $model->importeneto;
	 			$Nctacte->saldo=$Nctacte->debe - $Nctacte->haber;
	 			$Nctacte->save();
	 			$Dctacte=Detallectacteprov::model()->find('compra_idcompra=:factura',
	 											array(':factura'=>$model->idcompra));
	 			$Dctacte->delete();
				
			} elseif($nuevodatos->formadepago == 99999){ // el nuevo es en ctacte
				//para el detalle de asiento
				$DTasiento=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>$model->cajaIdcaja->cuenta_idcuenta,
												  ':asiento'=>$model->asiento_idasiento));
				
				$DTasiento->cuenta_idcuenta=48;
				$DTasiento->haber=$nuevodatos->importeneto;
				$DTasiento->save();
				/*
				$this->updateImpuestos($model, $nuevodatos);
				$this->updateTotalAsVta($model, $nuevodatos);	
				*/
				//borra el movimiento de caja anterior
				$movCaja=Movimientocaja::model()->findByPk($model->movimientocaja_idmovimientocaja);
				$movCaja->delete();
				//modifiar los datos de ctactecliente
				$Dctacte=$this->ctacte($nuevodatos, $datosPOST);
				$modelNuevo=Compras::model()->findByPk($model->idcompra);
				$modelNuevo->movimientocaja_idmovimientocaja=  NULL;
				$modelNuevo->save();
				$Dectacte=Detallectacteprov::model()->findByPk($Dctacte);
				$Dectacte->compra_idcompra=$nuevodatos->idcompra;
				$Dectacte->save();
			}
		}
	
	
	public function updateImpuestos($datosviejos,$datosnuevos){
			// IVATOTAL
				if($datosviejos->ivatotal != $datosnuevos->ivatotal){
					if(($datosviejos->ivatotal != null) && ($datosnuevos->ivatotal != null)){
						$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>14));
						$DeAsIVA->debe=$datosnuevos->ivatotal;
						$DeAsIVA->save();
					} elseif(($datosviejos->ivatotal == null) && ($datosnuevos->ivatotal != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=14; //cuenta retenciones IVA
						$NuevoDeAs->debe=$datosnuevos->ivatotal;
						$NuevoDeAs->save();
					} elseif(($datosviejos->ivatotal != null) && ($datosnuevos->ivatotal == null)){
						$DeGuardado=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>14));
						$DeGuardado->delete();	
					}
					
				}
				// IMPORTEIIBB
				if($datosviejos->importeIIBB != $datosnuevos->importeIIBB){
					if(($datosviejos->importeIIBB != null) && ($datosnuevos->importeIIBB != null)){
						$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>20));
						$DeAsIVA->debe=$datosnuevos->importeIIBB;
						$DeAsIVA->save();
					} elseif(($datosviejos->importeIIBB == null) && ($datosnuevos->importeIIBB != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=20; //cuenta retenciones IIBB
						$NuevoDeAs->debe=$datosnuevos->importeIIBB;
						$NuevoDeAs->save();
					} elseif(($datosviejos->importeIIBB != null) && ($datosnuevos->importeIIBB == null)){
						$DeGuardado=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>20));
						$DeGuardado->delete();	
					}
					
				}
				
		}
	public function updateTotalAsVta($datosviejos,$datosnuevos){ 
		$DeAsVta=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
										array(':cuenta'=>$datosviejos->cuenta_idcuenta,
											  ':asiento'=>$datosviejos->asiento_idasiento));
		$totalvtaviejo=$this->totalventa($datosviejos);
		$totalvtanuevo=$this->totalventa($datosnuevos);
		if($datosviejos->cuenta_idcuenta != $datosnuevos->cuenta_idcuenta){
			$DeAsVta->cuenta_idcuenta=$datosnuevos->cuenta_idcuenta;
			if($totalvtaviejo != $totalvtanuevo){
				$DeAsVta->debe=$totalvtanuevo;
				$DeAsVta->save();
			}
			$DeAsVta->save();	
		} else {
			if($totalvtaviejo != $totalvtanuevo){
				$DeAsVta->debe=$totalvtanuevo;
				$DeAsVta->save();
			}
		}
		
	
	}
	public function totalventa($model){
		
		$model->ivatotal == null ? $iva=0 : $iva=$model->ivatotal;	
		$model->importeIIBB == null ? $iibb=0 : $iibb=$model->importeIIBB;
		if($model->tipofactura == 1){
		$totalventa=$model->importeneto - $iva - $iibb;
		} else {
			$totalventa=$model->importeneto;
		}
		return $totalventa;
	}
	public function borrado($model){
		if($model->formadepago != 99999){ //movimientocaja
			$movCaja=Movimientocaja::model()->find("idcompra=:id",array(':id'=>$model->idcompra));
			return $movCaja->delete();
			
		} else {//ctacte 
			$ctacte=Ctacteprov::model()->findByPk($model->proveedorIdproveedor->ctacteprov_idctacteprov);
			$ctacte->debe=$ctacte->debe - $model->importeneto;
			$ctacte->saldo=$ctacte->debe - $ctacte->haber;
			$ctacte->save();
			$Dctacte=Detallectacteprov::model()->find("compra_idcompra=:factura AND ctacteprov_idctacteprov=:ctacte",
							array(':factura'=>$model->idcompra,
								  ':ctacte'=>$ctacte->idctacteprov));
			return $Dctacte->delete();
		}
		
	}
	public function ivamovimiento($model,$datoPOST){
		$nuevo=new Ivamovimiento;
		$nuevo->fecha=$datoPOST['fecha'];
		$nuevo->tipomoviento=1; //compras
		$nuevo->nrocomprobante=$model->nrodefactura;
		$nuevo->proveedor_idproveedor=$model->proveedor_idproveedor;
		$nuevo->cuitentidad=$model->proveedorIdproveedor->cuit;
		$nuevo->tipofactura=$model->tipofactura;
		$nuevo->tipoiva=$model->iva;
		$nuevo->importeiibb=$model->importeIIBB;
		$nuevo->importeiva=$model->ivatotal;
		$nuevo->importeneto=$model->importeneto;
		$nuevo->compra_idcompra=$model->idcompra;
		$nuevo->save();
		
	}
	public function updateIvaMovimiento($datosviejos, $datosnuevos, $fecha){
		if(($datosviejos->tipofactura == 1) && ($datosnuevos->tipofactura == 1)){
		$IvaMovGuardado=Ivamovimiento::model()->find("compra_idcompra:=idcompra",
						array(':idcompra'=>$datosviejos->idcompra));
		$IvaMovGuardado->fecha=$fecha;
		$IvaMovGuardado->nrocomprobante=$datosnuevos->nrofactura;
		$IvaMovGuardado->proveedor_idproveedor=$datosnuevos->proveedor_idproveedor;
		$IvaMovGuardado->cuitentidad=$datosnuevos->proveedorIdproveedor->cuit;
		$IvaMovGuardado->tipofactura=$datosnuevos->tipofactura;
		$IvaMovGuardado->tipoiva=$datosnuevos->iva;
		$IvaMovGuardado->importeiibb=$datosnuevos->importeIIBB;
		$IvaMovGuardado->importeiva=$datosnuevos->ivatotal;
		$IvaMovGuardado->importeneto=$datosnuevos->importeneto;
		$IvaMovGuardado->save();
		} elseif(($datosviejos->tipofactura == 1) && ($datosnuevos->tipofactura > 1) ) {
			$IvaMovGuardado=Ivamovimiento::model()->find("compra_idcompra:=idcompra",
						array(':idcompra'=>$datosviejos->idcompra));
			$IvaMovGuardado->delete();
		} elseif(($datosviejos->tipofactura > 1) &&($datosnuevos->tipofactura == 1)){
			$IvaMovGuardado=new Ivamovimiento;
			$IvaMovGuardado->fecha=$fecha;
			$IvaMovGuardado->nrocomprobante=$datosnuevos->nrofactura;
			$IvaMovGuardado->proveedor_idproveedor=$datosnuevos->proveedor_idproveedor;
			$IvaMovGuardado->cuitentidad=$datosnuevos->proveedorIdproveedor->cuit;
			$IvaMovGuardado->tipofactura=$datosnuevos->tipofactura;
			$IvaMovGuardado->tipoiva=$datosnuevos->iva;
			$IvaMovGuardado->importeiibb=$datosnuevos->importeIIBB;
			$IvaMovGuardado->importeiva=$datosnuevos->ivatotal;
			$IvaMovGuardado->importeneto=$datosnuevos->importeneto;
			$IvaMovGuardado->save();	
		}
	}
	
	public function borradoIvaMov($model){
		$ivamov=Ivamovimiento::model()->find("compra_idcompra=:factura",array(':factura'=>$model->idcompra));
		return $ivamov->delete();
	}
	//corresponde a la actualizacion de la parde del debe del  asiento
	public function cambioTipofactura($datosviejos, $datosnuevos, $datosPOST){
		if(($datosviejos->tipofactura == 1) && ($datosnuevos->tipofactura > 1)){
			
			//detalle del asiento de la cuenta al impuesto, se borra ya que se pasa  a una factura tipo B 
			//y no se contabiliza el crédito fiscal en este caso
			$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
					array(":idasiento"=>$datosviejos->asiento_idasiento,
						  ":idcuenta"=>14));// cuenta 113200-cuenta Ret. y Percep. de IVA
			$DeAsIVA->delete();
			//detalle si existe un asiento de IIBB
			if($datosviejos->importeIIBB != null){
				$DeAsIIBB=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:idcuenta",
					array(":idasiento"=>$datosviejos->asiento_idasiento,
						  ":idcuenta"=>20));// cuenta 113700 Ret. Imp. Ingresos Brutos
				$DeAsIIBB->delete();
			}
			$modelGuardado=Compras::model()->findByPk($datosnuevos->idcompra);
			$modelGuardado->importeIIBB=null;
			$modelGuardado->ivatotal=null;
			$modelGuardado->save();
			// detalle asiento de la cuenta relacionada tambien cuando cambia la cuenta_idcuenta
			$this->updateTotalAsVta($datosviejos, $datosnuevos);
		}
		if(($datosviejos->tipofactura > 1 ) && ($datosnuevos->tipofactura == 1)){
			
			//detalle asiento nuevo para el IVA
			$DeAsIVA=new Detalleasiento;
			$totaliva=$datosnuevos->ivatotal;
			$DeAsIVA->debe=$datosnuevos->ivatotal; //por que el iva es un credito fiscal
			$DeAsIVA->cuenta_idcuenta=14;// cuenta 113200-cuenta Ret. y Percep. de IVA
			$DeAsIVA->asiento_idasiento=$datosviejos->asiento_idasiento;
			$DeAsIVA->save();
		//detalle asiento de retenciones IIBB
			if($datosnuevos->importeIIBB != null){
				$detAs3=new Detalleasiento;
				$detAs3->debe=$datosnuevos->importeIIBB; //percepción IIBB a favor de la empresa
				$detAs3->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
				$detAs3->asiento_idasiento=$datosviejos->asiento_idasiento;
				$detAs3->save();
			}
		// detalle asiento de la cuenta relacionada tambien cuando cambia la cuenta_idcuenta
			$this->updateTotalAsVta($datosviejos, $datosnuevos);		
			
		}  
		
	}
	public function updateDatosAsiento($datosviejos, $datosnuevos, $datosPOST){
		if($datosviejos->fecha != $datosnuevos->fecha ||
		   $datosviejos->nrofactura != $datosnuevos->nrofactura){
		   	$asiento=Asiento::model()->findByPk($datosviejos->asiento_idasiento);
		   	$asiento->fecha=$datosPOST['fecha'];
		   	$asiento->descripcion="Factura ".$this->tipoFactura($datosnuevos->tipofactura)." Compra N°: ".$datosnuevos->nrodefactura." -  ".$datosnuevos->proveedorIdproveedor;
		   	$asiento->save();
		 }
	}
	public function updateHaberAsiento($datosviejos, $datosnuevos,$datosPOST){
	if($datosviejos->formadepago != 99999){ //para movimiento caja
		$movCaja=Movimientocaja::model()->findByPk($datosviejos->movimientocaja_idmovimientocaja);
		$movCaja->descripcion="Factura ".$this->tipoFactura($datosnuevos->tipofactura)." Compra N°: ".$datosnuevos->nrodefactura." -  ".$datosnuevos->proveedorIdproveedor;
		$movCaja->fecha=$datosPOST['fecha'];
		$movCaja->haber=$datosnuevos->importeneto;
		$movCaja->cuenta_idcuenta=$datosnuevos->cuenta_idcuenta;
		$movCaja->save();
		$DeAs=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
							array(':cuenta'=>$datosviejos->cajaIdcaja->cuenta_idcuenta,
								  ':asiento'=>$datosviejos->asiento_idasiento));
		$DeAs->haber=$datosnuevos->importeneto;
		$DeAs->save();	
	} elseif($datosviejos->formadepago == 99999){ //para cuenta corriente
		
			if($datosviejos->proveedor_idproveedor == $datosnuevos->proveedor_idproveedor){//se mantiene el mismo cliente
			$ctacte=Ctacteprov::model()->findByPk($datosviejos->proveedorIdproveedor->ctacteprov_idctacteprov);
			$total=$datosnuevos->importeneto - $datosviejos->importeneto;
			$ctacte->debe=$ctacte->debe + $total;
			$ctacte->saldo=$ctacte->debe - $ctacte->haber;
			$ctacte->save();
			$Dctacte=Detallectacteprov::model()->find('compra_idcompra=:factura',
 									array(':factura'=>$datosviejos->idcompra));
 			$Dctacte->fecha=$datosPOST['fecha'];
 			$Dctacte->descripcion="Factura ".$this->tipoFactura($datosnuevos->tipofactura)." Compra N°: ".$datosnuevos->nrodefactura." -  ".$datosnuevos->proveedorIdproveedor;
 			$Dctacte->debe=$datosnuevos->importeneto;
 			$Dctacte->save();
 			$DeAs=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
							array(':cuenta'=>48,
								  ':asiento'=>$datosviejos->asiento_idasiento));
			$DeAs->haber=$datosnuevos->importeneto;
			$DeAs->save();
 		} else{ //cambia el proveedor
 			$ctacte=Ctacteprov::model()->findByPk($datosviejos->proveedorIdproveedor->ctacteprov_idctacteprov);
			$ctacte->debe=$ctacte->debe - $datosviejos->importeneto;
			$ctacte->saldo=$ctacte->debe - $ctacte->haber;
			$ctacte->save();
			$Nctacte=Ctacteprov::model()->findByPk($datosnuevos->proveedorIdproveedor->ctacteprov_idctacteprov);
			$Nctacte->debe=$Nctacte->debe + $datosnuevos->importeneto;
			$Nctacte->saldo=$Nctacte->debe - $Nctacte->haber;
			$Nctacte->save();
			$Dctacte=Detallectacteprov::model()->find('compra_idcompra=:factura ',
 									array(':factura'=>$datosviejos->idcompra)
 										  );
 			$Dctacte->ctacteprov_idctacteprov=$datosnuevos->proveedorIdproveedor->ctacteprov_idctacteprov;
 			$Dctacte->fecha=$datosPOST['fecha'];
 			$Dctacte->descripcion="Factura ".$this->tipoFactura($datosnuevos->tipofactura)." Compra N°: ".$datosnuevos->nrodefactura." -  ".$datosnuevos->proveedorIdproveedor;
 			$Dctacte->debe=$datosnuevos->importeneto;
 			$Dctacte->save();
 			$DeAs=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
							array(':cuenta'=>48,
								  ':asiento'=>$datosviejos->asiento_idasiento));
			$DeAs->haber=$datosnuevos->importeneto;
			$DeAs->save();
 			}
		}
	}	
		public function tipoFactura($valor){
			switch ($valor) {
				case '1':
					return "A";
					break;
				case '2':
					return "B";
					break;
				case '3':
					return "C";
					break;
			}
		}
		
//para el caso donde se modifica todo formadepago y tipofactura 
	public function updaTotalCompra($model){
	$DeAsVta=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
										array(':cuenta'=>$model->cuenta_idcuenta,
											  ':asiento'=>$datosviejos->asiento_idasiento));
	$totalvtaviejo=$this->totalventa($datosviejos);
	$totalvtanuevo=$this->totalventa($datosnuevos);
	if($datosviejos->cuenta_idcuenta != $datosnuevos->cuenta_idcuenta){
		$DeAsVta->cuenta_idcuenta=$datosnuevos->cuenta_idcuenta;
		if($totalvtaviejo != $totalvtanuevo){
			$DeAsVta->debe=$totalvtanuevo;
			$DeAsVta->save();
		}
		$DeAsVta->save();	
	} else {
		if($totalvtaviejo != $totalvtanuevo){
			$DeAsVta->debe=$totalvtanuevo;
			$DeAsVta->save();
		}
						}
	}
}