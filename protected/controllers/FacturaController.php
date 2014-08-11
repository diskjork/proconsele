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
		//$model->estado=1;
		$model->nropresupuesto=0;
		$model->presupuesto=0;
			
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
						$netogravado=$model->netogravado;
						$D_R=0;
						if(($model->descrecar != null) && ($model->tipodescrecar != null)){
							if($model->tipodescrecar == 0){
								$D_R=$netogravado * ($model->descrecar /100) *-1;
							}else {
								$D_R=$netogravado * ($model->descrecar /100);
							}
						}
						
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
			//----------------------Descuento-------------
						if($D_R < 0){
							$DeAsDesc=new Detalleasiento;
							$DeAsDesc->debe=$D_R * -1;
							$DeAsDesc->cuenta_idcuenta=143; //434090 Descuentos cedidos
							$DeAsDesc->asiento_idasiento=$asiento->idasiento;
							$DeAsDesc->save();
						}
		
			//------------------------------
						//detalle asiento de IVA - FACTURA A o B 
						$totaliva=0;
						$detAs2=new Detalleasiento;
						$totaliva=$model->ivatotal;
						$detAs2->haber=$model->ivatotal;
						$detAs2->cuenta_idcuenta=68; //215100 IVA - Débito Fiscal
						$detAs2->asiento_idasiento=$asiento->idasiento;
						$detAs2->save();
						$totaliibb=0;
					//detalle asiento de percepcion IIBB
						if($model->importeIIBB != null){
							$detAs3=new Detalleasiento;
							$totaliibb=$model->importeIIBB;
							$detAs3->haber=$model->importeIIBB;
							$detAs3->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
							$detAs3->asiento_idasiento=$asiento->idasiento;
							$detAs3->save();
						}
					//detalle asiento de percepcion iva
						if($model->importe_per_iva != null){
							$detAs5=new Detalleasiento;
							$totaliibb=$model->importe_per_iva;
							$detAs5->haber=$model->importe_per_iva;
							$detAs5->cuenta_idcuenta=14; // cuenta 113200 Ret. y Percep. de IVA							    
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
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
							$totalventa=$model->netogravado;
							$detAs5->haber=$totalventa;
							$detAs5->cuenta_idcuenta=$model->productoIdproducto->cuenta_idcuenta; 
							$detAs5->asiento_idasiento=$asiento->idasiento;
							$detAs5->save();
					//----------- Recargo -------
							if($D_R > 0){
							$DeAsRecar=new Detalleasiento;
							$DeAsRecar->haber=$D_R;
							$DeAsRecar->cuenta_idcuenta=161; // recargo por ventas
							$DeAsRecar->asiento_idasiento=$asiento->idasiento;
							$DeAsRecar->save();
							}
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
				$this->modificarIvamovimiento($model, $_POST['Factura']['fecha']);
				if($model->formadepago != $modeloviejo->formadepago){
					$this->updateCambioFormadepago($modeloviejo, $model, $_POST['Factura']);
					$this->cambioDescuentoRecargo($modeloviejo, $model);
					if($_POST['Factura']['vista'] == 2){
					$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
					if($_POST['Factura']['vista'] == 3){
					$this->redirect(Yii::app()->request->baseUrl.'/ivamovimiento/adminventas');
					}
					$this->redirect(array('admin','id'=>$model->idfactura));
				}else {
					$this->updateFacAsiento($modeloviejo,$model,$_POST['Factura']);
					$this->cambioDescuentoRecargo($modeloviejo, $model);
					if($_POST['Factura']['vista'] == 2){
					$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
					}
					if($_POST['Factura']['vista'] == 3){
					$this->redirect(Yii::app()->request->baseUrl.'/ivamovimiento/adminventas');
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
		$this->redirect(array('admin'));
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
				//$modelNuevo->estado=1; //pagado
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
				//$modelNuevo->estado=0;
				$modelNuevo->save();
				$Dectacte=Detallectactecliente::model()->findByPk($Dctacte);
				$Dectacte->factura_idfactura=$nuevodatos->idfactura;
				$Dectacte->save();
			}
		}
		public function cambioDescuentoRecargo($viejos,$nuevos){
			if($viejos->descrecar != $nuevos->descrecar){
				if(($viejos->descrecar == null) && ($nuevos->descrecar != null)){
					if($nuevos->tipodescrecar == 0){
						$DeAsDesc=new Detalleasiento;
						$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsDesc->cuenta_idcuenta=143; //434090 Descuentos cedidos
						$DeAsDesc->asiento_idasiento=$asiento->idasiento;
						$DeAsDesc->save();						
					} else {
						$DeAsRecar=new Detalleasiento;
						$DeAsRecar->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsRecar->cuenta_idcuenta=161; // recargo por ventas
						$DeAsRecar->asiento_idasiento=$asiento->idasiento;
						$DeAsRecar->save();
					}
				} elseif(($viejos->descrecar != null) && ($nuevos->descrecar == null)){
					if($viejos->tipodescrecar == 0){
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->delete();
					} else {
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, // recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->delete();
					}
				} elseif(($viejos->descrecar != null) && ($nuevos->descrecar != null)){
					if(($viejos->tipodescrecar == 0) && ($nuevos->tipodescrecar == 1)){
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->debe=null;
						$DeAsDesc->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsDesc->cuenta_idcuenta=161; // recargos por ventas
						$DeAsDesc->update();
					} elseif(($viejos->tipodescrecar == 1) && ($nuevos->tipodescrecar == 0)){
						$DeAsDescR=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDescR->haber=null;
						$DeAsDescR->debe=$nuevos->netogravado * ($nuevos->descrecar/100);					
						$DeAsDescR->cuenta_idcuenta=143; //434090 Descuentos cedidos
						$DeAsDescR->update();
					} elseif(($viejos->tipodescrecar == $nuevos->tipodescrecar)){
						if($viejos->tipodescrecar == 0){
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						} else {
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						}
					}
				}
			} elseif(($viejos->descrecar == $nuevos->descrecar) && ($viejos->descrecar != null)){
				if(($viejos->tipodescrecar == 0) && ($nuevos->tipodescrecar == 1)){
						$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDesc->debe=null;
						$DeAsDesc->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
						$DeAsDesc->cuenta_idcuenta=161; // recargos por ventas
						$DeAsDesc->update();
					} elseif(($viejos->tipodescrecar == 1) && ($nuevos->tipodescrecar == 0)){
						$DeAsDescR=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
						$DeAsDescR->haber=null;
						$DeAsDescR->debe=$nuevos->netogravado * ($nuevos->descrecar/100);					
						$DeAsDescR->cuenta_idcuenta=143; //434090 Descuentos cedidos
						$DeAsDescR->update();
					} elseif(($viejos->tipodescrecar == $nuevos->tipodescrecar)){
						if($viejos->tipodescrecar == 0){
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>143, //434090 Descuentos cedidos
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->debe=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						} else {
							$DeAsDesc=Detalleasiento::model()->find("cuenta_idcuenta=:cuenta AND asiento_idasiento=:asiento", 
											array(':cuenta'=>161, //recargos por ventas
												  ':asiento'=>$viejos->asiento_idasiento));
							$DeAsDesc->haber=$nuevos->netogravado * ($nuevos->descrecar/100);
							$DeAsDesc->update();
						}
					}
				
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
									  ':cuenta' =>68)); //215100 IVA - Débito Fiscal
						$DeAsIVA->haber=$datosnuevos->ivatotal;
						$DeAsIVA->save();
					} elseif(($datosviejos->ivatotal == null) && ($datosnuevos->ivatotal != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=68; //215100 IVA - Débito Fiscal
						$NuevoDeAs->haber=$datosnuevos->ivatotal;
						$NuevoDeAs->save();
					} elseif(($datosviejos->ivatotal != null) && ($datosnuevos->ivatotal == null)){
						$DeGuardado=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>68));
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
				// IMPORTE PERC IVA
				if($datosviejos->importe_per_iva != $datosnuevos->importe_per_iva){
					if(($datosviejos->importe_per_iva != null) && ($datosnuevos->importe_per_iva != null)){
						$DeAsIVA=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>14));
						$DeAsIVA->haber=$datosnuevos->importe_per_iva;
						$DeAsIVA->save();
					} elseif(($datosviejos->importe_per_iva == null) && ($datosnuevos->importe_per_iva != null)) {
						$NuevoDeAs=new Detalleasiento;
						$NuevoDeAs->asiento_idasiento=$datosnuevos->asiento_idasiento;
						$NuevoDeAs->cuenta_idcuenta=14; //percepcion IVA
						$NuevoDeAs->haber=$datosnuevos->importe_per_iva;
						$NuevoDeAs->save();
					} elseif(($datosviejos->importe_per_iva != null) && ($datosnuevos->importe_per_iva == null)){
						$DeGuardado=Detalleasiento::model()->find("asiento_idasiento=:asiento AND cuenta_idcuenta=:cuenta",
								array(':asiento'=>$datosviejos->asiento_idasiento,
									  ':cuenta' =>14));
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
						$NuevoDeAs->cuenta_idcuenta=101; //cuenta IMPUESTO INTERNO
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
			/*$totalvtaviejo=$this->totalventa($datosviejos);
			$totalvtanuevo=$this->totalventa($datosnuevos);*/
			if($datosviejos->producto_idproducto != $datosnuevos->producto_idproducto){
				$DeAsVta->cuenta_idcuenta=$datosnuevos->productoIdproducto->cuenta_idcuenta;
				if($datosviejos->netogravado != $datosnuevos->netogravado){
					$DeAsVta->haber=$datosnuevos->netogravado;
				}
				$DeAsVta->save();	
			} else {
				if($datosviejos->netogravado != $datosnuevos->netogravado){
					$DeAsVta->haber=$datosnuevos->netogravado;
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
			$nuevo->importe_per_iva=$model->importe_per_iva;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->factura_idfactura=$model->idfactura;
			$nuevo->save();
			
		} 
	public function modificarIvamovimiento($model,$fecha){
		$nuevo=Ivamovimiento::model()->find("factura_idfactura=:id",
				array(':id'=>$model->idfactura));
			$nuevo->fecha=$fecha;
			$nuevo->nrocomprobante=$model->nrodefactura;
			$nuevo->cliente_idcliente=$model->cliente_idcliente;
			$nuevo->cuitentidad=$model->clienteIdcliente->cuit;
			$nuevo->tipofactura=$model->tipofactura;
			$nuevo->tipoiva=$model->iva;
			$nuevo->importeiibb=$model->importeIIBB;
			$nuevo->importe_per_iva=$model->importe_per_iva;
			$nuevo->importeiva=$model->ivatotal;
			$nuevo->importeneto=$model->importeneto;
			$nuevo->save();
			
	}		

		public function borradoIvaMov($model){
			$ivamov=Ivamovimiento::model()->find("factura_idfactura=:factura",array(':factura'=>$model->idfactura));
			return $ivamov->delete();
		}
		
	public function actionBorrar($id){
		
		$model=Factura::model()->findByPk($id);
		if($this->borrado($model) && $this->borradoIvaMov($model)){
			if($model->delete()){
				echo "true";
				}
			}
	}
	
	public function labelEstado($data, $row){	
		switch ($data->estado){
				case '0':
					$text="-";
					return $text;
					break;
				case '1':
					$text="N.C.-Anulación";
					return $text;
					break;
				case '2':
					$text="N.C.-Devolución";
					return $text;
					break;
				case '3':
					$text="Anulada";
					return $text;
					break;
			
		}
	}
	public function actionImprimirFactura($id) {
            
            $this->layout='//layouts/imprimir'; // defines el archivo protected/views/layouts/imprimir.php como layout por defecto sólo para esta acción.
            
            $factura = Factura::model()->findByPk($id); // agregas el código a ejecutar que cargará los datos que enviarás a la vista y que generarán tu factura
           
            //CON HTML2PDF
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            
            $html2pdf=Yii::app()->ePdf->mpdf('utf-8', 'Letter-L');
			$html2pdf->ignore_invalid_utf8 = true;
            $html2pdf = new HTML2PDF('P', 'A4', 'es');
	        $html2pdf->WriteHTML($this->render('imprimirFactura', array('factura'=>$factura), true));
	        $html2pdf->Output();
 
            //$this->renderPartial('imprimirFactura',array('factura'=>$factura),false,true);
                        
        }
   
        
	public function actionImprimirRemito($id) {
            
            $this->layout='//layouts/imprimirRemito'; // defines el archivo protected/views/layouts/imprimir.php como layout por defecto sólo para esta acción.
            
            $factura = Factura::model()->findByPk($id); // agregas el código a ejecutar que cargará los datos que enviarás a la vista y que generarán tu factura
                        
            //CON HTML2PDF
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            
            $html2pdf=Yii::app()->ePdf->mpdf('utf-8', 'Letter-L');
			$html2pdf->ignore_invalid_utf8 = true;
            $html2pdf = new HTML2PDF('P', 'A4', 'es');
	        $html2pdf->WriteHTML($this->render('imprimirRemito', array('factura'=>$factura), true));
	        $html2pdf->Output();
 
            //$this->renderPartial('imprimirFactura',array('factura'=>$factura,'detallefactura'=>$detallefactura),false,true);
                        
        }
    public function actionAnular($id){
    	$factura=Factura::model()->findByPk($id);
    	$factura->estado=3; // estado "factura anulada"
    	if($factura->save()){
    		$asiento=Asiento::model()->findByPk($factura->asiento_idasiento);
    		if($asiento->delete()){
    			if($this->borrado($factura)){
		    		$ivamov=Ivamovimiento::model()->find("factura_idfactura=:id",
		    				array(':id'=>$factura->idfactura));
		    		if($ivamov->importeiibb != null){
		    			$ivamov->importeiibb=null;
		    		}
		    		if($ivamov->importe_per_iva != null){
		    			$ivamov->importe_per_iva=null;
		    		}
		    		if($ivamov->importeiva != null){
		    			$ivamov->importeiva=0;
		    		}
		    		if($ivamov->importeneto != null){
		    			$ivamov->importeneto=0;
		    		}
		    		if($factura->tipofactura == 1){
		    			$ivamov->tipofactura=7; //factura A anulada
		    		}
		    		if($factura->tipofactura == 2){
		    			$ivamov->tipofactura=8; //factura B anulada
		    		}
		    		if($ivamov->save()){
		    			echo "true";  				   				
		    		}
    			}
    		}
    	}
    }
    	
   public function actionUndoAnular($id){
   		$model=Factura::model()->findByPk($id);
   		$asiento=new Asiento;
		$asiento->fecha=$model->fecha;
		
		$post['fecha']=$model->fecha;
		$asiento->descripcion="Factura N°: ".$model->nrodefactura;
			if($asiento->save()){
				$model->asiento_idasiento=$asiento->idasiento;
				//detalleasiento para el debito de contado
				$netogravado=$model->netogravado;
				$D_R=0;
				if(($model->descrecar != null) && ($model->tipodescrecar != null)){
					if($model->tipodescrecar == 0){
						$D_R=$netogravado * ($model->descrecar /100) *-1;
					}else {
						$D_R=$netogravado * ($model->descrecar /100);
					}
				}
				
				$detAs=new Detalleasiento;
				$detAs->debe=$model->importeneto;
				//tipo de 
				if($model->formadepago != 99999){//es pago con alguna caja?
						$detAs->cuenta_idcuenta=$model->cajaIdcaja->cuenta_idcuenta;
						$movCaja= $this->movCaja($model,$post);
						
					} elseif($model->formadepago == 99999){//es en cta corriente
						$detalleCCcliente=$this->ctacte($model,$post);
						$detAs->cuenta_idcuenta=11;  //112100 deudores por venta
						
				}
				$detAs->asiento_idasiento=$asiento->idasiento;
				$detAs->save();
			//----------------------Descuento-------------
				if($D_R < 0){
					$DeAsDesc=new Detalleasiento;
					$DeAsDesc->debe=$D_R * -1;
					$DeAsDesc->cuenta_idcuenta=143; //434090 Descuentos cedidos
					$DeAsDesc->asiento_idasiento=$asiento->idasiento;
					$DeAsDesc->save();
				}
			
			//------------------------------
				//detalle asiento de IVA - FACTURA A o B 
				$totaliva=0;
				$detAs2=new Detalleasiento;
				$totaliva=$model->ivatotal;
				$detAs2->haber=$model->ivatotal;
				$detAs2->cuenta_idcuenta=68; //215100 IVA - Débito Fiscal
				$detAs2->asiento_idasiento=$asiento->idasiento;
				$detAs2->save();
				$totaliibb=0;
			//detalle asiento de percepcion IIBB
				if($model->importeIIBB != null){
					$detAs3=new Detalleasiento;
					$totaliibb=$model->importeIIBB;
					$detAs3->haber=$model->importeIIBB;
					$detAs3->cuenta_idcuenta=20; // cuenta 113700 Ret. Imp. Ingresos Brutos    
					$detAs3->asiento_idasiento=$asiento->idasiento;
					$detAs3->save();
				}
			//detalle asiento de percepcion iva
				if($model->importe_per_iva != null){
					$detAs5=new Detalleasiento;
					$totaliibb=$model->importe_per_iva;
					$detAs5->haber=$model->importe_per_iva;
					$detAs5->cuenta_idcuenta=14; // cuenta 113200 Ret. y Percep. de IVA							    
					$detAs5->asiento_idasiento=$asiento->idasiento;
					$detAs5->save();
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
					$totalventa=$model->netogravado;
					$detAs5->haber=$totalventa;
					$detAs5->cuenta_idcuenta=$model->productoIdproducto->cuenta_idcuenta; 
					$detAs5->asiento_idasiento=$asiento->idasiento;
					$detAs5->save();
			//----------- Recargo -------
					if($D_R > 0){
					$DeAsRecar=new Detalleasiento;
					$DeAsRecar->haber=$D_R;
					$DeAsRecar->cuenta_idcuenta=161; // recargo por ventas
					$DeAsRecar->asiento_idasiento=$asiento->idasiento;
					$DeAsRecar->save();
					}
				//------------------------------
					
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
					$ivamov=Ivamovimiento::model()->find("factura_idfactura=:id",
									array(':id'=>$model->idfactura));
					if($model->importeIIBB != null){
						$ivamov->importeiibb=$model->importeIIBB;
					}
					if($model->importe_per_iva != null){
						$ivamov->importe_per_iva=$model->importe_per_iva;
					}
					$ivamov->importeneto=$model->importeneto;
					$ivamov->importeiva=$model->ivatotal;
					$model->estado=0; //estado normal
					if($ivamov->tipofactura == 7){
		    			$ivamov->tipofactura=1; //factura A
		    		}
		    		if($ivamov->tipofactura == 8){
		    			$ivamov->tipofactura=2; //factura B 
		    		}
					if($model->save()){
						if($ivamov->save()){
							echo "true";
						}
					}
			}
   }
	public function actionExcel(){
                $mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $model=new Factura('search');
             	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->Search($model->fecha=$mes_tab."/".$anio_tab),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Factura ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Factura ' . date('m-d-Y H-i'),
				    'keywords'             => '',
				    'category'             => '',
				    'landscapeDisplay'     => true, // Default: false
				    'A4'                   => true, // Default: false - ie : Letter (PHPExcel default)
				    'pageFooterText'       => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
				    'automaticSum'         => true, // Default: false
				    'decimalSeparator'     => ',', // Default: '.'
				    'thousandsSeparator'   => '.', // Default: ','
				    //'displayZeros'       => false,
				    'zeroPlaceholder'      => '-',
				    'sumLabel'             => 'TOTALES:', // Default: 'Totals'
				    'borderColor'          => '000000', // Default: '000000'
				    'bgColor'              => 'E0E0E0', // Default: 'FFFFFF'
				    'textColor'            => '000000', // Default: '000000'
				    'rowHeight'            => 15, // Default: 15
				    'headerBorderColor'    => '000000', // Default: '000000'
				    'headerBgColor'        => 'FF7F50', // Default: 'CCCCCC'
				    'headerTextColor'      => '000000', // Default: '000000'
				    'headerHeight'         => 25, // Default: 20
				    'footerBorderColor'    => '000000', // Default: '000000'
				    'footerBgColor'        => 'CCCCCC', // Default: 'FFFFCC'
				    'footerTextColor'      => '000000', // Default: '0000FF'
				    'footerHeight'         => 25, // Default: 20
				    'exportType'		   => 'Excel2007',
                	'enablePagination'		=> true,
				    'columns'              => array( // an array of your CGridColumns

   						array(
							'header'=>'NRO. FACTURA',
							'value'=>'(string)$data->nrodefactura',
						),
						array(
							'header'=>'FECHA',
							'name'=>'fecha',
						),
						array(
							'header'=>'IMPORTE',
							'name'=>'importeneto',
							'value'=>'number_format($data->importeneto,2,",",".")',
						),
						array(
							'header'=>'CLIENTE',
							'name'=>'cliente_idcliente',
							'value'=>'GxHtml::valueEx($data->clienteIdcliente)',
						),
						array(
							'header'=>'ESTADO',
							'value'=>array($this,'labelEstado'),
						),
						array(
							'header'=>'FORMA DE PAGO',
							'value'=>'($data->formadepago==99999)? "Cta Cte":"Efectivo"',
						),
					) 
				)); 
               
        	
	}
}