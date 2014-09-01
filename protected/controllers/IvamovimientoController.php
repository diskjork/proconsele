<?php

class IvamovimientoController extends Controller
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
		$model=new Ivamovimiento;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Ivamovimiento'])) {
			$model->attributes=$_POST['Ivamovimiento'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->idivamovimiento));
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

		if (isset($_POST['Ivamovimiento'])) {
			$model->attributes=$_POST['Ivamovimiento'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->idivamovimiento));
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
		$model=new Ivamovimiento('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Ivamovimiento'])) {
			$model->attributes=$_GET['Ivamovimiento'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ivamovimiento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ivamovimiento::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ivamovimiento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='ivamovimiento-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionTabscompras()
	{
		$model=new Ivamovimiento('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Ivamovimiento'])) {
			$model->attributes=$_GET['Ivamovimiento'];
		}

		$this->render('tabscompras',array(
			'model'=>$model,
		));
	}
	public function actionTabsventas()
	{
		$model=new Ivamovimiento('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Ivamovimiento'])) {
			$model->attributes=$_GET['Ivamovimiento'];
		}

		$this->render('tabsventas',array(
			'model'=>$model,
		));
	}
	public function labelEstado($data, $row){	
		switch ($data->tipofactura){
				case '1':
					$text="F.(A)";
					return $text;
					break;
				case '2':
					$text="F. (B)";
					return $text;
					break;
				case '3':
					$text="NC";
					return $text;
					break;
				case '4':
					$text="ND";
					return $text;
					break;
				case '5':
					$text="NC-Prov.";
					return $text;
					break;
				case '6':
					$text="ND-Prov.";
					return $text;
					break;
				case '7':
					$text="F.(A) - ANULADA";
					return $text;
					break;
				case '8':
					$text="F. (B) - ANULADA";
					return $text;
					break;
		}
	}
	
	public function actionExcel(){
		$mes_tab=$_GET['mesTab'];
       	$anio_tab=$_GET['anioTab'];
        $tipo=$_GET['tipo'];
        $model=new Ivamovimiento('search');
		if($tipo == 1){
			$valor="proveedorIdproveedor";
			$nombreArchivo='Libro IVA COMPRAS mes('.date('m').') - Generado (' .date('d-m-Y').')';
			$label="Compras";
		} else{
			$valor="clienteIdcliente";
			$nombreArchivo='Libro IVA VENTAS mes('.date('m').') - Generado (' .date('d-m-Y').')';
			$label="Ventas";
		}
			
        $dataProvider= $model->search($model->fecha=$anio_tab."-".$mes_tab, $model->tipomoviento= $tipo);
		$dataProvider->setPagination(array('pageSize'=>$model->count()));
		
		$datos=array(
		array('name' => 'nrocomprobante',
					'header' => 'NRO.COMP.' ),
		array(
			'name' => 'fecha',
			'header' => 'F. COBRO' ),
		array(
			'header'=>'EMPRESA',
			'value'=>'($data->proveedorIdproveedor != null)?$data->proveedorIdproveedor:$data->clienteIdcliente',
		),
		array(//'name' => ''.$valor.'.cuit',
			  'header' => 'CUIT',
			  'value'=>'($data->proveedorIdproveedor != null)?$data->proveedorIdproveedor->cuit:$data->clienteIdcliente->cuit',
			),	
		array(
				'header' => 'COMPROBANTE',
				'value'=>array($this,'labelEstado') ),	
		array(
				'header' => 'IVA',
				'value'=>array($this,'labeliva'),
			),
		array(
				'header' => 'IIBB',
				//'value'=>'$data->importeiibb',
				'value'=>'($data->importeiibb != null) ? number_format($data->importeiibb, 2, ",", "."): ""',
				//'value'=>array($this,'labelNumIIBB'),
			),
		array(
				'header' => 'PER.IVA',
				//'value'=>'$data->importe_per_iva',
				'value'=>'($data->importe_per_iva != null) ? number_format($data->importe_per_iva, 2, ",", "."): ""',
				//'value'=>array($this,'labelNumIIBB'),
			),
		array(
				'header' => 'IMP.INT.',
				//'value'=>'$data->importe_per_iva',
				'value'=>'($data->impuestointerno != null) ? number_format($data->impuestointerno, 2, ",", "."): ""',
				//'value'=>array($this,'labelNumIIBB'),
			),
		array(
				'header' => 'TOTAL IVA',
				//'value'=>'$data->importeiva',
				'value'=>'number_format($data->importeiva, 2, ",", ".")',
			),
		array(
				'header' => 'NETO',
				//'value'=>'$data->importeneto',
				'value'=>'number_format($data->netogravado, 2, ",", ".")',
			),
		array(
				'header' => 'TOTAL',
				//'value'=>'$data->importeneto',
				'value'=>'number_format($data->importeneto, 2, ",", ".")',
			));
			
		
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
				    'sheetTitle'           => 'IVA '.$label.' '.date('m-d-Y'),
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
				    'columns'              => $datos,
               
				)); 
	}
	public function labeliva($data, $row){	
	switch ($data->tipoiva){
			case '1.21':
				$text="21%";
				return $text;
				break;
			case '1.27':
				$text="27%";
				return $text;
				break;
			case '1.105':
				$text="10,5%";
				return $text;
				break;
		}
	}
}