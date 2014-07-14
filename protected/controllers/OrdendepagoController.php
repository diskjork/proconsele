<?php

class OrdendepagoController extends Controller
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
		Yii::import('ext.multimodelform.MultiModelForm');
		
		$model = new Ordendepago;
		$modelchequecargado= new Cheque('search');
		$member = new Detalleordendepago;
    	$validatedMembers = array();  //ensur
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset($_POST['Ordendepago'])) {
			$model->attributes=$_POST['Ordendepago'];
			//$nuevos=$this->nuevosElementosValidados($_POST['Ordendepago']);
 			
			
			
			
			if( //validate detail before saving the master
            MultiModelForm::validate($member,$validatedMembers,$deleteItems) &&
            $model->save())
           {
          	 /*if(isset($_POST['Detalleordendepago']['tipoordendepago'])){
				$cantidadElementos=count($_POST['Detalleordendepago']['tipoordendepago']);
				for($i=0;$i<$cantidadElementos;$i++){
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 3){
							$idcheque=$_POST['Detalleordendepago']['idcheque'][$i];
							$member[$i]->validate('idcheque');
						}
				}
          	 }*/
             //the value for the foreign key 'groupid'
             $masterValues = array ('ordendepago_idordendepago'=>$model->idordendepago);
            
            
             if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
             {
             	
             $prov=Proveedor::model()->find("ctacteprov_idctacteprov=:idctacte",
             					array(":idctacte"=>$_POST['Ordendepago']['ctacteprov_idctacteprov']));
             	
             	
             	//ASIENTO PARA LA ORDEN DE PAGO
             	$asiento=new Asiento;
             	$asiento->fecha=$_POST['Ordendepago']['fecha'];
             	$asiento->descripcion="Orden de pago N°".$masterValues['ordendepago_idordendepago']." ".$prov->nombre;
             	$asiento->ordendepago_idordendepago=$masterValues['ordendepago_idordendepago'];
             	if($asiento->save()){
             		$nroasiento=$asiento->idasiento;
             		//Detalle asiento para la contra parte del asiento "DEBE"
             		$DeAsCTACTE=new Detalleasiento;
             		$DeAsCTACTE->debe=$_POST['Ordendepago']['importe'];
             		$DeAsCTACTE->cuenta_idcuenta=48; //211100 Proveedores compras varias
             		$DeAsCTACTE->asiento_idasiento=$nroasiento;
             		$DeAsCTACTE->proveedor_idproveedor=$prov->idproveedor;
             		
             		if($DeAsCTACTE->save()){
             			$post=$_POST;
             			$this->nuevoElem($validatedMembers, $_POST['Ordendepago']['fecha'], $nroasiento,$masterValues,$prov);
		             	
             		}
             	}
             	
//para  sumar en el haber de cta cte del PROVEEDOR----------
			$idctacteprov=$model->ctacteprov_idctacteprov;
			$importeDetalle=$_POST['Ordendepago']['importe'];
			$this->incrementoCtacte($idctacteprov, $importeDetalle);
			
//para generar el modelo de detallectacteprov que corresponde a la nueva ordendepago
			$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
			$modelDeCCprov= new Detallectacteprov;
           	$modelDeCCprov->fecha=$_POST['Ordendepago']['fecha'];
           	$modelDeCCprov->descripcion="ORDEN DE PAGO Nro:".$model->idordendepago."";
           	$modelDeCCprov->tipo= 1; //tipo ordendepago,0 para compra
           	$modelDeCCprov->ordendepago_idordendepago=$model->idordendepago;
           	$modelDeCCprov->haber=$model->importe;
           	$modelDeCCprov->ctacteprov_idctacteprov=$model->ctacteprov_idctacteprov;
           	$modelDeCCprov->save();
           	
           	Yii::app()->user->setFlash('success', "<strong>Orden de pago creada correctamente.</strong>");
			$this->redirect(array('admin'));			
           
             }
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'member'=>$member,
        	'validatedMembers' => $validatedMembers,
			'modelchequecargado'=> $modelchequecargado,
		));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
public function actionUpdate($id)
	{
		 Yii::import('ext.multimodelform.MultiModelForm');
 
		$model=$this->loadModel($id);
		$modelchequecargado= new Cheque('search');
		 $member = new Detalleordendepago;
    	 $validatedMembers = array(); //ensure an empty array
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Ordendepago'])) {
			$model->attributes=$_POST['Ordendepago'];
		
		//elementos ya guardados y que pueden ser modificados		
			if (isset($_POST['Detalleordendepago']['pk__'])){
				$cantidadElementos=count($_POST['Detalleordendepago']['pk__']); 
				for($i=0;$i<$cantidadElementos;$i++){
				
					$iddetalle_nuevo=$_POST['Detalleordendepago']['pk__'][$i]['iddetalleordendepago'];
					$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
					$DC_trabajo=Detalleordendepago::model()->findByPk($iddetalle_nuevo);
					if (isset($_POST['Detalleordendepago']['u__'][$i]['tipoordendepago'])){
											
						//datos nuevos traidos por POST
						$itemUpdate[$i]['totalordendepago']=$_POST['Detalleordendepago']['importe'];
						$itemUpdate[$i]['iddetalleordendepago']=$iddetalle_nuevo;
						$itemUpdate[$i]['tipoordendepago']=$_POST['Detalleordendepago']['u__'][$i]['tipoordendepago'];
						$itemUpdate[$i]['transbanco']=$_POST['Detalleordendepago']['u__'][$i]['transferenciabanco'];
						$itemUpdate[$i]['banco']=$_POST['Detalleordendepago']['u__'][$i]['chequebanco'];
						$itemUpdate[$i]['fecha']=$model->fecha;
						$itemUpdate[$i]['fechaingreso']=$_POST['Detalleordendepago']['u__'][$i]['chequefechaingreso'];
						$itemUpdate[$i]['fechacobro']=$_POST['Detalleordendepago']['u__'][$i]['chequefechacobro'];
						$itemUpdate[$i]['idcheque']=$_POST['Detalleordendepago']['u__'][$i]['idcheque'];
						$itemUpdate[$i]['titular']=$_POST['Detalleordendepago']['u__'][$i]['chequetitular'];
						$itemUpdate[$i]['cuittitular']=$_POST['Detalleordendepago']['u__'][$i]['chequecuittitular'];
						$itemUpdate[$i]['chequenumero']=$_POST['Detalleordendepago']['u__'][$i]['nrocheque'];
						$itemUpdate[$i]['importe']=doubleval($_POST['Detalleordendepago']['u__'][$i]['importe']);
						$itemUpdate[$i]['nombreprov']=$proveedor[0]['nombreprov'];
						$itemUpdate[$i]['idprov']=$proveedor[0]['idprov'];
						$itemUpdate[$i]['idordendepago']=$DC_trabajo->ordendepago_idordendepago;
						$itemUpdate[$i]['caja_idcaja']=$_POST['Detalleordendepago']['u__'][$i]['caja_idcaja'];
						$itemUpdate[$i]['chequera']=$_POST['Detalleordendepago']['u__'][$i]['chequera'];
						
						
						//Datos del detalle ya guardado-----------------------------------
						$datos[$i]['iddetalleordendepago']=$iddetalle_nuevo;
						$datos[$i]['idordendepago']=$DC_trabajo->ordendepago_idordendepago;
						$datos[$i]['tipoordendepago']=$DC_trabajo->tipoordendepago;
						$datos[$i]['nombreprov']=$proveedor[0]['nombreprov'];
						$datos[$i]['fecha']=$model->fecha;
						$datos[$i]['importe']=doubleval($DC_trabajo->importe);
						$datos[$i]['chequenumero']=$DC_trabajo->nrocheque;
						$datos[$i]['fechaingreso']=$DC_trabajo->chequefechaingreso;
						$datos[$i]['fechacobro']=$DC_trabajo->chequefechaingreso;
						$datos[$i]['idcheque']=$DC_trabajo->idcheque;
						$datos[$i]['titular']=$DC_trabajo->chequetitular;
						$datos[$i]['cuittitular']=$DC_trabajo->chequecuittitular;
						$datos[$i]['banco']=$DC_trabajo->chequebanco;
						$datos[$i]['idprov']=$proveedor[0]['idprov'];
						$datos[$i]['transbanco']=$DC_trabajo->transferenciabanco;
						$datos[$i]['chequera']=$DC_trabajo->chequera;
						$datos[$i]['caja_idcaja']=$DC_trabajo->caja_idcaja;
						
							
					}else {
						//elementos borrados
						$elem_borrados_DCob[$i]['iddetalleordendepago']=$iddetalle_nuevo;
						$elem_borrados_DCob[$i]['idordendepago']=$DC_trabajo->ordendepago_idordendepago;
						$elem_borrados_DCob[$i]['tipoordendepago']=$DC_trabajo->tipoordendepago;
						$elem_borrados_DCob[$i]['nombreprov']=$proveedor[0]['nombreprov'];
						$elem_borrados_DCob[$i]['importe']=doubleval($DC_trabajo->importe);
						$elem_borrados_DCob[$i]['chequenumero']=$DC_trabajo->nrocheque;
						$elem_borrados_DCob[$i]['fechaingreso']=$DC_trabajo->chequefechaingreso;
						$elem_borrados_DCob[$i]['fechacobro']=$DC_trabajo->chequefechacobro;
						$elem_borrados_DCob[$i]['idcheque']=$DC_trabajo->idcheque;
						$elem_borrados_DCob[$i]['titular']=$DC_trabajo->chequetitular;
						$elem_borrados_DCob[$i]['cuittitular']=$DC_trabajo->chequecuittitular;
						$elem_borrados_DCob[$i]['banco']=$DC_trabajo->chequebanco;
						$elem_borrados_DCob[$i]['idprov']=$proveedor[0]['idprov'];
						$elem_borrados_DCob[$i]['transbanco']=$DC_trabajo->transferenciabanco;
					}
				}
			}
			
			
				$masterValues = array ('ordendepago_idordendepago'=>$model->idordendepago);
				//para comprobar si el importe ha sido modificado
				$llave=null;
				$ordendepagoguardada=Ordendepago::model()->findByPk($model->idordendepago);//modelo ordendepago guardado
				if(($ordendepagoguardada->importe != $_POST['Ordendepago']['importe']) || ($ordendepagoguardada->fecha != $_POST['Ordendepago']['fecha'])){
					$llave=$ordendepagoguardada->importe;
				}
			if( //Save the master model after saving valid members
            MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues) &&
            $model->save()
           ){
          
           	// se verifica si se ha modificado el importe de la ordendepago
           	
           	if($llave != null){
           		$importeviejo=$llave;
           		$importenuevo=$model->importe;
           		$fecha=$model->fecha;
           		$idctacte=$model->ctacteprov_idctacteprov;
           		$this->modificarImporteCtaCte($importeviejo, $importenuevo, $idctacte);
           		$this->modImpDetalleCtacte($idctacte, $id, $importenuevo,$fecha);
           	}
           	
          //Si se ha modificado un detalle de ordendepago..
          	if(isset($itemUpdate) && isset($datos)){
          		foreach ($itemUpdate as $key_uno=>$valor_uno){
          			foreach($valor_uno as $key_dos=>$valor_dos){
          				if($key_dos == "tipoordendepago"){
          					//para cambiar importe asiento y detalle asiento 11
          					$this->cambioAsiento($valor_uno);
          					//compara si el tipo de ordendepago se ha modificado o no en un item
          					if($valor_dos != $datos[$key_uno]['tipoordendepago']){
          						$tipoguardado=$datos[$key_uno]['tipoordendepago'];
          						$this->cambioTipoBorrado($tipoguardado, $datos[$key_uno]);
          						$this->resetDetalle($datos[$key_uno]['iddetalleordendepago']);
          						$this->cambioTipoNuevoDetalle($valor_uno);
          						$this->cambioDetalleAsiento($tipoguardado, $valor_uno);
          						
          					} else { // cuando el tipo de ordendepago se mantuvo
          						       						 
          						$this->modUpdateItemsDetAsiento($datos[$key_uno], $valor_uno);
          					}
          				}
          			}
          		}
          		
          	}
          	
          	//si existe un elemento detalleordendepago borrado 
          	if(isset($elem_borrados_DCob)){
	          	foreach($elem_borrados_DCob as $keyBorr_uno=>$valorBorr_uno){
	          			foreach ($valorBorr_uno as $keyborr_dos=>$valorborr_dos){
	          				$this->cambioAsiento($valorBorr_uno);
	          				if($keyborr_dos == "tipoordendepago"){
	          					
	          					$tipoguardadoBorr=$valorborr_dos;
	          					$this->cambioTipoBorrado($tipoguardadoBorr, $valorBorr_uno);
	          				}
	          				if($keyborr_dos == "iddetalleordendepago"){
	          					$this->borradoDetAsiento($valorborr_dos);
	          				}
	          			}
	          		}
          	}
        //para el caso de elementos nuevos despues de actualizar la cobranza
	           	$asiento=Asiento::model()->find("ordendepago_idordendepago=:id",
								array(':id'=>$id));
				$prov=Proveedor::model()->find("ctacteprov_idctacteprov=:idctacte",
	            	 array(":idctacte"=>$_POST['Ordendepago']['ctacteprov_idctacteprov']));
				$this->nuevoElem($validatedMembers, $_POST['Ordendepago']['fecha'], $asiento->idasiento, $masterValues, $prov);
				
          		Yii::app()->user->setFlash('success', "<strong>Orden de pago actualizada correctamente.</strong>");
				$this->redirect(array('admin'));
				//$this->redirect(array('view','id'=>$model->idordendepago));
           }
		}

		$this->render('update',array(
			'model'=>$model,
			'member'=>$member,
        	'validatedMembers'=>$validatedMembers,
			'modelchequecargado'=> $modelchequecargado,
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
			$ordendepago=$this->loadModel($id);
			
			$Detalle=Detalleordendepago::model()->findAll('ordendepago_idordendepago=:ordendepago_idordendepago', array(':ordendepago_idordendepago'=>$id));
			//print_r($Detalle);die();
			$proveedor=$this->idProveedor($ordendepago->ctacteprov_idctacteprov); 
			
			for($i=0;$i < count($Detalle);$i++){
				
				$tipo=$Detalle[$i]['tipoordendepago'];
				$datos[$i]['idordendepago']=$id;
				$datos[$i]['nombreprov']=$proveedor[0]['nombreprov'];
				$fecha = DateTime::createFromFormat('d/m/Y', $ordendepago->fecha);
							//$itemUpdate[$i]['fechacobro']=$fechacobro->format('Y-m-d');
							$datos[$i]['fecha']=$fecha->format('Y-m-d');
				$datos[$i]['importe']=$Detalle[$i]['importe'];
				$datos[$i]['chequenumero']=$Detalle[$i]['nrocheque'];
				if($Detalle[$i]['chequefechaingreso'] != null){
					$fechaingreso = DateTime::createFromFormat('d/m/Y', $Detalle[$i]['chequefechaingreso']);
					$datos[$i]['fechaingreso']=$fechaingreso->format('Y-m-d');
				}else {
					$datos[$i]['fechaingreso']=$Detalle[$i]['chequefechaingreso'];
				}
				if($Detalle[$i]['chequefechacobro'] != null){
					$fechacobro = DateTime::createFromFormat('d/m/Y', $Detalle[$i]['chequefechacobro']);
					$datos[$i]['fechacobro']=$fechacobro->format('Y-m-d');
				}else {
					$datos[$i]['fechacobro']=$Detalle[$i]['chequefechacobro'];
				}
				$datos[$i]['iddetalleordendepago']=$Detalle[$i]['iddetalleordendepago'];
				$datos[$i]['titular']=$Detalle[$i]['chequetitular'];
				$datos[$i]['idcheque']=$Detalle[$i]['idcheque'];
				$datos[$i]['cuittitular']=$Detalle[$i]['chequecuittitular'];
				$datos[$i]['banco']=$Detalle[$i]['chequebanco'];
				$datos[$i]['idprov']=$proveedor[0]['idprov'];
				$datos[$i]['transbanco']=$Detalle[$i]['transferenciabanco'];
				$this->cambioTipoBorrado($tipo, $datos[$i]); // para borrar los detalles como cheque, transf o mov caja
			}
			/*print_r($datos);
			die();*/
			$this->decrementarCtacteDelete($ordendepago->ctacteprov_idctacteprov, $ordendepago->importe);
			$this->borrarDetCtaCte($ordendepago->idordendepago, $ordendepago->importe, $ordendepago->ctacteprov_idctacteprov);
		
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		/*try{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}catch(CDbException $e){
                   echo "<div class='flash-error'>No se puede eliminar, existen Alegatos registrados para éste objetivo.</div>"; //for ajax
            } */
			
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Ordendepago');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ordendepago('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Ordendepago'])) {
			$model->attributes=$_GET['Ordendepago'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ordendepago the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ordendepago::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ordendepago $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='ordendepago-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
public function nuevoElem($validatedMembers,$fecha,$nroasiento,$masterValues,$prov){
 		// Contraparte del asiento "HABER"
             $cantElm=count($validatedMembers);
             for($a=0;$a<$cantElm;$a++){
             	 $Deta=Detalleasiento::model()->find("iddetalleordendepago=:id",array(':id'=>$validatedMembers[$a]['iddetalleordendepago']));
	             if($validatedMembers[$a]['tipoordendepago'] == 0 && (!isset($Deta))){ //efectivo
		             $MovCaja=new Movimientocaja;
		             $MovCaja->descripcion="Pago N°".$masterValues['ordendepago_idordendepago']." a ".$prov->nombre;
		             $MovCaja->fecha=$fecha;
		             $MovCaja->debeohaber=1;
		             $MovCaja->haber=$validatedMembers[$a]['importe'];
		             $MovCaja->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
		             $MovCaja->cuenta_idcuenta=48; //211100 Proveedores compras varias
		             $MovCaja->caja_idcaja=$validatedMembers[$a]['caja_idcaja'];
		             if($MovCaja->save()){
			             $DeAsCaja=new Detalleasiento;
			             $DeAsCaja->haber=$validatedMembers[$a]['importe'];
			             $cuentaCAJA=Caja::model()->findByPk($validatedMembers[$a]['caja_idcaja']);
			             $DeAsCaja->cuenta_idcuenta=$cuentaCAJA->cuenta_idcuenta;
			             $DeAsCaja->asiento_idasiento=$nroasiento;
			             $DeAsCaja->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
			             $DeAsCaja->save();
			             }
		             //print_r($MovCaja->getErrors());die();
	             } elseif($validatedMembers[$a]['tipoordendepago'] == 1 && (!isset($Deta))){ //cheque
		             //Nuevo cheque propio
		             $Cheque=new Cheque;
		             $Cheque->nrocheque=$validatedMembers[$a]['nrocheque'];
		             $Cheque->titular=$validatedMembers[$a]['chequetitular'];
		             $Cheque->cuittitular=$validatedMembers[$a]['chequecuittitular'];
		             $Cheque->fechaingreso=$this->fechadmY($validatedMembers[$a]['chequefechaingreso']);
		             $Cheque->fechacobro=$this->fechadmY($validatedMembers[$a]['chequefechacobro']);
		             $Cheque->haber=$validatedMembers[$a]['importe'];
		             $Cheque->debeohaber=1;
		             $Cheque->chequera_idchequera=$validatedMembers[$a]['chequera'];
		             $Cheque->estado=0;// estado a cobrar
		             $Cheque->proveedor_idproveedor=$prov->idproveedor;
		             $Cheque->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
		             if($Cheque->save()){
			             $DeAsCheque=new Detalleasiento;
			             $DeAsCheque->haber=$validatedMembers[$a]['importe'];
			             $cuentaChequera=Chequera::model()->findByPk($validatedMembers[$a]['chequera']);
			             $DeAsCheque->cuenta_idcuenta=$cuentaChequera->cuenta_idcuenta;
			             $DeAsCheque->asiento_idasiento=$nroasiento;
			             $DeAsCheque->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
			             $DeAsCheque->save();
	             	}
	             
	             } elseif($validatedMembers[$a]['tipoordendepago'] == 2 && (!isset($Deta))){ 
		             // Nuevo movimientobanco
		             $MovBanco=new Movimientobanco;
		             $MovBanco->descripcion="Pago N°".$masterValues['ordendepago_idordendepago']." ".$prov->nombre;
		             $MovBanco->fecha=$fecha;
		             $MovBanco->debeohaber=1;
		             $MovBanco->haber=$validatedMembers[$a]['importe'];
		             $MovBanco->ctabancaria_idctabancaria=$validatedMembers[$a]['transferenciabanco'];
		             $MovBanco->cuenta_idcuenta=48;//211100 Proveedores compras varias
		             $MovBanco->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
		             if($MovBanco->save()){
			             $cuentaCtabancaria=Ctabancaria::model()->findByPk($validatedMembers[$a]['transferenciabanco']);
			             $DeAsTrasfer=new Detalleasiento;
			             $DeAsTrasfer->haber=$validatedMembers[$a]['importe'];
			             $DeAsTrasfer->cuenta_idcuenta=$cuentaCtabancaria->cuenta_idcuenta;
			             $DeAsTrasfer->asiento_idasiento=$nroasiento;
			             $DeAsTrasfer->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
			             $DeAsTrasfer->save();
		             }
	             
	             } 
	             elseif($validatedMembers[$a]['tipoordendepago'] == 3 && (!isset($Deta))){ 
		             // Cheque endozado
		            $modelchequetercero=Cheque::model()->findByPk($validatedMembers[$a]['idcheque']);
					    
							$modelchequetercero->estado=4; //para que pase a estado endozado
							$modelchequetercero->proveedor_idproveedor=$prov->idproveedor;
							$modelchequetercero->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
							if($modelchequetercero->save()){
								 $DeAs=new Detalleasiento;
					             $DeAs->haber=$validatedMembers[$a]['importe'];
					             $DeAs->cuenta_idcuenta=5; //cuenta cheque de 3ros a cobrar
					             $DeAs->asiento_idasiento=$nroasiento;
					             $DeAs->iddetalleordendepago=$validatedMembers[$a]['iddetalleordendepago'];
					             $DeAs->save();
							}
	             }    	          
             } //for
 	}
public function fechadmY($dato){
		$fechaingreso = DateTime::createFromFormat('Y-m-d', $dato);
	return $fechaingreso->format('d/m/Y');
	}	
public function nuevoMovCaja($datos){
							
		$modelmovcaja=new Movimientocaja;
		$modelmovcaja->descripcion= "Orden de pago N°".(string)$datos['idordendepago']." - ".(string)$datos['nombreprov']."-";
		$modelmovcaja->fecha=$datos['fecha'];
		$modelmovcaja->debeohaber=1;
		$modelmovcaja->caja_idcaja=1;
		$modelmovcaja->haber=$datos['importe'];
		$modelmovcaja->caja_idcaja=$datos['caja_idcaja'];
		$modelmovcaja->iddetalleordendepago=$datos['iddetalleordendepago'];
		$modelmovcaja->save();
			}
	public function nuevoCheque($datos){
		
		
		$modelCheque= new Cheque;
		$modelCheque->nrocheque=$datos['chequenumero'];
		$modelCheque->fechaingreso=$datos['fechaingreso'];
		$modelCheque->fechacobro=$datos['fechacobro'];
		$modelCheque->titular=$datos['titular'];
		$modelCheque->cuittitular=$datos['cuittitular'];
		$modelCheque->haber=$datos['importe'];
		$modelCheque->debeohaber=1;
		$modelCheque->chequera_idchequera=$datos['chequera'];
		$modelCheque->proveedor_idproveedor=$datos['idprov'];
		$modelCheque->estado=0;
		$modelCheque->iddetalleordendepago=$datos['iddetalleordendepago'];
		$modelCheque->save();
		
		
	}
	public function nuevaTransf($datos){
		
		$modelTransf= new Movimientobanco;
		$modelTransf->descripcion="Pago N°:".(string)$datos['idordendepago']." a: ".(string)$datos['nombreprov'];
		$modelTransf->fecha=$datos['fecha'];
		$modelTransf->debeohaber=1;
		$modelTransf->haber=$datos['importe'];
		$modelTransf->ctabancaria_idctabancaria=$datos['transbanco'];
		$modelTransf->iddetalleordendepago=$datos['iddetalleordendepago'];
		$modelTransf->save();
			
	}
	public function cargarChequeTercero($datos){
		$modelchequetercero=Cheque::model()->findByPk($datos['idcheque']);
		$modelchequetercero->estado=4; //para que pase a estado endozado
		$modelchequetercero->proveedor_idproveedor=$datos['idprov'];
		$modelchequetercero->iddetalleordendepago=$datos['iddetalleordendepago'];
		$modelchequetercero->save();
	}
	
	public function cambioAsiento($nuevo){
		$Asiento=Asiento::model()->find("ordendepago_idordendepago=:id",
					array(':id'=>$nuevo['idordendepago']));
		$DeAs=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:cuenta",
						array(':idasiento'=>$Asiento->idasiento,
							  ':cuenta'=>48)); //211100 Proveedores compras varias
		$DeAs->debe=$nuevo['totalordendepago'];
		$DeAs->save();
		$Asiento->fecha=$nuevo['fecha'];
		$Asiento->save();
	}
	
	public function idProveedor($idctacte){
		$sql="SELECT proveedor.idproveedor as idprov, proveedor.nombre AS nombreprov  FROM proveedor,ctacteprov,ordendepago 
				WHERE proveedor.idproveedor =ctacteprov.proveedor_idproveedor and  ctacteprov.idctacteprov = ".$idctacte." LIMIT 1;";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$resultado = $dbCommand->queryAll();
			//$nombreprov=$resultado[0]['nombreproveedor'];
		
		return $resultado;
	}

   	public function cambioTipoBorrado($tipoguardado,$datos){
   		switch ($tipoguardado){
   			case 0 :
   				$commandmovi= Yii::app()->db->createCommand();
				$commandmovi->delete('movimientocaja','iddetalleordendepago=:id_de_trabajo',
									array(
									':id_de_trabajo'=>$datos['iddetalleordendepago'],
								    )
   								);
						
   				break;
   			case 1 :
   				$commandmovi= Yii::app()->db->createCommand();
   				$commandmovi->delete('cheque','iddetalleordendepago=:id_de_trabajo',
								array(
								':id_de_trabajo'=>$datos['iddetalleordendepago'],
								)
								);
						
   				break;
   			case 2 :
   				$commandmovi= Yii::app()->db->createCommand();
   				$commandmovi->delete('movimientobanco','iddetalleordendepago=:id_de_trabajo',
								array(
								':id_de_trabajo'=>$datos['iddetalleordendepago'],
								)
								);
						
   				break;
   			case 3 :
	   			$sql="UPDATE `cheque`
								 SET 								
									`estado`=2,
									`proveedor_idproveedor`= NULL,
									`iddetalleordendepago`= NULL
								 WHERE  
								 	idcheque=\"".$datos['idcheque']."\"  LIMIT 1;";
						$dbCommand = Yii::app()->db->createCommand($sql);
						$dbCommand->execute();
	   				
   				break;
   		}
   	}
	public function cambioTipoNuevoDetalle($datos){
		
		$datos['tipoordendepago']= (int)$datos['tipoordendepago'];
		switch ($datos['tipoordendepago']){
			case 0:
				$this->nuevoMovCaja($datos);
				break;
			case 1:
				
				/*$fechaingreso= DateTime::createFromFormat('Y-m-d', $datos['fechaingreso']);
				$datos['fechaingreso']=$fechaingreso->format('d/m/Y');
				$fechacobro= DateTime::createFromFormat('Y-m-d', $datos['fechacobro']);
				$datos['fechacobro']=$fechacobro->format('d/m/Y');*/
				$this->nuevoCheque($datos);
				break;
			case 2:
				
				$this->nuevaTransf($datos);
				break;
			case 3:
				$this->cargarChequeTercero($datos);
				break;
		}
	}
	public function modUpdateItemsDetAsiento($datosviejos, $nuevosdatos){
		
		//detalle asiento relacionado al detalleordendepago
		$DeAs=Detalleasiento::model()->find("iddetalleordendepago=:id",
				array(':id'=>$datosviejos['iddetalleordendepago']));
		
		switch ($datosviejos['tipoordendepago']){
			
				case 0:  // para un detalle del tipo efectivo
				$MovCaja=Movimientocaja::model()->find("iddetalleordendepago=:id",
						array(':id'=>$datosviejos['iddetalleordendepago']));
				$MovCaja->haber=$nuevosdatos['importe'];
				$MovCaja->caja_idcaja=$nuevosdatos['caja_idcaja'];
				$MovCaja->update();
				$DeAs->haber=$nuevosdatos['importe'];
				$DeAs->cuenta_idcuenta=$MovCaja->cajaIdcaja->cuenta_idcuenta;
				$DeAs->update();
				break;
			
			case 1: // para un detalle del cheque
					if( ($datosviejos['chequera'] != $nuevosdatos['chequera']) || 
				    ($datosviejos['fechaingreso'] != $nuevosdatos['fechaingreso']) ||
				    ($datosviejos['fechacobro'] != $nuevosdatos['fechacobro']) ||
				    ($datosviejos['titular'] != $nuevosdatos['titular']) ||
				    ($datosviejos['cuittitular'] != $nuevosdatos['cuittitular']) ||
				    ($datosviejos['chequenumero'] != $nuevosdatos['chequenumero']) ||
				    ($datosviejos['importe'] != $nuevosdatos['importe']) )
				{
					
					$cheque=Cheque::model()->find("iddetalleordendepago=:id",
							array(':id'=>$datosviejos['iddetalleordendepago']));
					$cheque->nrocheque=$nuevosdatos['chequenumero'];
					$cheque->fechaingreso=$nuevosdatos['fechaingreso'];
					$cheque->fechacobro=$nuevosdatos['fechacobro'];
					$cheque->titular=$nuevosdatos['titular'];
					$cheque->cuittitular=$nuevosdatos['cuittitular'];
					$cheque->haber=$nuevosdatos['importe'];
					$cheque->chequera_idchequera=$nuevosdatos['chequera'];
					$cheque->update();
					
					$DeAs->debe=$nuevosdatos['importe'];
					$DeAs->update();
									 
				    }	
				break;
			
			case 2: //para un detalle tipo transaccion
				if(	($datosviejos['transbanco'] != $nuevosdatos['transbanco']) || 
					($datosviejos['importe'] != $nuevosdatos['importe']))
					{
						$trans=Movimientobanco::model()->find("iddetalleordendepago=:id",
								array(':id'=>$datosviejos['iddetalleordendepago']));
						$trans->haber=$nuevosdatos['importe'];
						$trans->ctabancaria_idctabancaria=$nuevosdatos['transbanco'];
						$trans->update();	
						
						$DeAs->debe=$nuevosdatos['importe'];
						$CtaBancaria=Ctabancaria::model()->findByPk($nuevosdatos['transbanco']);
						$DeAs->cuenta_idcuenta=$CtaBancaria->cuenta_idcuenta;
						$DeAs->update();
					}
			break;
			
			case 3: //para un detalle tipo cheque endozado
				//la 1° parte es para volver el cheque que se usó anteriormente al estado a cobrar
				if($datosviejos['idcheque'] != $nuevosdatos['idcheque']){
					$chequeViejo=Cheque::model()->findByPk($datosviejos['idcheque']);
					$chequeViejo->iddetalleordendepago=null;
					$chequeViejo->estado=2;
					$chequeViejo->proveedor_idproveedor=null;
					$chequeViejo->save();
					
					$this->cargarChequeTercero($nuevosdatos);
				}
			break; 
		}
	}
	public function incrementoCtacte($idctacte,$importe){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctacteprov', array(
				    'ctacteprov.haber'=>new CDbExpression('ctacteprov.haber + '.$importe),
				), 'idctacteprov='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
 	public function modificarImporteCtaCte($impviejo,$impnuevo,$idctacte){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctacteprov', array(
				    'ctacteprov.haber'=>new CDbExpression('ctacteprov.haber - '.$impviejo.' + '.$impnuevo),
				), 'idctacteprov='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
 	public function decrementarCtacteDelete($idctacte, $importe){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctacteprov', array(
				    'ctacteprov.haber'=>new CDbExpression('ctacteprov.haber - '.$importe),
				), 'idctacteprov='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
 	public function updateSaldoCtaCte($idctacte){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctacteprov', array(
				    'ctacteprov.saldo'=>new CDbExpression('ROUND(ctacteprov.debe - ctacteprov.haber,2)'),
				), 'idctacteprov='.$idctacte);
 	}
	
	public function borrarDetCtaCte($idordendepago,$importe,$idctacte){
 			$commandmovi= Yii::app()->db->createCommand();
			$commandmovi->delete('detallectacteprov',
						'ordendepago_idordendepago=:iddocument AND haber=:haber AND
						 ctacteprov_idctacteprov=:idctacteprov',
						array(':iddocument'=>$idordendepago,
							  ':haber'=>$importe,
							  ':idctacteprov'=>$idctacte));
 	}
	public function gridNombreProveedor($data,$row){
		$sql="SELECT proveedor.nombre AS nombre
				FROM proveedor, ctacteprov, ordendepago
				WHERE proveedor.idproveedor = ctacteprov.proveedor_idproveedor
				AND ctacteprov.idctacteprov =".$data->ctacteprov_idctacteprov." 
				LIMIT 1;";
		
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$resultado = $dbCommand->queryAll();
		$nombre=$resultado[0]['nombre'];
		
		return $nombre;
	}
	public function cambioDetalleAsiento($tipoguardado, $nuevo){
		
		$DeAsiento=Detalleasiento::model()->find("iddetalleordendepago=:id", 
					array(':id'=>$nuevo['iddetalleordendepago']));
		//print_r($nuevo);die();
		switch ($nuevo['tipoordendepago']) {
			case 0:
				$cuentacaja= Caja::model()->findByPk($nuevo['caja_idcaja']);
				$DeAsiento->cuenta_idcuenta=$cuentacaja->cuenta_idcuenta;
				$DeAsiento->haber=$nuevo['importe'];
				$DeAsiento->save();
			break;
			case 1:
				$chequera=Chequera::model()->findByPk($nuevo['chequera']);
				$DeAsiento->cuenta_idcuenta=$chequera->cuenta_idcuenta; //la cuenta según la chequera
				$DeAsiento->haber=$nuevo['importe'];
				$DeAsiento->save();
			break;
			case 2:
				$ctabancaria=Ctabancaria::model()->findByPk($nuevo['transbanco']);
				$DeAsiento->cuenta_idcuenta=$ctabancaria->cuenta_idcuenta; 
				$DeAsiento->haber=$nuevo['importe'];
				$DeAsiento->save();
			break;
			case 3:
				//cheque endosados
				$DeAsiento->cuenta_idcuenta = 5;// cheque 3ros
				$DeAsieto->haber=$nuevo['importe'];
				$DeAsiento->save();
			break;
		}
		
	}
	
	public function borradoDetAsiento($borrado){
		$DeAs=Detalleasiento::model()->find("iddetalleordendepago=:id",
			array(':id'=>$borrado));
		$DeAs->delete();
	}
	
	public function modImpDetalleCtacte($idctacte,$idordendepago,$impnuevo, $fecha){
		$detalle=Detallectacteprov::model()->find("ordendepago_idordendepago=:id AND ctactecliente_idctactecliente=:ctacte",
						array(':id'=>$idordendepago,
							  ':ctacte'=>$idctacte));
		$detalle->haber=$impnuevo;
		$detalle->fecha=$fecha;
		$detalle->save();
		$asiento=Asiento::model()->find("cobranza_idcobranza=:id",
					array(':id'=>$idcobranza));
		$asiento->fecha=$fecha;
		$asiento->save();
	}
	public function actionEnvio(){
		$dato=$_POST['data'];
		$model=Cheque::model()->findByPk($dato,'estado = 2');
		$val=array(
			'idcheque'=>$model->idcheque,
			'nrocheque'=>$model->nrocheque,
			'feingreso'=>$model->fechaingreso,
			'fecobro'=>$model->fechacobro,
			'titular'=>$model->titular,
			'cuittitular'=>$model->cuittitular,
			'importe'=>$model->debe,
			'banco'=>$model->Banco_idBanco,
			);	
			echo json_encode($val);
		
		
	}
	public function resetDetalle($iddetalle){
		$detalle=Detalleordendepago::model()->findByPk($iddetalle);
		$detalle->transferenciabanco=null;
		$detalle->chequefechacobro=null;
		$detalle->chequefechaingreso=null;
		$detalle->chequetitular=null;
		$detalle->chequecuittitular=null;
		$detalle->nrocheque=null;
		$detalle->chequebanco=null;
		$detalle->idcheque=null;
		$detalle->chequera=null;
		$detalle->caja_idcaja=null;
		$detalle->save();
	}
}