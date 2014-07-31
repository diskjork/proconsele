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
            $masterValues = array ('asiento_idasiento'=>$model->idasiento);

            if( //Save the master model after saving valid members
                MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues) &&
                $model->save()
               )
               
               $this->cambioImporteCajaBanco($validatedMembers, $masterValues, $_POST['Asiento']['fecha']);
               
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
				$MovCaja->save();
				$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
				$DeT->movimientocaja_idmovimientocaja=$MovCaja->idmovimientocaja;
				//para diferenciar la operación
				$DeT->operacion_manual="c".$MovCaja->idmovimientocaja;
				$DeT->update();
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
				$MovBanco->save();
				$DeT=Detalleasiento::model()->findByPk($datos[$i]['iddetalleasiento']);
				$DeT->movimientobanco_idmovimientobanco=$MovBanco->idmovimientobanco;
				$DeT->operacion_manual="b".$MovBanco->idmovimientobanco;
				$DeT->update();
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
	public function actionExcel(){
				$mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $tipo=$_GET['tipo'];
                
                $model=new Detalleasiento('search');
		if($tipo == 0){
                $dataproviderDEBE=$model->generarArrayDEBE($anio_tab, $mes_tab)->data;
                $dataproviderHABER=$model->generarArrayHABER($anio_tab, $mes_tab)->data;
                /*print_r($dataproviderDEBE);
                echo "<br>";
                print_r($dataproviderHABER);die();*/
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
           //  print_r($dataproviderDEBE);
             // die();
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
					$nombreArchivo='Resumen-Asiento Mes ('.date('m').') - Generado (' .date('d-m-Y').')';
		} else {
			$dataproviderAsiento=$model->generarAsientos($anio_tab, $mes_tab)->data;
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
               				'name' => 'fecha',
							'header' => 'FECHA',
               			), 
						array(
               				'name' => 'asiento',
							'header' => 'NRO ASIENTO',
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
					$nombreArchivo='Libro Diario Mes ('.date('m').') - Generado (' .date('d-m-Y').')';
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