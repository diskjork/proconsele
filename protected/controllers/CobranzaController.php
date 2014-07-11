<?php

class CobranzaController extends Controller
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
		if( Yii::app()->request->isAjaxRequest )
	        {
	        $this->renderPartial('view',array(
	            'model'=>$this->loadModel($id),
	        ), false, true);
	    }
	    else{
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
	    }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::import('ext.multimodelform.MultiModelForm');
		
		$model = new Cobranza;
		
		$member = new Detallecobranza;
    	$validatedMembers = array();  //ensur
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset($_POST['Cobranza'])) {
			$model->attributes=$_POST['Cobranza'];
			//$nuevos=$this->nuevosElementosValidados($_POST['Cobranza']);
		
			if( //validate detail before saving the master
            MultiModelForm::validate($member,$validatedMembers,$deleteItems) &&
            $model->save())
           {
  
    
             //the value for the foreign key 'groupid'
             $masterValues = array ('cobranza_idcobranza'=>$model->idcobranza);
            
            
             if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
             {
             	$cliente=Cliente::model()->find("ctactecliente_idctactecliente=:idctacte",
             					array(":idctacte"=>$_POST['Cobranza']['ctactecliente_idctactecliente']));
             	
             	
             	//ASIENTO PARA LA COBRANZA
             	$asiento=new Asiento;
             	$asiento->fecha=$_POST['Cobranza']['fecha'];
             	$asiento->descripcion="Cobranza N°".$masterValues['cobranza_idcobranza']." ".$cliente->nombre;
             	$asiento->cobranza_idcobranza=$masterValues['cobranza_idcobranza'];
             	if($asiento->save()){
             		$nroasiento=$asiento->idasiento;
             		//Detalle asiento para la contra parte del asiento "HABER"
             		$DeAsCTACTE=new Detalleasiento;
             		$DeAsCTACTE->haber=$_POST['Cobranza']['importe'];
             		$DeAsCTACTE->cuenta_idcuenta=11; //112100 deudores por venta
             		$DeAsCTACTE->asiento_idasiento=$nroasiento;
             		$DeAsCTACTE->cliente_idcliente=$cliente->idcliente;
             		//$DeAsCTACTE->iddetallecobranza =$validatedMembers[$a]['iddetallecobranza'];
             		if($DeAsCTACTE->save()){
             			$post=$_POST;
             			$this->nuevoElem($validatedMembers, $_POST['Cobranza']['fecha'], $nroasiento,$masterValues,$cliente);
		             	
             		}
             	}
             	
             	
             	
             	
//para  sumar en el haber de cta cte del cliente----------
			$idctactecliente=$model->ctactecliente_idctactecliente;
			$importeDetalle=$_POST['Cobranza']['importe'];
			$this->incrementoCtacte($idctactecliente, $importeDetalle);
			
//para generar el modelo de detallectactecliente que corresponde a la nueva cobranza
			$cliente=$this->idCliente($model->ctactecliente_idctactecliente);
			$modelDeCCcliente= new Detallectactecliente;
           	$modelDeCCcliente->fecha=$_POST['Cobranza']['fecha'];
           	$modelDeCCcliente->descripcion="COBRANZA Nro:".$model->idcobranza."";
           	$modelDeCCcliente->tipo= 1; //tipo cobranza
           	$modelDeCCcliente->iddocumento=$model->idcobranza;
           	$modelDeCCcliente->haber=$model->importe;
           	$modelDeCCcliente->ctactecliente_idctactecliente=$model->ctactecliente_idctactecliente;
           	$modelDeCCcliente->cobranza_idcobranza=$model->idcobranza;
           	$modelDeCCcliente->save();
           	
           	Yii::app()->user->setFlash('success', "<strong>Cobranza creada correctamente.</strong>");
			$this->redirect(array('admin'));			
            
			//$this->redirect(array('view','id'=>$model->idcobranza));
             }
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'member'=>$member,
        	'validatedMembers' => $validatedMembers,
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
		
		 $member = new Detallecobranza;
		 
    	 $validatedMembers = array(); //ensure an empty array
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Cobranza'])) {
			$model->attributes=$_POST['Cobranza'];
			
		//elementos ya guardados y que pueden ser modificados	
			if (isset($_POST['Detallecobranza']['pk__'])){
				$cantidadElementos=count($_POST['Detallecobranza']['pk__']); 
				
				for($i=0;$i<$cantidadElementos;$i++){
				
					$iddetalle_nuevo=$_POST['Detallecobranza']['pk__'][$i]['iddetallecobranza'];
					$cliente=$this->idCliente($model->ctactecliente_idctactecliente);
					
					$DC_trabajo=Detallecobranza::model()->findByPk($iddetalle_nuevo);
					if (isset($_POST['Detallecobranza']['u__'][$i]['tipocobranza'])){
											
						//datos nuevos traidos por POST
						$itemUpdate[$i]['totalcobranza']=$_POST['Cobranza']['importe'];
						$itemUpdate[$i]['iddetallecobranza']=$iddetalle_nuevo;
						$itemUpdate[$i]['tipocobranza']=$_POST['Detallecobranza']['u__'][$i]['tipocobranza'];
						$itemUpdate[$i]['transbanco']=$_POST['Detallecobranza']['u__'][$i]['transferenciabanco'];
						$itemUpdate[$i]['banco']=$_POST['Detallecobranza']['u__'][$i]['chequebanco'];
						$itemUpdate[$i]['fecha']=$_POST['Cobranza']['fecha'];//ej 10/07/2014
						$itemUpdate[$i]['fechaingreso']=$_POST['Detallecobranza']['u__'][$i]['chequefechaingreso'];
						$itemUpdate[$i]['fechacobro']=$_POST['Detallecobranza']['u__'][$i]['chequefechacobro'];
						$itemUpdate[$i]['titular']=$_POST['Detallecobranza']['u__'][$i]['chequetitular'];
						$itemUpdate[$i]['cuittitular']=$_POST['Detallecobranza']['u__'][$i]['chequecuittitular'];
						$itemUpdate[$i]['chequenumero']=$_POST['Detallecobranza']['u__'][$i]['nrocheque'];
						$itemUpdate[$i]['importe']=doubleval($_POST['Detallecobranza']['u__'][$i]['importe']);
						$itemUpdate[$i]['nombrecliente']=$cliente[0]['nombrecliente'];
						$itemUpdate[$i]['idcliente']=$cliente[0]['idcliente'];
						$itemUpdate[$i]['idcobranza']=$DC_trabajo->cobranza_idcobranza;
						$itemUpdate[$i]['caja_idcaja']=$_POST['Detallecobranza']['u__'][$i]['caja_idcaja'];
						$itemUpdate[$i]['iibbnrocomp']=$_POST['Detallecobranza']['u__'][$i]['iibbnrocomp'];
						$itemUpdate[$i]['iibbfecha']=$_POST['Detallecobranza']['u__'][$i]['iibbfecha'];
						$itemUpdate[$i]['iibbcomprelac']=$_POST['Detallecobranza']['u__'][$i]['iibbcomprelac'];
						$itemUpdate[$i]['iibbtasa']=$_POST['Detallecobranza']['u__'][$i]['iibbtasa'];

						//Datos del detalle ya guardado-----------------------------------
						
						$datos[$i]['iddetallecobranza']=$DC_trabajo->iddetallecobranza;
						$datos[$i]['idcobranza']=$DC_trabajo->cobranza_idcobranza;
						$datos[$i]['tipocobranza']=$DC_trabajo->tipocobranza;
						$datos[$i]['nombrecliente']=$cliente[0]['nombrecliente'];
						$datos[$i]['fecha']=$model->fecha;  //ej 2014/07/10
						
						$datos[$i]['importe']=doubleval($DC_trabajo->importe);
						$datos[$i]['chequenumero']=$DC_trabajo->nrocheque;
						$datos[$i]['fechaingreso']=$DC_trabajo->chequefechaingreso;
						$datos[$i]['fechacobro']=$DC_trabajo->chequefechaingreso;
						
						$datos[$i]['titular']=$DC_trabajo->chequetitular;
						$datos[$i]['cuittitular']=$DC_trabajo->chequecuittitular;
						$datos[$i]['banco']=$DC_trabajo->chequebanco;
						$datos[$i]['idcliente']=$cliente[0]['idcliente'];
						$datos[$i]['transbanco']=$DC_trabajo->transferenciabanco;
						$datos[$i]['caja_idcaja']=$DC_trabajo->caja_idcaja;
						$datos[$i]['iibbnrocomp']=$DC_trabajo->iibbnrocomp;
						$datos[$i]['iibbfecha']=$DC_trabajo->iibbfecha;
						$datos[$i]['iibbcomprelac']=$DC_trabajo->iibbcomprelac;
						$datos[$i]['iibbtasa']=$DC_trabajo->iibbtasa;
						
					} else {
						//elementos borrados
						$elem_borrados_DCob[$i]['iddetallecobranza']=$iddetalle_nuevo;
						$elem_borrados_DCob[$i]['idcobranza']=$DC_trabajo->cobranza_idcobranza;
						$elem_borrados_DCob[$i]['totalcobranza']=$_POST['Cobranza']['importe'];
						$elem_borrados_DCob[$i]['tipocobranza']=$DC_trabajo->tipocobranza;
						$elem_borrados_DCob[$i]['nombrecliente']=$cliente[0]['nombrecliente'];
						//$fecha = DateTime::createFromFormat('d/m/Y', $model->fecha);
						$elem_borrados_DCob[$i]['fecha']=$model->fecha;
						$elem_borrados_DCob[$i]['importe']=doubleval($DC_trabajo->importe);
						$elem_borrados_DCob[$i]['chequenumero']=$DC_trabajo->nrocheque;
						$elem_borrados_DCob[$i]['fechaingreso']=$DC_trabajo->chequefechaingreso;
						$elem_borrados_DCob[$i]['fechacobro']=$DC_trabajo->chequefechacobro;
						$elem_borrados_DCob[$i]['titular']=$DC_trabajo->chequetitular;
						$elem_borrados_DCob[$i]['cuittitular']=$DC_trabajo->chequecuittitular;
						$elem_borrados_DCob[$i]['banco']=$DC_trabajo->chequebanco;
						$elem_borrados_DCob[$i]['idcliente']=$cliente[0]['idcliente'];
						$elem_borrados_DCob[$i]['transbanco']=$DC_trabajo->transferenciabanco;
						$elem_borrados_DCob[$i]['fecha2']=$model->fecha;
					}
				}
			}
			
			
			 
                
				$masterValues = array ('cobranza_idcobranza'=>$model->idcobranza);
				//para comprobar si el importe ha sido modificado
				$llave=null;
				$cobranzaguardada=Cobranza::model()->findByPk($model->idcobranza);//modelo cobranza guardado
				if($cobranzaguardada->importe != $_POST['Cobranza']['importe']){
					$llave=$cobranzaguardada->importe;
				}
			if( //Save the master model after saving valid members
            MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues) &&
            $model->save()
           ){
          
           	//print_r($validatedMembers);echo "<br>";//print_r($deleteMembers);echo "<br>"; die();
           	// se verifica si se ha modificado el importe de la cobranza
                   
           	if($llave != null){
           		$importeviejo=$llave;
           		$importenuevo=$model->importe;
           		$idctacte=$model->ctactecliente_idctactecliente;
           		$this->modificarImporteCtaCte($importeviejo, $importenuevo, $idctacte);
           		$this->modImpDetalleCtacte($idctacte, $id, $importenuevo);
           	}
           	
          //Si se ha modificado un detalle de cobranza..
          	if(isset($itemUpdate) && isset($datos)){
          		
          		foreach ($itemUpdate as $key_uno=>$valor_uno){
          			foreach($valor_uno as $key_dos=>$valor_dos){
          				if($key_dos == "tipocobranza"){
          					//para cambiar importe asiento y detalle asiento 11
          					$this->cambioAsiento($valor_uno);
          					//compara si el tipo de cobranza se ha modificado o no en un item
          					if($valor_dos != $datos[$key_uno]['tipocobranza']){
          						$tipoguardado=$datos[$key_uno]['tipocobranza'];
          						$this->cambioTipoBorrado($tipoguardado, $datos[$key_uno]);
          						$this->resetDetalle($datos[$key_uno]['iddetallecobranza']);
          						$this->cambioTipoNuevoDetalle($valor_uno);
          						//echo $valor_uno['iddetallecobranza'];die();
          						$this->cambioDetalleAsiento($tipoguardado, $valor_uno);
          					
          					} else { // cuando el tipo de cobranza se mantuvo
          						       						 
          						$this->modUpdateItemsDetAsiento($datos[$key_uno], $valor_uno);
          					}
          				}
          			}
          		}
          		
          	}
          	
          	//si existe un elemento detallecobranza borrado 
          	if(isset($elem_borrados_DCob)){
          		
          		foreach($elem_borrados_DCob as $keyBorr_uno=>$valorBorr_uno){
          			foreach ($valorBorr_uno as $keyborr_dos=>$valorborr_dos){
          				$this->cambioAsiento($valorBorr_uno);
          				if($keyborr_dos == "tipocobranza"){
          					
          					$tipoguardadoBorr=$valorborr_dos;
          					$this->cambioTipoBorrado($tipoguardadoBorr, $valorBorr_uno);
          				}
          				if($keyborr_dos== "iddetallecobranza"){
          					$this->borradoDetAsiento($valorborr_dos);
          				}
          			}
          		}
          	
          	}
           
           	//para el caso de elementos nuevos despues de actualizar la cobranza
           
				
					$asiento=Asiento::model()->find("cobranza_idcobranza=:id",
					array(':id'=>$id));
					$cliente=Cliente::model()->find("ctactecliente_idctactecliente=:idctacte",
             		array(":idctacte"=>$_POST['Cobranza']['ctactecliente_idctactecliente']));
					$this->nuevoElem($validatedMembers, $_POST['Cobranza']['fecha'], $asiento->idasiento, $masterValues, $cliente);
				
				
	
			
          		Yii::app()->user->setFlash('success', "<strong>Cobranza actualizada correctamente.</strong>");
				$this->redirect(array('admin'));
				//$this->redirect(array('view','id'=>$model->idcobranza));
           }
		}
		
		$this->render('update',array(
			'model'=>$model,
			'member'=>$member,
        	'validatedMembers'=>$validatedMembers,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//if (Yii::app()->request->isPostRequest) {
			$cobranza=$this->loadModel($id);
			$Detalle=Detallecobranza::model()->findAll('cobranza_idcobranza=:cobranza_idcobranza', array(':cobranza_idcobranza'=>$id));
			//print_r($Detallecobraza);die();
			$cliente=$this->idCliente($cobranza->ctactecliente_idctactecliente); 
			$llaveChek=null;
			
			for($i=0;$i < count($Detalle);$i++){
				$tipo=$Detalle[$i]['tipocobranza'];
				$datos[$i]['tipo']=$tipo;
				$datos[$i]['idcobranza']=$id;
				$datos[$i]['nombrecliente']=$cliente[0]['nombrecliente'];
				$fecha = DateTime::createFromFormat('d/m/Y', $cobranza->fecha);
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
				$datos[$i]['iddetallecobranza']=$Detalle[$i]['iddetallecobranza'];
				$datos[$i]['titular']=$Detalle[$i]['chequetitular'];
				$datos[$i]['cuittitular']=$Detalle[$i]['chequecuittitular'];
				$datos[$i]['banco']=$Detalle[$i]['chequebanco'];
				$datos[$i]['idcliente']=$cliente[0]['idcliente'];
				$datos[$i]['transbanco']=$Detalle[$i]['transferenciabanco'];
				//$this->cambioTipoBorrado($tipo, $datos[$i]);
				if($tipo == 1){
				$chek=$this->checkChequeBorrado($Detalle[$i]['iddetallecobranza']);
				if($chek[0]['cant'] != 0 ){
					$llaveChek="si";
					} 
				}
			}
			if($llaveChek == null){
				for($i=0;$i < count($Detalle);$i++){
					$this->cambioTipoBorrado($datos[$i]['tipo'], $datos[$i]);
				}
			}elseif ($llaveChek=="si"){
                   throw new CHttpException(400, "Advertencia: Cheque de cobranza relacionado con una Orden de pago.");
                }
			$this->decrementarCtacteDelete($cobranza->ctactecliente_idctactecliente, $cobranza->importe);
			$this->borrarDetCtaCte($cobranza->idcobranza, $cobranza->importe, $cobranza->ctactecliente_idctactecliente);
			
			// we only allow deletion via POST request
			$Asiento=Asiento::model()->find("cobranza_idcobranza=:id",
					array(':id'=>$id));
			if($Asiento->delete()){
			$this->loadModel($id)->delete();
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			/*if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}*/
		/*} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}*/
		
	}
	public function checkChequeBorrado($id){
		$sqlidcheque="SELECT COUNT(*) as cant FROM cheque 
					  WHERE id_trabajo_cobranza=".$id." 
					  		AND id_trabajo_ordendepago<>null;";
		$dbCommand = Yii::app()->db->createCommand($sqlidcheque);
		$resultado = $dbCommand->queryAll();
		return $resultado;
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Cobranza');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cobranza('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cobranza'])) {
			$model->attributes=$_GET['Cobranza'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cobranza the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cobranza::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cobranza $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='cobranza-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function nuevoMovCaja($datos){
		
							
		$modelmovcaja=new Movimientocaja;
		$modelmovcaja->descripcion= "Cobranza N°".(string)$datos['idcobranza']." - ".(string)$datos['nombrecliente']."-";
		$modelmovcaja->fecha=$datos['fecha'];
		$modelmovcaja->debeohaber=0;
		$modelmovcaja->caja_idcaja=$datos['caja_idcaja'];
		$modelmovcaja->debe=$datos['importe'];
		$modelmovcaja->iddetallecobranza=$datos['iddetallecobranza'];
		$modelmovcaja->save();
			}
	public function nuevoCheque($datos){
		
		
		$modelCheque= new Cheque;
		$modelCheque->nrocheque=$datos['chequenumero'];
		//$modelCheque->concepto="Cobranza Nro.: ".(string)$datos['idcobranza']."-".(string)$datos['nombrecliente']."-";
		$modelCheque->fechaingreso=$datos['fechaingreso'];
		$modelCheque->fechacobro=$datos['fechacobro'];
		$modelCheque->titular=$datos['titular'];
		$modelCheque->cuittitular=$datos['cuittitular'];
		$modelCheque->debe=$datos['importe'];
		$modelCheque->debeohaber=0;
		$modelCheque->Banco_idBanco=$datos['banco'];
		$modelCheque->cliente_idcliente=$datos['idcliente'];
		$modelCheque->estado=2;
		$modelCheque->iddetallecobranza=$datos['iddetallecobranza'];
		$modelCheque->save();
		
	}
	public function nuevaTransf($datos){
		
		$modelTransf= new Movimientobanco;
		$modelTransf->descripcion="Cobranza Nro.: ".(string)$datos['idcobranza']."-".(string)$datos['nombrecliente']."-";
		$modelTransf->fecha=$datos['fecha'];
		$modelTransf->debeohaber=0;
		$modelTransf->debe=$datos['importe'];
		//$modelTransf->rubro_idrubro=5;
		$modelTransf->ctabancaria_idctabancaria=$datos['transbanco'];
		
		$modelTransf->id_de_trabajo=$datos['iddetallecobranza']; //para identificar el detalle
		$modelTransf->save();
		
	}
	public function nuevoIIBB($datos){
		$modelIIBB=new Retencioniibb;
		$modelIIBB->nrocomprobante=$datos['iibbnrocomp'];
		$modelIIBB->fecha=$datos['fecha'];
		$modelIIBB->cliente_idcliente=$datos['idcliente'];
		$modelIIBB->comp_relacionado=$datos['iibbcomprelac'];
		$modelIIBB->tasa=$datos['iibbtasa'];
		$modelIIBB->importe=$datos['importe'];
		$modelIIBB->detallecobranza_iddetallecobranza=$datos['iddetallecobranza'];
		$modelIIBB->save();
	}
	public function idCliente($idctacte){
		$sql="SELECT cliente.idcliente as idcliente, cliente.nombre AS nombrecliente  FROM cliente,ctactecliente,cobranza 
				WHERE cliente.idcliente =ctactecliente.cliente_idcliente and  ctactecliente.idctactecliente = ".$idctacte." LIMIT 1;";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$resultado = $dbCommand->queryAll();
			//$nombrecliente=$resultado[0]['nombrecliente'];
		
		return $resultado;
	}
	public function fechadmY($dato){
		$fechaingreso = DateTime::createFromFormat('Y-m-d', $dato);
	return $fechaingreso->format('d/m/Y');
	}
	public function fechaYmd($dato){
		$fechaingreso = DateTime::createFromFormat('d/m/Y', $dato);
	return $fechaingreso->format('Y-m-d');
	}
 	public function nuevoElem($validatedMembers,$fecha,$nroasiento,$masterValues,$cliente){
 		// Contraparte del asiento "DEBE"
             $cantElm=count($validatedMembers);
             for($a=0;$a<$cantElm;$a++){
             	 $Deta=Detalleasiento::model()->find("iddetallecobranza=:id",array(':id'=>$validatedMembers[$a]['iddetallecobranza']));
	             if($validatedMembers[$a]['tipocobranza'] == 0 && (!isset($Deta))){ //efectivo
		             $MovCaja=new Movimientocaja;
		             $MovCaja->descripcion="Entrega de Cobranza N°".$masterValues['cobranza_idcobranza']." ".$cliente->nombre;
		             $MovCaja->fecha=$fecha;
		             $MovCaja->debeohaber=0;
		             $MovCaja->debe=$validatedMembers[$a]['importe'];
		             $MovCaja->iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
		             $MovCaja->cuenta_idcuenta=11;
		             $MovCaja->caja_idcaja=$validatedMembers[$a]['caja_idcaja'];
		             if($MovCaja->save()){
			             $DeAsCaja=new Detalleasiento;
			             $DeAsCaja->debe=$validatedMembers[$a]['importe'];
			             $cuentaCAJA=Caja::model()->findByPk($validatedMembers[$a]['caja_idcaja']);
			             $DeAsCaja->cuenta_idcuenta=$cuentaCAJA->cuenta_idcuenta;
			             $DeAsCaja->asiento_idasiento=$nroasiento;
			             $DeAsCaja->iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
			             $DeAsCaja->save();
			             }
		             //print_r($MovCaja->getErrors());die();
	             } elseif($validatedMembers[$a]['tipocobranza'] == 1 && (!isset($Deta))){ //cheque
		             //Nuevo cheque
		             $Cheque=new Cheque;
		             $Cheque->nrocheque=$validatedMembers[$a]['nrocheque'];
		             $Cheque->titular=$validatedMembers[$a]['chequetitular'];
		             $Cheque->cuittitular=$validatedMembers[$a]['chequecuittitular'];
		             $Cheque->fechaingreso=$this->fechadmY($validatedMembers[$a]['chequefechaingreso']);
		             $Cheque->fechacobro=$this->fechadmY($validatedMembers[$a]['chequefechacobro']);
		             $Cheque->debe=$validatedMembers[$a]['importe'];
		             $Cheque->debeohaber=0;
		             $Cheque->Banco_idBanco=$validatedMembers[$a]['chequebanco'];
		             $Cheque->estado=2;// estado a cobrar
		             $Cheque->cliente_idcliente=$cliente->idcliente;
		             $Cheque->iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
		             if($Cheque->save()){
			             $DeAsCheque=new Detalleasiento;
			             $DeAsCheque->debe=$validatedMembers[$a]['importe'];
			             $DeAsCheque->cuenta_idcuenta=5; //cuenta cheque de 3ros a cobrar
			             $DeAsCheque->asiento_idasiento=$nroasiento;
			             $DeAsCheque->iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
			             $DeAsCheque->save();
	             	}
	             
	             } elseif($validatedMembers[$a]['tipocobranza'] == 2 && (!isset($Deta))){ //cheque
		             // Nuevo movimientobanco
		             $MovBanco=new Movimientobanco;
		             $MovBanco->descripcion="Entrega de Cobranza N°".$masterValues['cobranza_idcobranza']." ".$cliente->nombre;
		             $MovBanco->fecha=$fecha;
		             $MovBanco->debeohaber=0;
		             $MovBanco->debe=$validatedMembers[$a]['importe'];
		             $MovBanco->ctabancaria_idctabancaria=$validatedMembers[$a]['transferenciabanco'];
		             $MovBanco->cuenta_idcuenta=5;
		             $MovBanco->id_de_trabajo=$validatedMembers[$a]['iddetallecobranza'];
		             if($MovBanco->save()){
			             $cuentaCtabancaria=Ctabancaria::model()->findByPk($validatedMembers[$a]['transferenciabanco']);
			             $DeAsTrasfer=new Detalleasiento;
			             $DeAsTrasfer->debe=$validatedMembers[$a]['importe'];
			             $DeAsTrasfer->cuenta_idcuenta=$cuentaCtabancaria->cuenta_idcuenta;
			             $DeAsTrasfer->asiento_idasiento=$nroasiento;
			             $DeAsTrasfer->iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
			             $DeAsTrasfer->save();
		             }
	             
	             } elseif($validatedMembers[$a]['tipocobranza'] == 3 && (!isset($Deta))
	             ){ //IIBB
	              //nuevo comprobante de retención de IIBB
		              $MovIIBB=new Retencioniibb;
		              $MovIIBB->nrocomprobante=$validatedMembers[$a]['iibbnrocomp'];
		              $MovIIBB->cliente_idcliente=$cliente->idcliente;
		              $MovIIBB->fecha=$fecha;
		              $MovIIBB->comp_relacionado=$validatedMembers[$a]['iibbcomprelac'];
		              $MovIIBB->importe=$validatedMembers[$a]['importe'];
		              $MovIIBB->tasa=$validatedMembers[$a]['iibbtasa'];
		              $MovIIBB->detallecobranza_iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
		              if($MovIIBB->save()){
			              $DeAsIIBB=new Detalleasiento;
			              $DeAsIIBB->debe=$validatedMembers[$a]['importe'];
			              $DeAsIIBB->cuenta_idcuenta=20;// cuenta 113700 Ret. Imp. Ingresos Brutos
			              $DeAsIIBB->asiento_idasiento=$nroasiento;
			              $DeAsIIBB->iddetallecobranza=$validatedMembers[$a]['iddetallecobranza'];
			              $DeAsIIBB->save();
		              }
	              
	             }
             } //for
 	}
	public function cambioTipoBorrado($tipoguardado,$datos){
   		switch ($tipoguardado){
   			case 0 :
   				//$this->resetDetalle($datos['iddetallecobranza']);			
   				$commandmovi= Yii::app()->db->createCommand();
				$commandmovi->delete('movimientocaja','iddetallecobranza=:id',
								array(
								':id'=>$datos['iddetallecobranza']
   								)
								);
				
   				
   			case 1 :
   				//$this->resetDetalle($datos['iddetallecobranza']);	
   				$commandmovi= Yii::app()->db->createCommand();
   				$commandmovi->delete('cheque','iddetallecobranza=:id',
								array(
								':id'=>$datos['iddetallecobranza']
   								)
								);
				
   				break;
   			case 2 :
   				//$this->resetDetalle($datos['iddetallecobranza']);	
   				$commandmovi= Yii::app()->db->createCommand();
   				$commandmovi->delete('movimientobanco','id_de_trabajo=:id',
								array(
								':id'=>$datos['iddetallecobranza']
   								)
								);
				
   				break;
   			case 3 :
   				//$this->resetDetalle($datos['iddetallecobranza']);	
   				$RetIIB=Retencioniibb::model()->find("detallecobranza_iddetallecobranza=:id",
   									array(':id'=>$datos['iddetallecobranza']));
				$RetIIB->delete();   									
   				break;
   		}
   	}
	public function cambioTipoNuevoDetalle($datos){
		
		$datos['tipocobranza']= (int)$datos['tipocobranza'];
		switch ($datos['tipocobranza']){
			case 0:
				$this->nuevoMovCaja($datos);
				
				break;
			case 1:
				/*
				$fechaingreso= DateTime::createFromFormat('Y-m-d', $datos['fechaingreso']);
				$datos['fechaingreso']=$fechaingreso->format('d/m/Y');
				$fechacobro= DateTime::createFromFormat('Y-m-d', $datos['fechacobro']);
				$datos['fechacobro']=$fechacobro->format('d/m/Y'); */
				$this->nuevoCheque($datos);
				break;
			case 2:
				
				$this->nuevaTransf($datos);
				break;
			case 3:
				
				$this->nuevoIIBB($datos);
				break;
		}
	}
	public function modUpdateItemsDetAsiento($datosviejos, $nuevosdatos){
		
		$datosviejos['tipocobranza']=(int)$datosviejos['tipocobranza'];
		//detalle asiento relacionado al detallecobranza
		$DeAs=Detalleasiento::model()->find("iddetallecobranza=:id",
				array(':id'=>$datosviejos['iddetallecobranza']));
		switch ($datosviejos['tipocobranza']){
			
			case 0:  // para un detalle del tipo efectivo
				$MovCaja=Movimientocaja::model()->find("iddetallecobranza=:id",
						array(':id'=>$datosviejos['iddetallecobranza']));
				$MovCaja->debe=$nuevosdatos['importe'];
				$MovCaja->caja_idcaja=$nuevosdatos['caja_idcaja'];
				$MovCaja->update();
				$DeAs->debe=$nuevosdatos['importe'];
				$DeAs->cuenta_idcuenta=$MovCaja->cajaIdcaja->cuenta_idcuenta;
				$DeAs->update();
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
					
					$cheque=Cheque::model()->find("iddetallecobranza=:id",
							array(':id'=>$datosviejos['iddetallecobranza']));
					$cheque->nrocheque=$nuevosdatos['chequenumero'];
					$cheque->fechaingreso=$nuevosdatos['fechaingreso'];
					$cheque->fechacobro=$nuevosdatos['fechacobro'];
					$cheque->titular=$nuevosdatos['titular'];
					$cheque->cuittitular=$nuevosdatos['cuittitular'];
					$cheque->debe=$nuevosdatos['importe'];
					$cheque->Banco_idBanco=$nuevosdatos['banco'];
					$cheque->update();
					
					$DeAs->debe=$nuevosdatos['importe'];
					$DeAs->update();
									 
				    }	
				break;
			
			case 2: //para un detalle tipo transaccion
				if(	($datosviejos['transbanco'] != $nuevosdatos['transbanco']) || 
					($datosviejos['importe'] != $nuevosdatos['importe']))
					{
						$trans=Movimientobanco::model()->find("id_de_trabajo=:id",
								array(':id'=>$datosviejos['iddetallecobranza']));
						$trans->debe=$nuevosdatos['importe'];
						$trans->ctabancaria_idctabancaria=$nuevosdatos['transbanco'];
						$trans->update();	
						
						$DeAs->debe=$nuevosdatos['importe'];
						$CtaBancaria=Ctabancaria::model()->findByPk($nuevosdatos['transbanco']);
						$DeAs->cuenta_idcuenta=$CtaBancaria->cuenta_idcuenta;
						$DeAs->update();
					}
			break;
			
			case 3: //para IIBB
				$MovIIBB=Retencioniibb::model()->find("detallecobranza_iddetallecobranza=:id",
						array(':id'=>$datosviejos['iddetallecobranza']));
						
				if(	($datosviejos['iibbnrocomp'] != $nuevosdatos['iibbnrocomp']) || 
					($datosviejos['iibbfecha'] != $nuevosdatos['iibbfecha']) ||
					($datosviejos['iibbcomprelac'] != $nuevosdatos['iibbcomprelac']) ||
					($datosviejos['iibbtasa'] != $nuevosdatos['iibbtasa']) ||
					($datosviejos['importe'] != $nuevosdatos['importe']) ) 	{
						
						$MovIIBB->iibbnrocomp=$nuevosdatos['iibbnrocomp'];
						$MovIIBB->iibbfecha=$nuevosdatos['iibbfecha'];
						$MovIIBB->iibbcomprelac=$nuevosdatos['iibbcomprelac'];
						$MovIIBB->iibbtasa=$nuevosdatos['iibbtasa'];
						$MovIIBB->importe=$nuevosdatos['importe'];
						$MovIIBB->save();
						$DeAs->debe=$nuevosdatos['importe'];
						$DeAs->update();
					}
			break;		
			}
		}
	
	public function incrementoCtacte($idctacte,$importe){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctactecliente', array(
				    'ctactecliente.haber'=>new CDbExpression('ctactecliente.haber + '.$importe),
				), 'idctactecliente='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
 	public function modificarImporteCtaCte($impviejo,$impnuevo,$idctacte){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctactecliente', array(
				    'ctactecliente.haber'=>new CDbExpression('ctactecliente.haber - '.$impviejo.' + '.$impnuevo),
				), 'idctactecliente='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
 	public function decrementarCtacteDelete($idctacte, $importe){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctactecliente', array(
				    'ctactecliente.haber'=>new CDbExpression('ctactecliente.haber - '.$importe),
				), 'idctactecliente='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
 	public function updateSaldoCtaCte($idctacte){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctactecliente', array(
				    'ctactecliente.saldo'=>new CDbExpression('ROUND(ctactecliente.debe - ctactecliente.haber,2)'),
				), 'idctactecliente='.$idctacte);
 	}
	
	public function borrarDetCtaCte($idcobranza,$importe,$idctacte){
 			$commandmovi= Yii::app()->db->createCommand();
			$commandmovi->delete('detallectactecliente',
						'iddocumento=:iddocument AND haber=:haber AND
						 ctactecliente_idctactecliente=:idctactecliente',
						array(':iddocument'=>$idcobranza,
							  ':haber'=>$importe,
							  ':idctactecliente'=>$idctacte));
 	}
	public function gridNombreCliente($data,$row){
		$sql="SELECT cliente.nombre AS nombre
				FROM cliente, ctactecliente, cobranza
				WHERE cliente.idcliente = ctactecliente.cliente_idcliente
				AND ctactecliente.idctactecliente =".$data->ctactecliente_idctactecliente." 
				LIMIT 1;";
		
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$resultado = $dbCommand->queryAll();
		$nombre=$resultado[0]['nombre'];
		
		return $nombre;
	}
	public function modImpDetalleCtacte($idctacte,$idcobranza,$impnuevo){
		$command = Yii::app()->db->createCommand();
		$command->update('detallectactecliente', array(
				    'detallectactecliente.haber'=>new CDbExpression($impnuevo),
				), 'iddocumento='.$idcobranza.' AND ctactecliente_idctactecliente='.$idctacte);
	}
	
	public function cambioDetalleAsiento($tipoguardado, $nuevo){
		
		$DeAsiento=Detalleasiento::model()->find("iddetallecobranza=:id", 
					array(':id'=>$nuevo['iddetallecobranza']));
		//print_r($nuevo);die();
		switch ($nuevo['tipocobranza']) {
			case 0:
				$cuentacaja= Caja::model()->findByPk($nuevo['caja_idcaja']);
				$DeAsiento->cuenta_idcuenta=$cuentacaja->cuenta_idcuenta;
				$DeAsiento->debe=$nuevo['importe'];
				$DeAsiento->save();
			break;
			case 1:
				$DeAsiento->cuenta_idcuenta=5; //cheque 3ros
				$DeAsiento->debe=$nuevo['importe'];
				$DeAsiento->save();
			break;
			case 2:
				$ctabancaria=Ctabancaria::model()->findByPk($nuevo['transbanco']);
				$DeAsiento->cuenta_idcuenta=$ctabancaria->cuenta_idcuenta; //cheque 3ros
				$DeAsiento->debe=$nuevo['importe'];
				$DeAsiento->save();
			break;
			case 3:
				$DeAsiento->cuenta_idcuenta = 20;// cuenta 113700 Ret. Imp. Ingresos Brutos
				$DeAsieto->debe=$nuevo['importe'];
				$DeAsiento->save();
			break;
		}
		
	}
	public function borradoDetAsiento($borrado){
		$DeAs=Detalleasiento::model()->find("iddetallecobranza=:id",
			array(':id'=>$borrado));
		$DeAs->delete();
	}
	
	public function cambioAsiento($nuevo){
		$Asiento=Asiento::model()->find("cobranza_idcobranza=:id",
					array(':id'=>$nuevo['idcobranza']));
		$DeAs=Detalleasiento::model()->find("asiento_idasiento=:idasiento AND cuenta_idcuenta=:cuenta",
						array(':idasiento'=>$Asiento->idasiento,
							  ':cuenta'=>11));
		$DeAs->haber=$nuevo['totalcobranza'];
		$DeAs->save();
		$Asiento->fecha=$nuevo['fecha'];
		$Asiento->save();
	}
	
	
	
	
	
	public function actionExcel(){
                $mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $model=new Cobranza('search');
                	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->Search($model->fecha=$anio_tab.'-'.$mes_tab),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Cobranzas ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Cobranzas ' . date('m-d-Y H-i'),
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
				    		'header'=>'FECHA',
							'name'=>'fecha',
						),
						array(
				    		'header'=>'DESCRIPCION',
							'name'=>'descripcioncobranza',
						),
						array(
							'header'=>'IMPORTE',
							'value' => 'number_format($data->importe, 2, ",", ".")',
						),
						array(
				    		'header'=>'CLIENTE',
							'name'=>'ctactecliente_idctactecliente',
							'value'=>array($this,'gridNombreCliente'),
						),
					) 
				)); 
               
        	
	}
	public function resetDetalle($iddetalle){
		$detalle=Detallecobranza::model()->findByPk($iddetalle);
		$detalle->transferenciabanco=null;
		$detalle->chequefechacobro=null;
		$detalle->chequefechaingreso=null;
		$detalle->chequetitular=null;
		$detalle->chequecuittitular=null;
		$detalle->nrocheque=null;
		$detalle->chequebanco=null;
		$detalle->caja_idcaja=null;
		$detalle->iibbnrocomp=null;
		$detalle->iibbfecha=null;
		$detalle->iibbcomprelac=null;
		$detalle->iibbtasa=null;
		$detalle->save();
	}
}