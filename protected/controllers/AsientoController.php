<?php

class AsientoController extends Controller
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
				'actions'=>array('index','view','grilla'),
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

		$model=new Asiento;
		 $member = new Detalleasiento;
        $validatedMembers = array();  //ensure an empty array

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Asiento'])) {
			$model->attributes=$_POST['Asiento'];
			$model->validate('totaldebe,totalhaber');

			if( //validate detail before saving the master
                MultiModelForm::validate($member,$validatedMembers,$deleteItems) &&
                $model->save()
               )
           //  print_r($validateMembers);die();
               {
                 //the value for the foreign key 'groupid'
                 $masterValues = array ('asiento_idasiento'=>$model->idasiento);
                 if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
                 
                 $this->nuevosMovCajaBanco($validatedMembers, $masterValues, $_POST['Asiento']['fecha']);
				$this->redirect(array('admin','id'=>$model->idasiento));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			//submit the member and validatedItems to the widget in the edit form
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

		$member = new Detalleasiento;
        $validatedMembers = array(); //ensure an empty array
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Asiento'])) {
			$model->attributes=$_POST['Asiento'];
			//the value for the foreign key 'groupid'
			
			
		//elementos ya guardados y que pueden ser modificados		
			if (isset($_POST['Detalleasiento']['pk__'])){
				$cantidadElementos=count($_POST['Detalleasiento']['pk__']); 
				for($i=0;$i<$cantidadElementos;$i++){
				
					$iddetalle=$_POST['Detalleasiento']['pk__'][$i]['iddetalleasiento'];
					$DA_trabajo=Detalleasiento::model()->findByPk($iddetalle);
					if (isset($_POST['Detalleasiento']['u__'][$i]['cuenta_idcuenta'])){
						//nuevos datos traidos por POST
						$nuevo[$i]['iddetalleasiento']=$iddetalle;
						//objeto guardado anteriormente
						$D_A=Detalleasiento::model()->findByPk($iddetalle);
						$viejo[$i]=$D_A;
					} else {	
						$borrado[$i]['iddetalleasiento']=$iddetalle;
						$borrado[$i]['cuenta_idcuenta']=$DA_trabajo->cuenta_idcuenta;
						$borrado[$i]['movimientocaja_idmovimientocaja']=$DA_trabajo->movimientocaja_idmovimientocaja;
						$borrado[$i]['movimientobanco_idmovimientobanco']=$DA_trabajo->movimientobanco_idmovimientobanco;
						$borrado[$i]['operacion_manual']=$DA_trabajo->operacion_manual;
						
					}
				}
			}
			
	          	
            $masterValues = array ('asiento_idasiento'=>$model->idasiento);

            if( //Save the master model after saving valid members
                MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues) &&
                $model->save()
               )
			
               if((isset($nuevo)) && (isset($viejo))){
               		$this->actualizarAsientoMovCajaBanco($viejo, $nuevo, $_POST['Asiento']['fecha'], $model);
               }
               
          		
               $this->cambioImporteCajaBanco($validatedMembers, $masterValues, $_POST['Asiento']['fecha']);
               $this->nuevosMovCajaBanco($validatedMembers, $masterValues, $_POST['Asiento']['fecha']);
			   
			//si existe un elemento detalleasiento borrado 
          		if(isset($borrado)){
	          		foreach($borrado as $keyBorr_uno=>$valorBorr_uno){
	          			
	          					$this->borradoMovCajaBanco($valorBorr_uno);
	          				
	          			}
	          		}
               $this->redirect(array('admin','id'=>$model->idasiento));

		}

		$this->render('update',array(
			'model'=>$model,
			//submit the member and validatedItems to the widget in the edit form
            'member'=>$member,
            'validatedMembers' => $validatedMembers,
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
			$this->loadModel($id)->delete();

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
		$model=new Asiento('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Asiento'])) {
			$model->attributes=$_GET['Asiento'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Asiento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Asiento::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}	

	/**
	 * Performs the AJAX validation.
	 * @param Asiento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='asiento-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionGrilla($id){
		$model=Detalleasiento::model()->findAll('asiento_idasiento=:id',array('id'=>$id));

		$this->renderPartial('gridasiento',array(
			'model'=>$model,
		));
	}
	public function nuevosMovCajaBanco($datos,$master,$fecha){
		
		$asiento=Asiento::model()->findByPk($master['asiento_idasiento']);
		$cant=count($datos);
		for($i=0;$i<$cant;$i++){
			
			$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
			
			if($DeT->operacion_manual == null ){
				$cuenta=$datos[$i]['cuenta_idcuenta'];
		//movimiento caja
			$caja=Caja::model()->find("cuenta_idcuenta=:id",array(':id'=>$cuenta));
			if(isset($caja->idcaja)){
				$MovCaja=new Movimientocaja;
				$MovCaja->descripcion="Asiento - '".$asiento->descripcion."'";
				$MovCaja->fecha=$fecha;
				if($datos[$i]['debe'] != null){
					$MovCaja->debeohaber=0;
					$MovCaja->debe=$datos[$i]['debe'];
				} else {
					$MovCaja->debeohaber=1;
					$MovCaja->haber=$datos[$i]['haber'];
				}
				$MovCaja->caja_idcaja=$caja->idcaja;
				//dato obligatorio, colo la cuenta de la misma caja, es redundante
				$MovCaja->cuenta_idcuenta=$caja->cuenta_idcuenta; 
				//$MovCaja->asiento_idasiento=$master['asiento_idasiento'];
				$MovCaja->desdeasiento=$master['asiento_idasiento'];
				$MovCaja->save();
				//print_r($MovCaja->getErrors());die();
				//$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
				$DeT->movimientocaja_idmovimientocaja=$MovCaja->idmovimientocaja;
				//para diferenciar la operación
				$DeT->operacion_manual="c".$MovCaja->idmovimientocaja;
				$DeT->save();
			}
			$ctabancaria=Ctabancaria::model()->find("cuenta_idcuenta=:id",array(':id'=>$cuenta));
			if(isset($ctabancaria->idctabancaria)){
				$MovBanco=new Movimientobanco;
				$MovBanco->descripcion="Asiento - '".$asiento->descripcion."'";
				$MovBanco->fecha=$fecha;
				if($datos[$i]['debe'] != null){
					$MovBanco->debeohaber=0;
					$MovBanco->debe=$datos[$i]['debe'];
				} else {
					$MovBanco->debeohaber=1;
					$MovBanco->haber=$datos[$i]['haber'];
				}
				$MovBanco->ctabancaria_idctabancaria=$ctabancaria->idctabancaria;
				//dato obligatorio, colo la cuenta de la misma caja, es redundante
				$MovBanco->cuenta_idcuenta=$ctabancaria->cuenta_idcuenta; 
				//$MovBanco->asiento_idasiento=$master['asiento_idasiento'];
				$MovBanco->desdeasiento=$master['asiento_idasiento'];
				$MovBanco->save();
				//$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
				$DeT->movimientobanco_idmovimientobanco=$MovBanco->idmovimientobanco;
				$DeT->operacion_manual="b".$MovBanco->idmovimientobanco;
				$DeT->save();
			} 
			
		}
	}
	}
	public function cambioImporteCajaBanco($datos,$master,$fecha){
		$asiento=Asiento::model()->findByPk($master['asiento_idasiento']);
		
		$cant=count($datos);
		for($i=0;$i<$cant;$i++){
			 $Deta=Detalleasiento::model()->find("iddetalleasiento=:id",array(':id'=>$datos[$i]['iddetalleasiento']));
			 if(isset($Deta)){
			 	if($Deta->operacion_manual != null){
			 		$operacio=$Deta->operacion_manual;
			 		if($Deta->movimientocaja_idmovimientocaja != null){
			 			$comp="c".$Deta->movimientocaja_idmovimientocaja;
			 			if($operacio == $comp){
			 				$MovCaja=Movimientocaja::model()->findByPk($Deta->movimientocaja_idmovimientocaja);
			 				$MovCaja->fecha=$asiento->fecha;
			 				$MovCaja->descripcion="Asiento - '".$asiento->descripcion."'";
			 				if(($MovCaja->debe != null) && ($Deta->debe != null) && ($Deta->debe != $MovCaja->debe)){
								$MovCaja->debe=$Deta->debe;
							} elseif(($MovCaja->debe == null) && ($Deta->debe != null)){
								$MovCaja->debeohaber=0;
								$MovCaja->haber=null;
								$MovCaja->debe=$Deta->debe;
							} elseif(($MovCaja->debe != null) && ($Deta->haber != null)){
								$MovCaja->debeohaber=1;
								$MovCaja->debe=null;
								$MovCaja->haber=$Deta->haber;
							}elseif(($MovCaja->haber != null) && ($Deta->haber != null) && ($Deta->haber != $MovCaja->haber)){
								$MovCaja->haber=$Deta->haber;
							}
							$MovCaja->fecha=$fecha;
							$MovCaja->save();
			 			}
			 		}
			 	if($Deta->movimientobanco_idmovimientobanco != null){
			 			$comp="b".$Deta->movimientobanco_idmovimientobanco;
			 			if($operacio == $comp){
			 				$MovBanco=Movimientobanco::model()->findByPk($Deta->movimientobanco_idmovimientobanco);
			 				$MovBanco->fecha=$asiento->fecha;
			 				$MovBanco->descripcion="Asiento - '".$asiento->descripcion."'";
			 				if(($MovBanco->debe != null) && ($Deta->debe != null) && ($Deta->debe != $MovBanco->debe)){
								$MovBanco->debe=$Deta->debe;
							} elseif(($MovBanco->debe == null) && ($Deta->debe != null)){
								$MovBanco->debeohaber=0;
								$MovBanco->haber=null;
								$MovBanco->debe=$Deta->debe;
							} elseif(($MovBanco->debe != null) && ($Deta->haber != null)){
								$MovBanco->debeohaber=1;
								$MovBanco->debe=null;
								$MovBanco->haber=$Deta->haber;
							}elseif(($MovBanco->haber != null) && ($Deta->haber != null) && ($Deta->haber != $MovBanco->haber)){
								$MovBanco->haber=$Deta->haber;
							}
							$MovBanco->fecha=$fecha;
							$MovBanco->save();
			 			}
			 		}
			 	}
			 }
		}
	}
	public function borradoMovCajaBanco($borrado){
		//$asiento=Asiento::model()->findByPk($master['asiento_idasiento']);
		if($borrado['operacion_manual'] != null){
			$cadena=$borrado['operacion_manual'];
			if($cadena[0] == "c"){
				$MovCaja=Movimientocaja::model()->findByPk($borrado['movimientocaja_idmovimientocaja']);
				$MovCaja->delete();
			}
			if($cadena[0] == "b"){
				$MovBanco=Movimientobanco::model()->findByPk($borrado['movimientobanco_idmovimientobanco']);
				$MovBanco->delete();
			}
			
		}
			 
			
	}
public function actualizarAsientoMovCajaBanco($viejo, $nuevo, $fecha, $asiento){	
		foreach($viejo as $llave_1=>$DAviejo){
               //elemento despues de actualizar (nuevo)
               
			$DAnuevo=Detalleasiento::model()->findByPk($nuevo[$llave_1]['iddetalleasiento']);
               
               $caja_nuevo=Caja::model()->find("cuenta_idcuenta=:id",array(':id'=>$DAnuevo->cuenta_idcuenta));
               $caja_viejo=Caja::model()->find("cuenta_idcuenta=:id",array(':id'=>$DAviejo->cuenta_idcuenta));
               $ctabancaria_nuevo=Ctabancaria::model()->find("cuenta_idcuenta=:id",array(':id'=>$DAnuevo->cuenta_idcuenta));
               $ctabancaria_viejo=Ctabancaria::model()->find("cuenta_idcuenta=:id",array(':id'=>$DAviejo->cuenta_idcuenta));
               //si el valor viejo era un movcaja hecho de forma manual y el nuevo det_asiento tiene una cuenta distinta a la anterior 
               if(
	               	($DAviejo->operacion_manual != null) &&
	               	($DAnuevo->cuenta_idcuenta != $DAviejo->cuenta_idcuenta) &&
	               	(!isset($caja_nuevo) && (!isset($ctabancaria_nuevo)))             				
	               	){
               			
		               	$cadena=$DAviejo->operacion_manual;
		               	if($cadena[0] == "c"){
		               		$MovCaja=Movimientocaja::model()->findByPk($DAviejo->movimientocaja_idmovimientocaja);
		               		$MovCaja->delete();
		               		$DAnuevo->movimientocaja_idmovimientocaja=null;
		               		$DAnuevo->operacion_manual=null;
		               		$DAnuevo->save();
		               	}
		               	if($cadena[0] == "b"){
		               		$MovBanco=Movimientobanco::model()->findByPk($DAviejo->movimientobanco_idmovimientobanco);
		               		$MovBanco->delete();
		               		$DAnuevo->movimientobanco_idmovimientobanco=null;
		               		$DAnuevo->operacion_manual=null;
		               		$DAnuevo->save();
		               	}
               		}
               if(
               	($DAviejo->operacion_manual != null) &&
               	($DAnuevo->cuenta_idcuenta != $DAviejo->cuenta_idcuenta) &&
               	(isset($caja_viejo) && (isset($ctabancaria_nuevo)))  //antes era un movcaja ahora pasa a un movbanco   
               ){	
               	$MovCaja=Movimientocaja::model()->findByPk($DAviejo->movimientocaja_idmovimientocaja);
               	$MovCaja->delete();
               //creacion del movimiento banco a la cuenta relacionada	
               $this->nuevoMovBanco($asiento, $DAnuevo, $ctabancaria_nuevo, $fecha);
				}
           
			if(
               	($DAviejo->operacion_manual != null) &&
               	($DAnuevo->cuenta_idcuenta != $DAviejo->cuenta_idcuenta) &&
               	(isset($ctabancaria_viejo) && (isset($caja_nuevo)))  //antes era un movbanco ahora pasa a un movcaja   
               ){	
               	$MovBanco=Movimientobanco::model()->findByPk($DAviejo->movimientobanco_idmovimientobanco);
               	$MovBanco->delete();
               	$this->nuevoMovCaja($asiento, $DAnuevo, $caja_nuevo, $fecha);
               	
               }
               if(
               	($DAviejo->operacion_manual == null) &&
               	($DAnuevo->cuenta_idcuenta != $DAviejo->cuenta_idcuenta) &&
               	(isset($caja_nuevo))  //antes no habia nada ahora si un movcaja 
               ){	
               	$this->nuevoMovCaja($asiento, $DAnuevo, $caja_nuevo, $fecha);
               }
               if(
               	($DAviejo->operacion_manual == null) &&
               	($DAnuevo->cuenta_idcuenta != $DAviejo->cuenta_idcuenta) &&
               	(isset($ctabancaria_nuevo))  //antes no habia nada ahora si un movbanco
               ){	
               	$this->nuevoMovBanco($asiento, $DAnuevo, $ctabancaria_nuevo, $fecha);
               }
               
               if(($DAnuevo->operacion_manual != null)){
               		
               $cadena=$DAnuevo->operacion_manual;
		               	if($cadena[0] == "c"){
		               		$MovCaja=Movimientocaja::model()->findByPk($DAnuevo->movimientocaja_idmovimientocaja);
		               		$MovCaja->descripcion="Asiento - '".$asiento->descripcion."'";
		               		$MovCaja->fecha=$fecha;
		               		$MovCaja->save();
		               	}
		               	if($cadena[0] == "b"){
		               		$MovBanco=Movimientobanco::model()->findByPk($DAnuevo->movimientobanco_idmovimientobanco);
		               		$MovBanco->descripcion="Asiento - '".$asiento->descripcion."'";
		               		$MovBanco->fecha=$fecha;
		               		$MovBanco->save();
		               	}
               }
				
    }
}

	public function nuevoMovCaja($asiento,$DAnuevo,$caja, $fecha){
		$MovCaja=new Movimientocaja;
		$MovCaja->descripcion="Asiento - '".$asiento->descripcion."'";
		$MovCaja->fecha=$fecha;
		if($DAnuevo->debe != null){
			$MovCaja->debeohaber=0;
			$MovCaja->debe=$DAnuevo->debe;
		} else {
			$MovCaja->debeohaber=1;
			$MovCaja->haber=$DAnuevo->haber;
		}
		$MovCaja->caja_idcaja=$caja->idcaja;
		//dato obligatorio, colo la cuenta de la misma caja, es redundante
		$MovCaja->cuenta_idcuenta=$caja->cuenta_idcuenta; 
		//$MovCaja->asiento_idasiento=$master['asiento_idasiento'];
		$MovCaja->desdeasiento=$asiento->idasiento;
		$MovCaja->save();
		//print_r($MovCaja->getErrors());die();
		//$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
		$DAnuevo->movimientobanco_idmovimientobanco=null;
		$DAnuevo->movimientocaja_idmovimientocaja=$MovCaja->idmovimientocaja;
		//para diferenciar la operación
		$DAnuevo->operacion_manual="c".$MovCaja->idmovimientocaja;
		$DAnuevo->save();
	}
	
	public function nuevoMovBanco($asiento,$DAnuevo, $ctabancaria,$fecha){
		$MovBanco=new Movimientobanco;
		$MovBanco->descripcion="Asiento - '".$asiento->descripcion."'";
		$MovBanco->fecha=$fecha;
		if($DAnuevo->debe != null){
			$MovBanco->debeohaber=0;
			$MovBanco->debe=$DAnuevo->debe;
		} else {
			$MovBanco->debeohaber=1;
			$MovBanco->haber=$DAnuevo->haber;
		}
		$MovBanco->ctabancaria_idctabancaria=$ctabancaria->idctabancaria;
		//dato obligatorio, colo la cuenta de la misma caja, es redundante
		$MovBanco->cuenta_idcuenta=$ctabancaria->cuenta_idcuenta; 
		//$MovBanco->asiento_idasiento=$master['asiento_idasiento'];
		$MovBanco->desdeasiento=$asiento->idasiento;
		$MovBanco->save();
		//$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
		$DAnuevo->movimientocaja_idmovimientocaja=null;
		$DAnuevo->movimientobanco_idmovimientobanco=$MovBanco->idmovimientobanco;
		$DAnuevo->operacion_manual="b".$MovBanco->idmovimientobanco;
		$DAnuevo->save();
	}
	public function labelSaldo($data, $row){	
		$saldo=$data["debe"] - $data["haber"];
		//$saldo=number_format($saldo, 2, ",", ".");
		return $saldo;
	}
	public function actionExcel(){
				$mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $tipo=$_GET['tipo'];
                
                $model=new Detalleasiento('search');
		if(($tipo == 0) || ($tipo == 2) ){
			if($tipo == 0){
                $dataproviderDEBE=$model->generarArrayDEBE($anio_tab, $mes_tab)->data;
                $dataproviderHABER=$model->generarArrayHABER($anio_tab, $mes_tab)->data;
                $nombreArchivo='Resumen-Asiento Mes ('.date('m').') - Generado (' .date('d-m-Y').')';
			}
			if($tipo == 2){
				$dataproviderDEBE=$model->generarArrayDEBE_anual($anio_tab)->data;
                $dataproviderHABER=$model->generarArrayHABER_anual($anio_tab)->data;
                $nombreArchivo='Resumen Anual-Asiento año ('.$anio_tab.') - Generado (' .date('d-m-Y').')';
			}
                if(empty($dataproviderDEBE) && empty($dataproviderHABER)){
                	$this->redirect('admin');
                	
                }
                
                $cantDEBE=count($dataproviderDEBE);
                $cantHABER=count($dataproviderHABER);
                $cantTOTAL=$cantDEBE+$cantHABER;
               // echo $cantTOTAL." debe: ".$cantDEBE." haber: ".$cantHABER; die();
               for($i=0;$i<$cantTOTAL;$i++){
	               		if($i < $cantDEBE){
		               		$Resultado[$i]=$dataproviderDEBE[$i];
		               		$Resultado[$i]['haber']=null;
		               	}
		               	if($i > ($cantDEBE-1)){
	               			$e=$i-$cantDEBE;
	               			$Resultado[$i]=$dataproviderHABER[$e];
	               			$Resultado[$i]['debe']=null;
		               	}
	            }
	            
               $var=0;
               for($a=0;$a < count($Resultado);$a++){
               		if(!(($Resultado[$a]['debe'] == null) and ($Resultado[$a]['haber'] == null))){
               			$ResultadoTotal[$var]=$Resultado[$a];
               			$var=$var+1;
               		}
               	
               }
               $cant2=count($ResultadoTotal);
               $dataProvider=new CArrayDataProvider($ResultadoTotal, array(
				    'id'=>'codigo',
				    'sort'=>array(
				        'attributes'=>array(
				             'codigo','cuenta', 'debe', 'haber',
				        ),
				    ),
				    'pagination'=>array(
				        'pageSize'=>$cant2,
				    ),
				));
				$datos=	array( 
               			array(
               				'name' => 'codigo',
							'header' => 'COD. CUENTA',
               			),	
						array(
							'name' => 'cuenta',
							'header' => 'NOMBRE',
						),
						array(
							'header' => 'DEBE',
							'value'=>'($data["debe"] !== null)? number_format($data["debe"], 2, ",", "."):""',
						),
						array(
							'header' => 'HABER',
							'value'=>'($data["haber"] !== null)? number_format($data["haber"], 2, ",", "."):""',
						),
					);
					
		}
		
		if(($tipo == 1) || ($tipo == 3)){
			if($tipo == 1){
				$dataproviderAsiento=$model->generarAsientos($anio_tab, $mes_tab)->data;
				$nombreArchivo='Libro Diario Mes ('.date('m').') - Generado (' .date('d-m-Y').')';
			}
			if($tipo == 3){
				$dataproviderAsiento=$model->generarAsientos_anual($anio_tab)->data;
				$nombreArchivo='Libro Diario Año ('.date('Y').') - Generado (' .date('d-m-Y').')';
			}
			if(empty($dataproviderAsiento)){
                	$this->redirect('admin');
              }
			$cantAsientos=count($dataproviderAsiento);
		//echo $cantAsientos;die();
			for($i=0;$i<$cantAsientos;$i++){
				$dataproviderResultadoAsiento[$i]=$dataproviderAsiento[$i];
				
				if($i > 0){
				if($dataproviderAsiento[$i]['asiento'] == $dataproviderAsiento[$i-1]['asiento']){
					
					$dataproviderResultadoAsiento[$i]['asiento']=null;
					$dataproviderResultadoAsiento[$i]['descripcion']=null;
					$dataproviderResultadoAsiento[$i]['fecha']=null;
					
				}
				}
			}
			//print_r($dataproviderResultadoAsiento);die();
			$cant=count($dataproviderResultadoAsiento);
			$dataProvider=new CArrayDataProvider($dataproviderResultadoAsiento, array(
				    'id'=>'codigo',
				    'sort'=>array(
				        'attributes'=>array(
				           'fecha', 'asiento','codigo','nombre', 'debe', 'haber',
				        ),
				    ),
				    'pagination'=>array(
				        'pageSize'=>$cant,
				    ),
				));
			$datos=	array(
						array(
               				'name' => 'asiento',
							'header' => 'COD. INTERNO',
               			), 
						array(
               				'name' => 'fecha',
							'header' => 'FECHA',
               			), 
						
               			array(
							'name' => 'descripcion',
							'header' => 'DESCRIPCION',
						),
               			array(
               				'name' => 'codigo',
							'header' => 'COD. CUENTA',
               			),	
						array(
							'name' => 'nombre',
							'header' => 'NOMBRE',
						),
						array(
							'header' => 'DEBE',
							'value'=>'($data["debe"] !== null)? number_format($data["debe"], 2, ",", "."):""',
						),
						array(
							'header' => 'HABER',
							'value'=>'($data["haber"] !== null)? number_format($data["haber"], 2, ",", "."):""',
						),
						
					);
					
		}
		if(($tipo == 4)||($tipo == 5)){ //exportación con saldos
			if($tipo == 4){
				 $dataproviderSALDOS=$model->generarArraySALDOS_mes($anio_tab, $mes_tab)->data;
				 $nombreArchivo='Resumen cuentas saldos - Mes ('.date('m').') - Generado (' .date('d-m-Y').')';
			}
			if($tipo == 5){
				 $dataproviderSALDOS=$model->generarArraySALDOS_anio($anio_tab)->data;
				 $nombreArchivo='Resumen cuentas saldos - Año ('.date('Y').') - Generado (' .date('d-m-Y').')';
			}
			if(empty($dataproviderSALDOS)){
                	$this->redirect('admin');
              }
			
			$cantSaldos=count($dataproviderSALDOS);
               $dataProvider=new CArrayDataProvider($dataproviderSALDOS, array(
				    'id'=>'codigo',
				    'sort'=>array(
				        'attributes'=>array(
				             'codigo','cuenta', 'debe', 'haber',
				        ),
				    ),
				    'pagination'=>array(
				        'pageSize'=>$cantSaldos,
				    ),
				));
				$datos=	array( 
               			array(
               				'name' => 'codigo',
							'header' => 'COD. CUENTA',
               			),	
						array(
							'name' => 'cuenta',
							'header' => 'NOMBRE',
						),
						array(
							'header' => 'DEBE',
							'value'=>'($data["debe"] !== null)? number_format($data["debe"], 2, ",", "."):"0.00"',
						),
						array(
							'header' => 'HABER',
							'value'=>'($data["haber"] !== null)? number_format($data["haber"], 2, ",", "."):"0.00"',
						),
						array(
							'header' => 'SALDO',
							'value'=>array($this,'labelSaldo'),
						),
					);
		}
				//print_r($dataProvider);die(); 
               // public $totaldebe, $totalhaber, $codigo, $Idcuenta ,$NombreCta;
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $dataProvider,//$model->generarGrid($anio_tab, $mes_tab),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => $nombreArchivo,
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Libro diario ' . date('m-d-Y H-i'),
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
				    //'sumLabel'             => 'TOTALES:', // Default: 'Totals'
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
				    'columns'              => $datos,
               
				)); 
               
        	
	}
}