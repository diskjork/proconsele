<?php

class DetallectacteprovController extends Controller
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
		$model=new Detallectacteprov;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Detallectacteprov'])) {
			$model->attributes=$_POST['Detallectacteprov'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->iddetallectacteprov));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Detallectacteprov'])) {
			$model->attributes=$_POST['Detallectacteprov'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->iddetallectacteprov));
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
		$model=new Detallectacteprov('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Detallectacteprov'])) {
			$model->attributes=$_GET['Detallectacteprov'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Detallectacteprov the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Detallectacteprov::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Detallectacteprov $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='detallectacteprov-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSecuencial($id)
	{
		$model=new Detallectacteprov('search');
		$model->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Detallectacteprov'])) {
			$model->attributes=$_GET['Detallectacteprov'];
		}

		$this->render('secuencial',array(
			'model'=>$model,
		));
	}
	public function labelTipo($data, $row){	
	switch ($data["tipo"]){
			case '0':
				$text="Compra";
				return $text;
				break;
			case '1':
				$text="Orden de pago";
				return $text;
				break;
			case '3':
				$text="Nota Crédito - Proveedor";
				return $text;
				break;
			case '2':
				$text="Nota Débito -  Proveedor";
				return $text;
				break;
			case '4':
				$text="Cheque Rechazado";
				return $text;
				break;
			
		}
	}
	public function actionExcel(){
                 $mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $idprov=$_GET['idctacteprov'];
                $caso=$_GET['caso'];
                $nombre=$_GET['nombre'];
                $model=new Detallectacteprov;
                if($caso == 0){
                $datos= $model->generarGrillaSaldos($idprov,$anio_tab,$mes_tab,0);	
                
                	$titulo_shee="C.C.".$nombre ;
                	$titulo="C.C.".$nombre." ".$anio_tab."-".$mes_tab;
                } else {
                	$datos= $model->generarGrillaSaldos_secuencial($idprov,$anio_tab,$mes_tab,1)->data;
                	$cantSaldos=count($datos);
	               $datos=new CArrayDataProvider($datos, array(
					    'id'=>'iddetallectacteprov',
					    'sort'=>array(
	               			'defaultOrder'=>array('fecha'=>CSort::SORT_ASC),
					        'attributes'=>array(
					             'iddetallectacteprov','fecha', 'debe', 'haber','saldo'
					        ),
					    ),
					    'pagination'=>array(
					        'pageSize'=>$cantSaldos,
					    ),
					));	
                  	$titulo_shee="C.C.".$nombre ;
                	$titulo="C.C.".$nombre." Total";
                }
                $tabla=	array( 
               			array(
               				'header' => 'FECHA',
               				'value'=>'$data["fecha"]',
						),
						array(
							'header' => 'DESCRIPCION',
							'value'=>'$data["descripcion"]',
						),
						array(
							'header' => 'TIPO',
							'value'=>array($this,'labelTipo'),
						),
				       	array(
				         	'header'=>'DEBE',
				       		'value'=>'number_format($data["debe"], 2, ",", ".")',
				        ),
				        array(
					  		'header'=>'HABER',
				        	'value'=>'number_format($data["haber"], 2, ",", ".")',
				        ), 
				         array(
					  		'header'=>'SALDO',
				        	'value'=>'number_format($data["saldo"], 2, ",", ".")',
				        )); 
                	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $datos,
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => $titulo,
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => $titulo,
				    'keywords'             => '',
				    'category'             => '',
				    'landscapeDisplay'     => true, // Default: false
				    'A4'                   => true, // Default: false - ie : Letter (PHPExcel default)
				    'pageFooterText'       => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
				    'automaticSum'         => false, // Default: false
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
				    'columns'              => $tabla, 
				)); 
               
        	
	}
}