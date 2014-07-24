<?php

class MovimientocajaController extends Controller
{	
	public $nav;
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
		$model=new Movimientocaja;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if (isset($_POST['Movimientocaja'])) {
			$model->attributes=$_POST['Movimientocaja'];
			if($model->debeohaber == 0){
					
					$model->debe= $this->cargaImporte($_POST['Movimientocaja']['importe']);
					
				} elseif($model->debeohaber == 1){
					
					$model->haber= $this->cargaImporte($_POST['Movimientocaja']['importe']);
				}
			
		if ($model->validate()) {
					$asiento=new Asiento;
					$asiento->fecha=$model->fecha;
					$asiento->descripcion="Mov.Caja. ".$model->cajaIdcaja." - ".$model->descripcion;
					if($asiento->save()){
						if($model->debeohaber == 0){
							$detAs=new Detalleasiento;
							$detAs->debe=$model->debe;
							$detAs->cuenta_idcuenta=$model->cajaIdcaja->cuenta_idcuenta;
							$detAs->asiento_idasiento=$asiento->idasiento;
							$detAs->save();
							$detAs2=new Detalleasiento;
							$detAs2->haber=$model->debe;
							$detAs2->cuenta_idcuenta=$model->cuenta_idcuenta;
							$detAs2->asiento_idasiento=$asiento->idasiento;
							$detAs2->save();
							$model->asiento_idasiento=$asiento->idasiento;
							$model->save();
							$detAs->movimientocaja_idmovimientocaja=$model->idmovimientocaja;
							$detAs->save();
						
						} elseif($model->debeohaber == 1){
							$detAs=new Detalleasiento;
							$detAs->debe=$model->haber;
							$detAs->cuenta_idcuenta=$model->cuenta_idcuenta;
							$detAs->asiento_idasiento=$asiento->idasiento;
							$detAs->save();
							$detAs2=new Detalleasiento;
							$detAs2->haber=$model->haber;
							$detAs2->cuenta_idcuenta=$model->cajaIdcaja->cuenta_idcuenta;
							$detAs2->asiento_idasiento=$asiento->idasiento;
							$detAs2->movimientocaja_idmovimientocaja=$model->idmovimientocaja;
							$detAs2->save();
							$model->asiento_idasiento=$asiento->idasiento;
							$model->save();
							$detAs2->movimientocaja_idmovimientocaja=$model->idmovimientocaja;
							$detAs2->save();
						}
						$asiento2=Asiento::model()->findByPk($asiento->idasiento);
						$asiento2->movimientocaja_idmovimientocaja=$model->idmovimientocaja;
						$asiento2->save();
					}
				Yii::app()->user->setFlash('success', "<strong>Movimiento cargado correctamente.</strong>");
				$this->redirect(array('admin'));
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
		$model2=$this->loadModel($id);
		
		if($model->debeohaber == 0){
			$model->importe=$model->debe;
		} elseif($model->debeohaber == 1){
			$model->importe=$model->haber;
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Movimientocaja'])) {
			
			if($model->debeohaber != $_POST['Movimientocaja']['debeohaber']){
				if($_POST['Movimientocaja']['debeohaber'] == 1){
					$_POST['Movimientocaja']['debe']= NULL;
					//$_POST['Movimientocaja']['cliente_idcliente']=NULL;
					}
				if($_POST['Movimientocaja']['debeohaber'] == 0){
					$_POST['Movimientocaja']['haber']= NULL;
					//$_POST['Cheque']['proveedor_idproveedor']=NULL;
					}
			}
				
			$model->attributes=$_POST['Movimientocaja'];
			
			if($model->debeohaber == 0){
					$model->debe= $this->cargaImporte($_POST['Movimientocaja']['importe']);
				} elseif($model->debeohaber == 1){
					$model->haber= $this->cargaImporte($_POST['Movimientocaja']['importe']);
				}
				$this->checkUpdateAsiento($model2, $model);
				if ($model->save()) {
				if($_POST['Movimientocaja']['vista'] == 2){
					$this->redirect(Yii::app()->request->baseUrl.'/asiento/admin');
				}
				Yii::app()->user->setFlash('success', "<strong>Movimiento actualizado correctamente.</strong>");
				$this->redirect(array('admin'));
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
			$this->loadModel($id)->delete();
			
			//$this->redirect(array('admin'));
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
		//-----------
		$modelform=new Movimientocaja;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($modelform);
		if (isset($_POST['Movimientocaja'])) {
			$_POST['Movimientocaja']=$this->cargaImporte($_POST['Movimientocaja']);
			$modelform->attributes=$_POST['Movimientocaja'];
			if ($modelform->save()) {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
   					 '<strong>ÉXITO !!</strong>  -- Su movimiento fue creado con exito.');
				$this->redirect(array('admin','model'=>$modelform));
			} else {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,
    				'<strong>Error  !!</strong>   -- No se ha podido crear el movimiento.');
			}

		}

		//-----------
		
		$model=new Movimientocaja('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Movimientocaja'])) {
			$model->attributes=$_GET['Movimientocaja'];
		}

		$this->render('admin',array(
			'model'=>$model,
			'modelform'=>$modelform, //para que envíe los datos del form
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Movimientocaja the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Movimientocaja::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Movimientocaja $model the model to be validated
	 */
	protected function performAjaxValidation($model){
		if (isset($_POST['ajax']) && $_POST['ajax']==='movimientocaja-form') {
			echo CActiveForm::validate($model);
			
			Yii::app()->end();
			}
		}
	public function checkCajas($model){
			$lista=$model->listCajas();
			if(empty($lista)){
				return $e=0;
			}else {
				return $lista;
			}
		}
	public function cargaImporte($arr){
			$temp=$arr;
			$temp = str_replace(",","",$temp); //borro los separadores de miles, si hay
	 		if(settype($temp,"double"))
				return $temp;	
		
	}
public function checkUpdateAsiento($datosGuardados, $datosPOST){
	//ASIENTO
	$asientoGuardado=Asiento::model()->findByPk($datosGuardados->asiento_idasiento);	
//detalle asiento relacionado a la caja antes de modificar	
	$DeAsCaja=Detalleasiento::model()->find("cuenta_idcuenta=:idcuenta AND asiento_idasiento=:idasiento",
		   			array(':idcuenta'=>$datosGuardados->cajaIdcaja->cuenta_idcuenta,
		   				  ':idasiento'=>$datosGuardados->asiento_idasiento));
//detalle asiento relacionada a la cuenta contable relacionada antes de modificar
   $DeAsCtaRel=Detalleasiento::model()->find("cuenta_idcuenta=:idcuenta AND asiento_idasiento=:idasiento",
   			array(':idcuenta'=>$datosGuardados->cuenta_idcuenta,
   				  ':idasiento'=>$datosGuardados->asiento_idasiento));
	
   if($datosGuardados->descripcion != $datosPOST->descripcion ||
	   $datosGuardados->fecha != $datosPOST->fecha ||
	   $datosGuardados->debe != $datosPOST->debe ||
	   $datosGuardados->haber != $datosPOST->haber || 
	   $datosGuardados->caja_idcaja != $datosPOST->caja_idcaja ||
	   $datosGuardados->cuenta_idcuenta != $datosPOST->cuenta_idcuenta AND 
	   $datosGuardados->debeohaber == $datosPOST->debeohaber){
	   		  
	   $asientoGuardado->descripcion="Mov.Caja. Caja: ".$datosPOST->caja_idcaja." - ".$datosPOST->descripcion;
	   $asientoGuardado->fecha=$datosPOST->fecha;
	   $asientoGuardado->save();
	   if($datosPOST->debeohaber == 0){
	   	 $DeAsCaja->debe=$datosPOST->debe;
	   	 $DeAsCaja->haber=null;
	   	 $DeAsCtaRel->haber=$datosPOST->debe;
	   	 $DeAsCtaRel->debe=null;
	   } else {
	   	 $DeAsCaja->haber=$datosPOST->haber;
	   	 $DeAsCaja->debe=null;
	   	 $DeAsCtaRel->debe=$datosPOST->haber;
	   	 $DeAsCtaRel->haber=null;
	   }
	  
	   $DeAsCaja->cuenta_idcuenta=$datosPOST->cajaIdcaja->cuenta_idcuenta;
	   $DeAsCaja->save();
	  	  
	   $DeAsCtaRel->cuenta_idcuenta=$datosPOST->cuenta_idcuenta;
	   $DeAsCtaRel->save();
	} 
		   if($datosGuardados->debeohaber != $datosPOST->debeohaber){
		   		if($datosPOST->debeohaber == 0 ){
		   		  $DeAsCaja->debe=$datosPOST->debe;
		   		  $DeAsCaja->haber=null;
		   		  $DeAsCaja->cuenta_idcuenta=$datosPOST->cajaIdcaja->cuenta_idcuenta;
		   		  $DeAsCaja->save();
		   		  $DeAsCtaRel->haber=$datosPOST->debe;
		   		  $DeAsCtaRel->debe=null;
		   		  $DeAsCtaRel->cuenta_idcuenta=$datosPOST->cuenta_idcuenta;
		   		  $DeAsCtaRel->save();
		   		  
		   		} elseif($datosPOST->debeohaber == 1){
		   		  $DeAsCaja->haber=$datosPOST->haber;
		   		  $DeAsCaja->debe=null;
		   		  $DeAsCaja->cuenta_idcuenta=$datosPOST->cajaIdcaja->cuenta_idcuenta;
		   		  $DeAsCaja->save();
		   		  $DeAsCtaRel->debe=$datosPOST->haber;
		   		  $DeAsCtaRel->haber=null;
		   		  $DeAsCtaRel->cuenta_idcuenta=$datosPOST->cuenta_idcuenta;
		   		  $DeAsCtaRel->save();
		   		}
		   }
	}
	
	public function actionExcel(){
                $mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $model=new Movimientocaja('search');
                	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->Search($model->fecha=$mes_tab."/".$anio_tab),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Caja ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Caja ' . date('m-d-Y H-i'),
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
               				'name' => 'fecha',
							'header' => 'FECHA',
						),
						array(
							'name' => 'descripcion',
							'header' => 'DESCRIPCION',
						),
				       	array(
				         	'header'=>'INGRESOS',
				       		'value'=>'number_format($data->debe, 2, ",", ".")',
				        ),
				        array(
					  		'header'=>'EGRESOS',
				        	'value'=>'number_format($data->haber, 2, ",", ".")',
				        ),
					) 
				)); 
               
        	
	}
	

	
}