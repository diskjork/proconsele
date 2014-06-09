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
			
		if (isset($_POST['Detalleordendepago']['tipoordendepago'])){
   				$cantidadElementos=count($_POST['Detalleordendepago']['tipoordendepago']); 
				
   				for($i=0;$i<$cantidadElementos;$i++){
				/*	
   					//para efectivo
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 0){ 
						$itemEfectivo[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
					}
					 //para cheque
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 1){
						$itemCheque[$i]['chequebanco']=$_POST['Detalleordendepago']['chequebanco'][$i];
						$itemCheque[$i]['chequefechaingreso']=$_POST['Detalleordendepago']['chequefechaingreso'][$i];
						$itemCheque[$i]['chequetitular']=$_POST['Detalleordendepago']['chequetitular'][$i];
						$itemCheque[$i]['chequecuittitular']=$_POST['Detalleordendepago']['chequecuittitular'][$i];
						$itemCheque[$i]['chequefechacobro']=$_POST['Detalleordendepago']['chequefechacobro'][$i];
						$itemCheque[$i]['chequenumero']=$_POST['Detalleordendepago']['nrocheque'][$i];
						$itemCheque[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
					}
					//para transferencia
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 2){ 
						$itemTransf[$i]['transferenciabanco']=$_POST['Detalleordendepago']['transferenciabanco'][$i];
						$itemTransf[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
						
					}*/
					//para cheque de terceros para endozar
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 3){
						$itemCheque_terc[$i]['chequebanco']=$_POST['Detalleordendepago']['chequebanco'][$i];
						$itemCheque_terc[$i]['chequefechaingreso']=$_POST['Detalleordendepago']['chequefechaingreso'][$i];
						$itemCheque_terc[$i]['chequetitular']=$_POST['Detalleordendepago']['chequetitular'][$i];
						$itemCheque_terc[$i]['chequecuittitular']=$_POST['Detalleordendepago']['chequecuittitular'][$i];
						$itemCheque_terc[$i]['chequefechacobro']=$_POST['Detalleordendepago']['chequefechacobro'][$i];
						$itemCheque_terc[$i]['chequenumero']=$_POST['Detalleordendepago']['nrocheque'][$i];
						$itemCheque_terc[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
						$itemCheque_terc[$i]['idcheque']=$_POST['Detalleordendepago']['idcheque'][$i];
					}
   					
				}
   			}  
			
   			//elementos nuevos despues de una validación
   			if (isset($_POST['Detalleordendepago']['n__'])){
   				//$nuevos= $this->nuevosElementosNoValidados($_POST['Detalleordendepago']['n__']);
   				$cantidadElementos=count($_POST['Detalleordendepago']['n__']); 
				
   				for($i=0;$i<$cantidadElementos;$i++){
					/*
   					//para efectivo
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 0){ 
						$itemEfectivo[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
					}
					 //para cheque
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 1){
						$itemCheque[$i]['chequebanco']=$_POST['Detalleordendepago']['n__'][$i]['chequebanco'];
						$itemCheque[$i]['chequefechaingreso']=$_POST['Detalleordendepago']['n__'][$i]['chequefechaingreso'];
						$itemCheque[$i]['chequetitular']=$_POST['Detalleordendepago']['n__'][$i]['chequetitular'];
						$itemCheque[$i]['chequecuittitular']=$_POST['Detalleordendepago']['n__'][$i]['chequecuittitular'];
						$itemCheque[$i]['chequefechacobro']=$_POST['Detalleordendepago']['n__'][$i]['chequefechacobro'];
						$itemCheque[$i]['chequenumero']=$_POST['Detalleordendepago']['n__'][$i]['nrocheque'];
						$itemCheque[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
					}
					//para transferencia
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 2){ 
						$itemTransf[$i]['transferenciabanco']=$_POST['Detalleordendepago']['n__'][$i]['transferenciabanco'];
						$itemTransf[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
						
					}
					
					*/
   				 //para cheque de terceros para endozar
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 3){
						$itemCheque_terc[$i]['chequebanco']=$_POST['Detalleordendepago']['n__'][$i]['chequebanco'];
						$itemCheque_terc[$i]['chequefechaingreso']=$_POST['Detalleordendepago']['n__'][$i]['chequefechaingreso'];
						$itemCheque_terc[$i]['chequetitular']=$_POST['Detalleordendepago']['n__'][$i]['chequetitular'];
						$itemCheque_terc[$i]['chequecuittitular']=$_POST['Detalleordendepago']['n__'][$i]['chequecuittitular'];
						$itemCheque_terc[$i]['chequefechacobro']=$_POST['Detalleordendepago']['n__'][$i]['chequefechacobro'];
						$itemCheque_terc[$i]['chequenumero']=$_POST['Detalleordendepago']['n__'][$i]['nrocheque'];
						$itemCheque_terc[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
						$itemCheque_terc[$i]['idcheque']=$_POST['Detalleordendepago']['n__'][$i]['idcheque'];
					}
				}
   			} 
			if( //validate detail before saving the master
            MultiModelForm::validate($member,$validatedMembers,$deleteItems) &&
            $model->save())
           {
   
             //the value for the foreign key 'groupid'
             $masterValues = array ('ordendepago_idordendepago'=>$model->idordendepago);
            
            
             if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
             {
             	/*
             //PARA GENERAR EL MOVIMIENTO CAJA	
             	$datos=null;
				if(isset($itemEfectivo)){
					foreach ($itemEfectivo as $array){
						foreach ($array as $key => $valor){
							if($key == "importe"){
								$datos['idordendepago']=$model->idordendepago;
								$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
								$datos['nombreprov']=$proveedor[0]['nombreprov'];
								$datos['fecha']=$_POST['Ordendepago']['fecha'];
								$datos['importe']=$valor;
								$this->nuevoMovCaja($datos);
							}
						}
					}
				}
			//PARA GENERAR LOS CHEQUES DE ORDENDEPAGO
				$datos=null;
				if(isset($itemCheque)){
					foreach ($itemCheque as $array){
						foreach ($array as $key=>$valor){
							$datos['idordendepago']=$model->idordendepago;
							$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
							$datos['idprov']=$proveedor[0]['idprov'];
							$datos['nombreprov']=$proveedor[0]['nombreprov'];
							
							switch ($key){
								case "chequebanco":
									$datos['banco']=$valor;
									break;
								case "chequefechaingreso":
									$datos['fechaingreso']=$valor;
									break;
								case "chequetitular":
									$datos['titular']=$valor;
									break;
								case "chequecuittitular":
									$datos['cuittitular']=$valor;
									break;
								case "chequefechacobro":
									$datos['fechacobro']=$valor;
									break;
								case "chequenumero":
									$datos['chequenumero']=$valor;
									break;
								case "importe":
									$datos['importe']=$valor;
									break;
							}
						}
						$this->nuevoCheque($datos);
					}
				}
			//PARA GENERAR LAS TRANSFERENCIAS
				$datos=null;
				if(isset($itemTransf)){
					foreach ($itemTransf as $array){
						foreach ($array as $key=>$valor){
							$datos['idordendepago']=$model->idordendepago;
							$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
							$datos['nombreprov']=$proveedor[0]['nombreprov'];
							$datos['fecha']=$_POST['Ordendepago']['fecha'];
							switch ($key){
								case "transferenciabanco":
									$datos['transbanco']=$valor;
									break;
								case "importe":
									$datos['importe']=$valor;
									break;
							}
						}
						$this->nuevaTransf($datos);
					}	
				} */
		//PARA CARGAR Y MODIFICAR EL ESTADO DEL  LOS CHEQUES DE TERCEROS
				$datos=null;
				if(isset($itemCheque_terc)){
					
					foreach ($itemCheque_terc as $array){
						foreach ($array as $key=>$valor){
							$datos['idordendepago']=$model->idordendepago;
							$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
							$datos['idprov']=$proveedor[0]['idprov'];
							$datos['nombreprov']=$proveedor[0]['nombreprov'];
							
							if($key == "idcheque"){
								$datos['idcheque']=$valor;
							}
						}
						$this->cargarChequeTercero($datos);
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
           	$modelDeCCprov->iddocumento=$model->idordendepago;
           	$modelDeCCprov->haber=$model->importe;
           	$modelDeCCprov->ctacteprov_idctacteprov=$model->ctacteprov_idctacteprov;
           	$modelDeCCprov->save();
           	
           	Yii::app()->user->setFlash('success', "<strong>Orden de pago creada correctamente.</strong>");
			$this->redirect(array('admin'));			
            
			//$this->redirect(array('view','id'=>$model->idordendepago));
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
						$itemUpdate[$i]['iddetalleordendepago']=$iddetalle_nuevo;
						$itemUpdate[$i]['tipoordendepago']=$_POST['Detalleordendepago']['u__'][$i]['tipoordendepago'];
						$itemUpdate[$i]['transbanco']=$_POST['Detalleordendepago']['u__'][$i]['transferenciabanco'];
						$itemUpdate[$i]['banco']=$_POST['Detalleordendepago']['u__'][$i]['chequebanco'];
						$itemUpdate[$i]['fecha']=$model->fecha;
						
						//$itemUpdate[$i]['fechaingreso']=$_POST['Detalleordendepago']['u__'][$i]['chequefechaingreso'];
						if($_POST['Detalleordendepago']['u__'][$i]['chequefechaingreso'] != null){
							$fechaingreso = DateTime::createFromFormat('d/m/Y', $_POST['Detalleordendepago']['u__'][$i]['chequefechaingreso']);
							$itemUpdate[$i]['fechaingreso']=$fechaingreso->format('Y-m-d');
						}else {
							$itemUpdate[$i]['fechaingreso']=$_POST['Detalleordendepago']['u__'][$i]['chequefechaingreso'];
						}
						//$itemUpdate[$i]['fechacobro']=$_POST['Detalleordendepago']['u__'][$i]['chequefechacobro'];
						if($_POST['Detalleordendepago']['u__'][$i]['chequefechacobro'] != null){
							$fechacobro = DateTime::createFromFormat('d/m/Y', $_POST['Detalleordendepago']['u__'][$i]['chequefechacobro']);
							$itemUpdate[$i]['fechacobro']=$fechacobro->format('Y-m-d');
						}else {
							$itemUpdate[$i]['fechacobro']=$_POST['Detalleordendepago']['u__'][$i]['chequefechacobro'];
						}
						$itemUpdate[$i]['idcheque']=$_POST['Detalleordendepago']['u__'][$i]['idcheque'];
						$itemUpdate[$i]['titular']=$_POST['Detalleordendepago']['u__'][$i]['chequetitular'];
						$itemUpdate[$i]['cuittitular']=$_POST['Detalleordendepago']['u__'][$i]['chequecuittitular'];
						$itemUpdate[$i]['chequenumero']=$_POST['Detalleordendepago']['u__'][$i]['nrocheque'];
						$itemUpdate[$i]['importe']=doubleval($_POST['Detalleordendepago']['u__'][$i]['importe']);
						$itemUpdate[$i]['nombreprov']=$proveedor[0]['nombreprov'];
						$itemUpdate[$i]['idprov']=$proveedor[0]['idprov'];
						$itemUpdate[$i]['idordendepago']=$DC_trabajo->ordendepago_idordendepago;
						
						//Datos del detalle ya guardado-----------------------------------
						$datos[$i]['iddetalleordendepago']=$iddetalle_nuevo;
						$datos[$i]['idordendepago']=$DC_trabajo->ordendepago_idordendepago;
						$datos[$i]['tipoordendepago']=$DC_trabajo->tipoordendepago;
						$datos[$i]['nombreprov']=$proveedor[0]['nombreprov'];
						$fecha = DateTime::createFromFormat('d/m/Y', $model->fecha);
						$datos[$i]['fecha']=$fecha->format('Y-m-d');
						$datos[$i]['importe']=doubleval($DC_trabajo->importe);
						$datos[$i]['chequenumero']=(int) $DC_trabajo->nrocheque;
						if($DC_trabajo->chequefechaingreso != null){
							$fechaingreso = DateTime::createFromFormat('d/m/Y', $DC_trabajo->chequefechaingreso);
							$datos[$i]['fechaingreso']=$fechaingreso->format('Y-m-d');
						}else {
							$datos[$i]['fechaingreso']=$DC_trabajo->chequefechaingreso;
						}
						if($DC_trabajo->chequefechacobro != null){
							$fechacobro = DateTime::createFromFormat('d/m/Y', $DC_trabajo->chequefechacobro);
							$datos[$i]['fechacobro']=$fechacobro->format('Y-m-d');
						}else {
							$datos[$i]['fechacobro']=$DC_trabajo->chequefechaingreso;
						}
						$datos[$i]['idcheque']=$DC_trabajo->idcheque;
						$datos[$i]['titular']=$DC_trabajo->chequetitular;
						$datos[$i]['cuittitular']=$DC_trabajo->chequecuittitular;
						$datos[$i]['banco']=$DC_trabajo->chequebanco;
						$datos[$i]['idprov']=$proveedor[0]['idprov'];
						$datos[$i]['transbanco']=$DC_trabajo->transferenciabanco;
							
					}else {
						//elementos borrados
						$elem_borrados_DCob[$i]['iddetalleordendepago']=$iddetalle_nuevo;
						$elem_borrados_DCob[$i]['idordendepago']=$DC_trabajo->ordendepago_idordendepago;
						$elem_borrados_DCob[$i]['tipoordendepago']=$DC_trabajo->tipoordendepago;
						$elem_borrados_DCob[$i]['nombreprov']=$proveedor[0]['nombreprov'];
						$fecha = DateTime::createFromFormat('d/m/Y', $model->fecha);
						$elem_borrados_DCob[$i]['fecha']=$fecha->format('Y-m-d');
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
			
			
//elementos nuevos ----------------------------------------------------------
		if (isset($_POST['Detalleordendepago']['tipoordendepago'])){
   				$cantidadElemNuevos=count($_POST['Detalleordendepago']['tipoordendepago']); 
				
   				for($i=0;$i<$cantidadElemNuevos;$i++){
					/*
   					//para efectivo
					if(($_POST['Detalleordendepago']['tipoordendepago'][$i] == 0) && ($_POST['Detalleordendepago']['importe'][$i]!= null)){ 
						
						$itemEfectivo[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
					}
					 //para cheque
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 1){
						$itemCheque[$i]['chequebanco']=$_POST['Detalleordendepago']['chequebanco'][$i];
						$itemCheque[$i]['chequefechaingreso']=$_POST['Detalleordendepago']['chequefechaingreso'][$i];
						$itemCheque[$i]['chequefechacobro']=$_POST['Detalleordendepago']['chequefechacobro'][$i];
						$itemCheque[$i]['chequetitular']=$_POST['Detalleordendepago']['chequetitular'][$i];
						$itemCheque[$i]['chequecuittitular']=$_POST['Detalleordendepago']['chequecuittitular'][$i];
						$itemCheque[$i]['chequenumero']=$_POST['Detalleordendepago']['nrocheque'][$i];
						$itemCheque[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
					}
					//para transferencia
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 2){ 
						$itemTransf[$i]['transferenciabanco']=$_POST['Detalleordendepago']['transferenciabanco'][$i];
						$itemTransf[$i]['importe']=$_POST['Detalleordendepago']['importe'][$i];
					}
					*/
   				//para cheque de terceros para endozar
					if($_POST['Detalleordendepago']['tipoordendepago'][$i] == 3){
						$itemCheque_terc[$i]['idcheque']=$_POST['Detalleordendepago']['idcheque'][$i];
					}
				}
   			}
// elementos nuevos despues de un error de validación
   			if (isset($_POST['Detalleordendepago']['n__'])){
   				//$nuevos= $this->nuevosElementosNoValidados($_POST['Detalleordendepago']['n__']);
   				$cantidadElementos=count($_POST['Detalleordendepago']['n__']); 
				
   				for($i=0;$i<$cantidadElementos;$i++){
					/*
   					//para efectivo
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 0){ 
						$itemEfectivo[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
					}
					 //para cheque
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 1){
						$itemCheque[$i]['chequebanco']=$_POST['Detalleordendepago']['n__'][$i]['chequebanco'];
						$itemCheque[$i]['chequefechaingreso']=$_POST['Detalleordendepago']['n__'][$i]['chequefechaingreso'];
						$itemCheque[$i]['chequefechacobro']=$_POST['Detalleordendepago']['n__'][$i]['chequefechacobro'];
						$itemCheque[$i]['chequetitular']=$_POST['Detalleordendepago']['n__'][$i]['chequetitular'];
						$itemCheque[$i]['chequecuittitular']=$_POST['Detalleordendepago']['n__'][$i]['chequecuittitular'];
						$itemCheque[$i]['chequenumero']=$_POST['Detalleordendepago']['n__'][$i]['nrocheque'];
						$itemCheque[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
					}
					//para transferencia
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 2){ 
						$itemTransf[$i]['transferenciabanco']=$_POST['Detalleordendepago']['n__'][$i]['transferenciabanco'];
						$itemTransf[$i]['importe']=$_POST['Detalleordendepago']['n__'][$i]['importe'];
						
					}
					*/
   				//para cheque de terceros para endozar
					if($_POST['Detalleordendepago']['n__'][$i]['tipoordendepago'] == 3){
						$itemCheque_terc[$i]['idcheque']=$_POST['Detalleordendepago']['n__'][$i]['idcheque'];
					}
				}
   			} 
			
				$masterValues = array ('ordendepago_idordendepago'=>$model->idordendepago);
				//para comprobar si el importe ha sido modificado
				$llave=null;
				$ordendepagoguardada=Ordendepago::model()->findByPk($model->idordendepago);//modelo ordendepago guardado
				if($ordendepagoguardada->importe != $_POST['Ordendepago']['importe']){
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
           		$idctacte=$model->ctacteprov_idctacteprov;
           		$this->modificarImporteCtaCte($importeviejo, $importenuevo, $idctacte);
           		$this->modImpDetalleCtacte($idctacte, $id, $importenuevo);
           	}
           	
          //Si se ha modificado un detalle de ordendepago..
          	if(isset($itemUpdate) && isset($datos)){
          		foreach ($itemUpdate as $key_uno=>$valor_uno){
          			foreach($valor_uno as $key_dos=>$valor_dos){
          				if($key_dos == "tipoordendepago"){
          					//compara si el tipo de ordendepago se ha modificado o no en un item
          					if($valor_dos != $datos[$key_uno]['tipoordendepago']){
          						$tipoguardado=$datos[$key_uno]['tipoordendepago'];
          						$this->cambioTipoBorrado($tipoguardado, $datos[$key_uno]);
          						$this->resetDetalle($datos[$key_uno]['iddetalleordendepago']);
          						$this->cambioTipoNuevoDetalle($valor_uno);
          					
          					} else { // cuando el tipo de ordendepago se mantuvo
          						       						 
          						$this->modDeActulizacionDeItems($datos[$key_uno], $valor_uno);
          					}
          				}
          			}
          		}
          		
          	}
          	
          	//si existe un elemento detalleordendepago borrado 
          	if(isset($elem_borrados_DCob)){
          		foreach($elem_borrados_DCob as $keyBorr_uno=>$valorBorr_uno){
          			foreach ($valorBorr_uno as $keyborr_dos=>$valorborr_dos){
          				if($keyborr_dos == "tipoordendepago"){
          					$tipoguardadoBorr=$valorborr_dos;
          					$this->cambioTipoBorrado($tipoguardadoBorr, $valorBorr_uno);
          				}
          				
          			}
          		}
          		
          	}
        /*   
           	//para el caso de elementos nuevos despues de actualizar la ordendepago
           //PARA GENERAR EL MOVIMIENTO CAJA	
             	$datos=null;
				if(isset($itemEfectivo)){
					foreach ($itemEfectivo as $array){
						foreach ($array as $key => $valor){
							if($key == "importe"){
								$datos['idordendepago']=$model->idordendepago;
								$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
								$datos['nombreprov']=$proveedor[0]['nombreprov'];
								$datos['fecha']=$_POST['ordendepago']['fecha'];
								$datos['importe']=$valor;
								$this->nuevoMovCaja($datos);
							}
						}
					}
				}
			//PARA GENERAR LOS CHEQUES DE ordendepago
				$datos=null;
				if(isset($itemCheque)){
					foreach ($itemCheque as $array){
						foreach ($array as $key=>$valor){
							$datos['idordendepago']=$model->idordendepago;
							$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
							$datos['idprov']=$proveedor[0]['idprov'];
							$datos['nombreprov']=$proveedor[0]['nombreprov'];
							
							switch ($key){
								case "chequebanco":
									$datos['banco']=$valor;
									break;
								case "chequefechaingreso":
									$datos['fechaingreso']=$valor;
									break;
								case "chequefechacobro":
									$datos['fechacobro']=$valor;
									break;
								case "chequetitular":
									$datos['titular']=$valor;
									break;
								case "chequecuittitular":
									$datos['cuittitular']=$valor;
									break;
								case "chequenumero":
									$datos['chequenumero']=$valor;
									break;
								case "importe":
									$datos['importe']=$valor;
									break;
							}
						}
						$this->nuevoCheque($datos);
					}
				}
			//PARA GENERAR LAS TRANSFERENCIAS
				$datos=null;
				if(isset($itemTransf)){
					foreach ($itemTransf as $array){
						foreach ($array as $key=>$valor){
							$datos['idordendepago']=$model->idordendepago;
							$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
							$datos['nombreprov']=$proveedor[0]['nombreprov'];
							$datos['fecha']=$_POST['Ordendepago']['fecha'];
							switch ($key){
								case "transferenciabanco":
									$datos['transbanco']=$valor;
									break;
								case "importe":
									$datos['importe']=$valor;
									break;
							}
						}
						$this->nuevaTransf($datos);
					}	
				} */
			//PARA CARGAR Y MODIFICAR EL ESTADO DEL  LOS CHEQUES DE TERCEROS
				$datos=null;
				if(isset($itemCheque_ter)){
					foreach ($itemCheque_ter as $array){
						foreach ($array as $key=>$valor){
							$datos['idordendepago']=$model->idordendepago;
							$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
							$datos['idprov']=$proveedor[0]['idprov'];
							$datos['nombreprov']=$proveedor[0]['nombreprov'];
							
							if($key == "idcheque"){
								$datos['idcheque']=$valor;
							}
						}
						$this->cargarChequeTercero($datos);
					}
				}	
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
	
public function nuevoMovCaja($datos){
		
							
		$modelmovcaja=new Movimientocaja;
		$modelmovcaja->descripcion= "Orden de pago N°".(string)$datos['idordendepago']." - ".(string)$datos['nombreprov']."-";
		$modelmovcaja->fecha=$datos['fecha'];
		$modelmovcaja->debeohaber=1;
		$modelmovcaja->caja_idcaja=1;
		$modelmovcaja->rubro_idrubro=6;
		$modelmovcaja->formadepago_idformadepago=1;
		$modelmovcaja->haber=$datos['importe'];
		$modelmovcaja->id_de_trabajo=$datos['iddetalleordendepago'];
		$modelmovcaja->save();
			}
	public function nuevoCheque($datos){
		
		
		$modelCheque= new Cheque;
		$modelCheque->nrocheque=$datos['chequenumero'];
		//$modelCheque->concepto="Orden de pago Nro.: ".(string)$datos['idordendepago']."-".(string)$datos['nombreprov']."-";
		$modelCheque->fechaingreso=$datos['fechaingreso'];
		$modelCheque->fechacobro=$datos['fechacobro'];
		$modelCheque->titular=$datos['titular'];
		$modelCheque->cuittitular=$datos['cuittitular'];
		$modelCheque->haber=$datos['importe'];
		$modelCheque->debeohaber=1;
		$modelCheque->Banco_idBanco=$datos['banco'];
		$modelCheque->proveedor_idproveedor=$datos['idprov'];
		$modelCheque->estado=0;
		$modelCheque->id_trabajo_ordendepago=$datos['iddetalleordendepago'];
		$modelCheque->save();
		
		
	}
	public function nuevaTransf($datos){
		
		$modelTransf= new Movimientobanco;
		$modelTransf->descripcion="Orden de Pago N°:".(string)$datos['idordendepago']."-".(string)$datos['nombreprov']."-";
		$modelTransf->fecha=$datos['fecha'];
		$modelTransf->debeohaber=1;
		$modelTransf->haber=$datos['importe'];
		$modelTransf->rubro_idrubro=6;
		$modelTransf->Banco_idBanco=$datos['transbanco'];
		$modelTransf->formadepago_idformadepago=3;
		$modelTransf->id_de_trabajo=$datos['iddetalleordendepago'];
		$modelTransf->save();
			
	}
	public function cargarChequeTercero($datos){
		$modelchequetercero=Cheque::model()->findByPk($datos['idcheque']);
		if($modelchequetercero->estado == 2){ // está para cobrar?
			$modelchequetercero->estado=4; //para que pase a estado endozado
			$modelchequetercero->proveedor_idproveedor=$datos['idprov'];
			if(isset($datos['iddetalleordendepago'])){
				if($datos['iddetalleordendepago'] != null){
					$modelchequetercero->id_trabajo_ordendepago=$datos['iddetalleordendepago'];
				}
			}
			$modelchequetercero->save();
		}else { 
			if($modelcheque->estado == 3){
    			$this->addError('chequetitular', 'Cheque cobrado por caja.');
			}
    		if($modelcheque->estado == 4){
    			$this->addError('chequetitular', 'Cheque endozado.');
			}
		}
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
				$commandmovi->delete('movimientocaja','id_de_trabajo=:id_de_trabajo',
									array(
									':id_de_trabajo'=>$datos['iddetalleordendepago'],
								    )
   								);
						
   				break;
   			case 1 :
   				$commandmovi= Yii::app()->db->createCommand();
   				$commandmovi->delete('cheque','id_trabajo_ordendepago=:id_de_trabajo',
								array(
								':id_de_trabajo'=>$datos['iddetalleordendepago'],
								)
								);
						
   				break;
   			case 2 :
   				$commandmovi= Yii::app()->db->createCommand();
   				$commandmovi->delete('movimientobanco','id_de_trabajo=:id_de_trabajo',
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
									`id_trabajo_ordendepago`= NULL
								 WHERE  
								 	idcheque=\"".$datos['idcheque']."\"  LIMIT 1;";
						$dbCommand = Yii::app()->db->createCommand($sql);
						$dbCommand->execute();
	   				//$commandmovi= Yii::app()->db->createCommand();
   				//$commandmovi->update('cheque',array('estado'=>'2','proveedor_idproveedor'=>null),'idcheque=:idcheque',
					//			array(':idcheque'=>$datos['idcheque']));
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
				
				$fechaingreso= DateTime::createFromFormat('Y-m-d', $datos['fechaingreso']);
				$datos['fechaingreso']=$fechaingreso->format('d/m/Y');
				$fechacobro= DateTime::createFromFormat('Y-m-d', $datos['fechacobro']);
				$datos['fechacobro']=$fechacobro->format('d/m/Y');
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
	public function modDeActulizacionDeItems($datosviejos, $nuevosdatos){
		
		$datosviejos['tipoordendepago']=(int)$datosviejos['tipoordendepago'];
		
		switch ($datosviejos['tipoordendepago']){
			
			case 0:  // para un detalle del tipo efectivo
				if($datosviejos['importe'] != $nuevosdatos['importe']){
						$commandmovi= Yii::app()->db->createCommand();
			   			$commandmovi->update('movimientocaja',array('debe'=>(double)$nuevosdatos['importe']),
			   									
			   									 'id_de_trabajo=:id_de_trabajo LIMIT 1',
								array(
								':id_de_trabajo'=>$datosviejos['iddetalleordendepago'],)
   								);
					}
				break;
			
			case 1: // para un detalle del cheque
					if( ($datosviejos['banco'] != $nuevosdatos['banco']) || 
				    ($datosviejos['fechaingreso'] != $nuevosdatos['fechaingreso']) ||
				    ($datosviejos['fechacobro'] != $nuevosdatos['fechacobro']) ||
				    ($datosviejos['titular'] != $nuevosdatos['titular']) ||
				    ($datosviejos['cuittitular'] != $nuevosdatos['cuittitular']) ||
				    ($datosviejos['chequenumero'] != $nuevosdatos['chequenumero']) ||
				    ($datosviejos['importe'] != $nuevosdatos['importe']) )
				{
					$sql="UPDATE `cheque`
							 SET 
								`nrocheque`=".$nuevosdatos['chequenumero'].",
								`fechaingreso`=\"".$nuevosdatos['fechaingreso']."\",
								`fechacobro`=\"".$nuevosdatos['fechacobro']."\",
								`titular`=\"".$nuevosdatos['titular']."\",
								`cuittitular`=\"".$nuevodatos['cuittitular']."\",
								`haber`=".$nuevosdatos['importe'].",
								`Banco_idBanco`=".$nuevosdatos['banco']."
							 WHERE  
							 	id_trabajo_ordendepago=\"".$datosviejos['iddetalleordendepago']."\" 
							 	LIMIT 1;";
					$dbCommand = Yii::app()->db->createCommand($sql);
					$dbCommand->execute();
					
									 
				    }	
				break;
			
			case 2: //para un detalle tipo transaccion
				if(	($datosviejos['transbanco'] != $nuevosdatos['transbanco']) || 
					($datosviejos['importe'] != $nuevosdatos['importe']))
					{
						$sql="UPDATE `movimientobanco`
							 SET 
								`haber`=".$nuevosdatos['importe'].",
								`Banco_idBanco`=".$nuevosdatos['transbanco']."
							 WHERE  
							 	id_de_trabajo=\"".$datosviejos['iddetalleordendepago']."\" 
							 	LIMIT 1;";
					$dbCommand = Yii::app()->db->createCommand($sql);
					$dbCommand->execute();
					/*echo $dbCommand->getText();
					print_r($dbCommand->params);die();*/
					}
				break;
			
			case 3: //para un detalle tipo cheque endozado
				//la 1° parte es para volver el cheque que se usó anteriormente al estado a cobrar
				if($datosviejos['idcheque'] != $nuevosdatos['idcheque']){
					$commandmovi= Yii::app()->db->createCommand();
   					$commandmovi->update('cheque',array('estado'=>2, 
   														'id_trabajo_ordendepago'=>null, 
   														'proveedor_idproveedor'=>null),
   												'idcheque=:idcheque',
												array(':idcheque'=>$datosviejos['idcheque']));
				$commandmovi->update('cheque',array('estado'=>4,
													'id_trabajo_ordendepago'=>$datosviejos['iddetalleordendepago'],
													'proveedor_idproveedor'=>$datosviejos['idprov']),
											'idcheque=:idcheque',
											array(':idcheque'=>$nuevosdatos['idcheque'])); 
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
						'iddocumento=:iddocument AND haber=:haber AND
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
	public function modImpDetalleCtacte($idctacte,$idordendepago,$impnuevo){
		$command = Yii::app()->db->createCommand();
		$command->update('detallectacteprov', array(
				    'detallectacteprov.haber'=>new CDbExpression($impnuevo),
				), 'iddocumento='.$idordendepago.' AND ctacteprov_idctacteprov='.$idctacte);
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
		$detalle->save();
	}
}