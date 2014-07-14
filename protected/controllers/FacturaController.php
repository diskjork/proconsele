<?php

class FacturaController extends Controller
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
				'actions'=>array('create','update','envio','ctacte'),
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
		$model=new Factura;
		$modelformprod=new Producto('search');
		$model->estado=1;
		$model->nropresupuesto=0;
		$model->presupuesto=0;
		
		// PARA EL NRO DE FACTURA
		$ulFactua=$model->ultimaFactura();
		//echo $ulFactua;die();
		if($ulFactua == null){
			$model->nrodefactura=1;
		} else{
			$model->nrodefactura=$ulFactua + 1;
		}  
			
			
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Factura'])) {
			$model->attributes=$_POST['Factura'];
			
		if ($model->validate()) {
			
					$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="Factura N°: ".$model->nrodefactura;
					if($asiento->save()){
						$model->asiento_idasiento=$asiento->idasiento;
						//detalleasiento para el debito de contado
						$detAs=new Detalleasiento;
						$detAs->debe=$model->importeneto;
						//tipo de 
						if($model->formadepago != 99999){//es pago con alguna caja?
								$detAs->cuenta_idcuenta=$model->cajaIdcaja->cuenta_idcuenta;
								$movCaja= $this->movCaja($model,$_POST['Factura']);
							} elseif($model->formadepago == 99999){//es en cta corriente
								$detalleCCcliente=$this->ctacte($model,$_POST['Factura']);
								$detAs->cuenta_idcuenta=11;  //112100 deudores por venta
						}
						$detAs->asiento_idasiento=$asiento->idasiento;
						$detAs->save();
						//------------------------------
						//detalle asiento de IVA - FACTURA A o B 
						$totaliva=0;
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->haber=$model->ivatotal;
						$detAs2->cuenta_idcuenta=14;// cuenta 113200-cuenta Ret. y Percep. de IVA
						$detAs2->asiento_idasiento=$asiento->idasiento;
						$detAs2->save();
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
						//detalle asiento de impuesto interno
						$totalimpint=0;
						if($model->importeImpInt != null){
							$detAs4=new Detalleasiento;
							$totalimpint=$model->importeImpInt;
							$detAs4->haber=$model->importeImpInt;
							$detAs4->cuenta_idcuenta=101; //cuenta 431190 Impuestos internos						      Impuestos Internos            						
							$detAs4->asiento_idasiento=$asiento->idasiento;
							$detAs4->save();
						}
						// registro de venta
							$detAs5=new Detalleasiento;
							$totalventa=$model->importeneto - $totaliva - $totaliibb - $totalimpint;
							$detAs5->haber=$totalventa;
							$detAs5->cuenta_idcuenta=$model->productoIdproducto->cuenta_idcuenta; 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
						//------------------------------
							$model->save();
							if(isset($movCaja)){
								$modelmovcaja=Movimientocaja::model()->findByPk($movCaja);
								$modelmovcaja->idfactura=$model->idfactura;
								$modelmovcaja->save();
								$modelF=Factura::model()->findByPk($model->idfactura);
								$modelF->movimientocaja_idmovimientocaja=$movCaja;
								$modelF->save();
							}
							if(isset($detalleCCcliente)){
								$detalleCC=Detallectactecliente::model()->findByPk($detalleCCcliente);
								$detalleCC->factura_idfactura=$model->idfactura;
								$detalleCC->save();
							}
							$asientoFact=Asiento::model()->findByPk($asiento->idasiento);
							$asientoFact->factura_idfactura=$model->idfactura;
							$asientoFact->save();
							$this->ivamovimiento($model, $_POST['Factura']);
					}
						
				$this->redirect(array('admin','id'=>$model->idfactura));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modelformprod'=>$modelformprod,
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
		$modelformprod=new Producto('search');
		$modeloviejo=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Factura'])) {
			
			$model->attributes=$_POST['Factura'];
			//echo $model->formadepago."  viejo".$modeloviejo->formadepago;die();
			if ($model->save()) {
				
				if($model->formadepago != $modeloviejo->formadepago){
					$this->updateCambioFormadepago($modeloviejo, $model, $_POST['Factura']);
					
					if($_POST['Factura']['vista'] == 2){
					$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
					$this->redirect(array('admin','id'=>$model->idfactura));
				}else {
					$this->updateFacAsiento($modeloviejo,$model,$_POST['Factura']);
					
					if($_POST['Factura']['vista'] == 2){
					$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
					$this->redirect(array('admin','id'=>$model->idfactura));
				}
				
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'modelformprod'=>$modelformprod,
			
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
		$dataProvider=new CActiveDataProvider('Factura');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Factura('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Factura'])) {
			$model->attributes=$_GET['Factura'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Factura the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Factura::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Factura $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='factura-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionEnvio(){
		$dato=$_POST['data'];
		$model=Producto::model()->findByPk($dato,'estado = 1');
		$val=array(
			'idp'=>$model->idproducto,
			'nombre'=>$model->nombre,
			'precio'=>$model->precio,
			//'stock'=>$model->stock,
			'venta'=>$model->unidad
			);	
			echo json_encode($val);
		}
	public function movCaja($model,$datosPOST){
		$mov=new Movimientocaja;
		$mov->descripcion="Factura N°: ".$model->nrodefactura;
		$mov->fecha=$datosPOST['fecha'];
		$mov->debeohaber=0;
		$mov->debe=$model->importeneto;
		$mov->caja_idcaja=$model->formadepago;
		//$mov->asiento_idasiento=$modelasiento->idasiento;
		$mov->cuenta_idcuenta=$model->productoIdproducto->cuenta_idcuenta; //para la cuenta relacionada a la venta del producto vendido.
		//el id_de_trabajo lo guardo luego de hacer el save() del modelo de factura para relacionarlos.
		$mov->save();
		return $mov->idmovimientocaja;
	}
	public function ctacte($model, $datosPOST){
		$ctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
	 	$ctacte->debe=$ctacte->debe + $model->importeneto;
	 	$ctacte->saldo=$ctacte->debe - $ctacte->haber;
	 	if($ctacte->save()){
	 		$modelDeCCcliente= new Detallectactecliente;
	 		$modelDeCCcliente->fecha=$datosPOST['fecha'];
           	$modelDeCCcliente->descripcion="Factura Venta N°: ".(string)$model->nrodefactura;
           	$modelDeCCcliente->tipo= 0;
           	//$modelDeCCcliente->factura_idfactura=$model->idfactura;
           	$modelDeCCcliente->debe=$model->importeneto;
           	$modelDeCCcliente->ctactecliente_idctactecliente=$ctacte->idctactecliente;
           	$modelDeCCcliente->save();
	 		return $modelDeCCcliente->iddetallectactecliente;
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
											array(':cuenta'=>11,
												  ':asiento'=>$model->asiento_idasiento));
				}else {
				$DTasientoCC=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>$model->cajaIdcaja->cuenta_idcuenta,
												  ':asiento'=>$model->asiento_idasiento));	
				}
				
																
				$DTasientoCC->cuenta_idcuenta=$nuevodatos->cajaIdcaja->cuenta_idcuenta;
				$DTasientoCC->debe=$nuevodatos->importeneto;
				$DTasientoCC->save();
				$this->updateImpuestos($model, $nuevodatos);	
				$this->updateTotalAsVta($model, $nuevodatos);
				
				//nuevo movimiento caja
				$movCajaNuevo=$this->movCaja($nuevodatos,$datosPOST);
				if(isset($movCajaNuevo)){
					$modelmovcaja=Movimientocaja::model()->findByPk($movCajaNuevo);
								$modelmovcaja->idfactura=$model->idfactura;
								$modelmovcaja->save();
				}
				
				$modelNuevo=Factura::model()->findByPk($model->idfactura);
				$modelNuevo->movimientocaja_idmovimientocaja=$modelmovcaja->idmovimientocaja;
				$modelNuevo->save();
				//para decrementar y borrar el detalle de ctactecliente
				$Nctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
	 			$Nctacte->debe=$Nctacte->debe - $model->importeneto;
	 			$Nctacte->saldo=$Nctacte->debe - $Nctacte->haber;
	 			$Nctacte->save();
	 			$Dctacte=Detallectactecliente::model()->find('factura_idfactura=:factura',
	 											array(':factura'=>$model->idfactura));
	 			$Dctacte->delete();
				
			} elseif($nuevodatos->formadepago == 99999){ // el nuevo es en ctacte
				//para el detalle de asiento
				$DTasiento=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>$model->cajaIdcaja->cuenta_idcuenta,
												  ':asiento'=>$model->asiento_idasiento));
				
				$DTasiento->cuenta_idcuenta=11;
				$DTasiento->debe=$nuevodatos->importeneto;
				$DTasiento->save();
				$this->updateImpuestos($model, $nuevodatos);
				$this->updateTotalAsVta($model, $nuevodatos);	
				//borra el movimiento de caja anterior
				$movCaja=Movimientocaja::model()->findByPk($model->movimientocaja_idmovimientocaja);
				$movCaja->delete();
				//modifiar los datos de ctactecliente
				$Dctacte=$this->ctacte($nuevodatos, $datosPOST);
				$modelNuevo=Factura::model()->findByPk($model->idfactura);
				$modelNuevo->movimientocaja_idmovimientocaja=  NULL;
				$modelNuevo->save();
				$Dectacte=Detallectactecliente::model()->findByPk($Dctacte);
				$Dectacte->factura_idfactura=$nuevodatos->idfactura;
				$Dectacte->save();
			}
		}
		
		public function updateFacAsiento($datosviejos,$datosnuevos,$datosPOST){
			if($datosviejos->fecha != $datosnuevos->fecha ||
				$datosviejos->nrodefactura != $datosnuevos->nrodefactura ||
				$datosviejos->cliente_idcliente != $datosnuevos->cliente_idcliente ||
				$datosviejos->tipofactura != $datosnuevos->tipofactura ||
				$datosviejos->importeneto != $datosnuevos->importeneto  ||
				$datosviejos->producto_idproducto != $datosnuevos->producto_idproducto)
				{
				$asiento=Asiento::model()->findByPk($datosviejos->asiento_idasiento);
				$asiento->fecha=$datosPOST['fecha'];
				$asiento->descripcion="Factura N°: ".$datosnuevos->nrodefactura;
				$asiento->save();
				//detalle asiento cambios totales de impuestos
				$this->updateImpuestos($datosviejos, $datosnuevos);	
				$this->updateTotalAsVta($datosviejos, $datosnuevos);
				if($datosviejos->formadepago == $datosnuevos->formadepago){ //la forma de pago se mantiene
					
					if($datosviejos->formadepago != 99999){ //para movimiento caja
						$movCaja=Movimientocaja::model()->findByPk($datosviejos->movimientocaja_idmovimientocaja);
						$movCaja->descripcion="Factura N°: ".$datosnuevos->nrodefactura;
						$movCaja->fecha=$datosPOST['fecha'];
						$movCaja->debe=$datosnuevos->importeneto;
						$movCaja->cuenta_idcuenta=$datosnuevos->productoIdproducto->cuenta_idcuenta;
						$movCaja->save();
						$DeAs=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>$datosviejos->cajaIdcaja->cuenta_idcuenta,
												  ':asiento'=>$datosviejos->asiento_idasiento));
						$DeAs->debe=$datosnuevos->importeneto;
						$DeAs->save();	
					} elseif($datosviejos->formadepago == 99999){ //para cuenta corriente
						
							if($datosviejos->cliente_idcliente == $datosnuevos->cliente_idcliente){//se mantiene el mismo cliente
							$ctacte=Ctactecliente::model()->findByPk($datosviejos->clienteIdcliente->ctactecliente_idctactecliente);
							$total=$datosnuevos->importeneto - $datosviejos->importeneto;
							$ctacte->debe=$ctacte->debe + $total;
							$ctacte->saldo=$ctacte->debe - $ctacte->haber;
							$ctacte->save();
							$Dctacte=Detallectactecliente::model()->find('factura_idfactura=:factura',
		 											array(':factura'=>$datosviejos->idfactura));
		 					$Dctacte->fecha=$datosPOST['fecha'];
		 					$Dctacte->descripcion="Factura N°: ".$datosnuevos->nrodefactura;
		 					$Dctacte->debe=$datosnuevos->importeneto;
		 					$Dctacte->save();
		 					$DeAs=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>11,
												  ':asiento'=>$datosviejos->asiento_idasiento));
							$DeAs->debe=$datosnuevos->importeneto;
							$DeAs->save();
	 					} else{ //cambia el cliente
	 						$ctacte=Ctactecliente::model()->findByPk($datosviejos->clienteIdcliente->ctactecliente_idctactecliente);
							$ctacte->debe=$ctacte->debe - $datosviejos->importeneto;
							$ctacte->saldo=$ctacte->debe - $ctacte->haber;
							$ctacte->save();
							$Nctacte=Ctactecliente::model()->findByPk($datosnuevos->clienteIdcliente->ctactecliente_idctactecliente);
							$Nctacte->debe=$Nctacte->debe + $datosnuevos->importeneto;
							$Nctacte->saldo=$Nctacte->debe - $Nctacte->haber;
							$Nctacte->save();
							$Dctacte=Detallectactecliente::model()->find('factura_idfactura=:factura ',
		 											array(':factura'=>$datosviejos->idfactura)
		 												  );
		 					$Dctacte->ctactecliente_idctactecliente=$datosnuevos->clienteIdcliente->ctactecliente_idctactecliente;
		 					$Dctacte->fecha=$datosPOST['fecha'];
		 					$Dctacte->descripcion="Factura N°: ".$datosnuevos->nrodefactura;
		 					$Dctacte->debe=$datosnuevos->importeneto;
		 					$Dctacte->save();
		 					$DeAs=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>11,
												  ':asiento'=>$datosviejos->asiento_idasiento));
							$DeAs->debe=$datosnuevos->importeneto;
							$DeAs->save();
	 					}
					}
				  }
				}
	
		}
	public function updateImpuestos($datosviejos,$datosnuevos){
			// IVATOTAL
				if($datosviejos->ivatotal != $datosnuevos->ivatotal){
					if(($datosviejos->ivatotal != null) && ($datosnuevos->ivatotal != null)){
						$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>14));
						$DeAsIVA->haber=$datosnuevos->ivatotal;
						$DeAsIVA->save();
					} elseif(($datosviejos->ivatotal == null) && ($datosnuevos->ivatotal != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=14; //cuenta retenciones IVA
						$NuevoDeAs->haber=$datosnuevos->ivatotal;
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
						$DeAsIVA->haber=$datosnuevos->importeIIBB;
						$DeAsIVA->save();
					} elseif(($datosviejos->importeIIBB == null) && ($datosnuevos->importeIIBB != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=20; //cuenta retenciones IIBB
						$NuevoDeAs->haber=$datosnuevos->importeIIBB;
						$NuevoDeAs->save();
					} elseif(($datosviejos->importeIIBB != null) && ($datosnuevos->importeIIBB == null)){
						$DeGuardado=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>20));
						$DeGuardado->delete();	
					}
					
				}
				// IMPUESTO INTERNO
				if($datosviejos->importeImpInt != $datosnuevos->importeImpInt){
					if(($datosviejos->importeImpInt != null) && ($datosnuevos->importeImpInt != null)){
						$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>101));
						$DeAsIVA->haber=$datosnuevos->importeImpInt;
						$DeAsIVA->save();
					} elseif(($datosviejos->importeImpInt == null) && ($datosnuevos->importeImpInt != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=101; //cuenta retenciones IMPUESTO INTERNO
						$NuevoDeAs->haber=$datosnuevos->importeImpInt;
						$NuevoDeAs->save();
					} elseif(($datosviejos->importeImpInt != null) && ($datosnuevos->importeImpInt == null)){
						$DeGuardado=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>101));
						$DeGuardado->delete();	
					}
					
				}
		}
		public function updateTotalAsVta($datosviejos,$datosnuevos){ //$model corresponde a los nuevos datos
			$DeAsVta=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>$datosviejos->productoIdproducto->cuenta_idcuenta,
												  ':asiento'=>$datosviejos->asiento_idasiento));
			$totalvtaviejo=$this->totalventa($datosviejos);
			$totalvtanuevo=$this->totalventa($datosnuevos);
			if($datosviejos->producto_idproducto != $datosnuevos->producto_idproducto){
				$DeAsVta->cuenta_idcuenta=$datosnuevos->productoIdproducto->cuenta_idcuenta;
				if($totalvtaviejo != $totalvtanuevo){
					$DeAsVta->haber=$totalvtanuevo;
				}
				$DeAsVta->save();	
			} else {
				if($totalvtaviejo != $totalvtanuevo){
					$DeAsVta->haber=$totalvtanuevo;
					$DeAsVta->save();
				}
			}
			
		
		}
		
		public function totalventa($model){
			
			$model->ivatotal == null ? $iva=0 : $iva=$model->ivatotal;	
			$model->importeIIBB == null ? $iibb=0 : $iibb=$model->importeIIBB;
			$model->importeImpInt == null ? $impint=0 : $impint=$model->importeImpInt;
			$totalventa=$model->importeneto - $iva - $iibb -$impint;
			return $totalventa;
		}
		public function borrado($model){
			if($model->formadepago != 99999){ //movimientocaja
				$movCaja=Movimientocaja::model()->find("idfactura=:id",array(':id'=>$model->idfactura));
				return $movCaja->delete();
				
			} else {//ctacte 
				$ctacte=Ctactecliente::model()->findByPk($model->clienteIdcliente->ctactecliente_idctactecliente);
				$ctacte->debe=$ctacte->debe - $model->importeneto;
				$ctacte->saldo=$ctacte->debe - $ctacte->haber;
				$ctacte->save();
				$Dctacte=Detallectactecliente::model()->find("factura_idfactura=:factura AND ctactecliente_idctactecliente=:ctacte",
								array(':factura'=>$model->idfactura,
									  ':ctacte'=>$ctacte->idctactecliente));
				return $Dctacte->delete();
			}
			
		}
		public function ivamovimiento($model,$datoPOST){
			$nuevo=new Ivamovimiento;
			$nuevo->fecha=$datoPOST['fecha'];
			$nuevo->tipomoviento=0; //venta
			$nuevo->nrocomprobante=$model->nrodefactura;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			$nuevo->tipofactura=$model->tipofactura;
			$nuevo->tipoiva=$model->iva;
			$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->factura_idfactura=$model->idfactura;
			$nuevo->save();
			
		} 
		public function borradoIvaMov($model){
			$ivamov=Ivamovimiento::model()->find("factura_idfactura=:factura",array(':factura'=>$model->idfactura));
			return $ivamov->delete();
		}
}