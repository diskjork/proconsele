<?php

class CuentaController extends Controller
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
		$model=new Cuenta;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Cuenta'])) {
			$model->attributes=$_POST['Cuenta'];
			if ($model->save()) {
				$this->redirect(array('admin','id'=>$model->idcuenta));
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

		if (isset($_POST['Cuenta'])) {
			$model->attributes=$_POST['Cuenta'];
			if ($model->save()) {
				$this->redirect(array('admin','id'=>$model->idcuenta));
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
		$model=new Cuenta('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cuenta'])) {
			$model->attributes=$_GET['Cuenta'];
		}
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cuenta the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cuenta::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cuenta $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='cuenta-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSeleccuenta()
	{
		$model=new Cuenta('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cuenta'])) {
			$model->attributes=$_GET['Cuenta'];
		}
		
		$this->render('seleccuenta',array(
			'model'=>$model,
		));
	}
	public function nombreTipogral($data,$row){
		$modelo=new Tipocuenta;
		$modelo=Tipocuenta::model()->findByPk($data->tipocuenta_idtipocuenta);
		$tipogral=$modelo['tipogral_idtipogral'];
		$modelogral=Tipogral::model()->findByPk($tipogral);
		return $modelogral['nombre'];
		
		}
	public function actionMovimientocuenta(){
		$idcuenta=$_POST['nombre'];
		$fecha=$_POST['fecha'];
		$fecha2=$_POST['fecha2'];
		$model=new Cuenta;
		//echo $idcuenta." ".$fecha."  ".$fecha2;
		$this->renderPartial('_seleccuenta',array('model'=>$model,'idcuenta'=>$idcuenta,'fecha'=>$fecha,'fecha2'=>$fecha2));
		/*$model=Producto::model()->findByPk($dato,'estado = 1');
		$val=array(
			'idp'=>$model->idproducto,
			'nombre'=>$model->nombre,
			'precio'=>$model->precio,
			//'stock'=>$model->stock,
			'venta'=>$model->unidad
			);	
			echo json_encode($val);*/
		}
	public function actionExcel(){
		$model=new Cuenta('search');
		$idcuenta=$_GET['idcuenta'];
        $fecha=$_GET['fecha'];
        $fecha2=$_GET['fecha2'];
        $cuenta=Cuenta::model()->findByPk($idcuenta);
		$dataProviderRe= $model->generargrilladetallecuenta($idcuenta, $fecha, $fecha2)->data;
		$cant=count($dataProviderRe);
		$dataProvider=new CArrayDataProvider($dataProviderRe, array(
				    'id'=>'idcuent',
				    'sort'=>array(
				        'attributes'=>array(
				           'fechaasiento', 'codigocuenta' ,'nombrecuenta','descripcionasiento','idcuent','debeT', 'haberT'
				        ),
				    ),
				    'pagination'=>array(
				        'pageSize'=>$cant,
				    ),
				));
		
$datos=array(
		
		array(
			'name'=>'fechaasiento',
			'header' => 'FECHA',
			), 
		array(
			'header'=>'CUENTA',
			'value'=>'$data["codigocuenta"]."-".$data["nombrecuenta"]',
		),	
		array(
			'name'=>'descripcionasiento',
			'header'=>'DESCRIPCION',
		),
		array(
			'header' => 'DEBE',
			'value'=>'($data["debeT"] !== null)? number_format($data["debeT"], 2, ",", "."):"-"',
		),
		array(
			'header' => 'HABER',
			'value'=>'($data["haberT"] !== null)? number_format($data["haberT"], 2, ",", "."):"-"',
		),
	);
				
		
	$nombreArchivo="Resumen cuenta ".$cuenta->codigocta."-".$cuenta->nombre." '".$fecha."' - '".$fecha2."'";
		
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
				    'sheetTitle'           => 'Cuenta ' . $cuenta->nombre,
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