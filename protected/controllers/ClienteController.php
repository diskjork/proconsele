<?php

class ClienteController extends Controller
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
		$model=new Cliente;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['Cliente'])) {
			$model->attributes=$_POST['Cliente'];
			$model->estado=1;
			if ($model->save()) {
				$modelctacte=new Ctactecliente;
				$modelctacte->debe=0;
				$modelctacte->haber=0;
				$modelctacte->saldo=0;
				$modelctacte->cliente_idcliente= $model->idcliente;
				
				if($modelctacte->save()){
					$model->ctactecliente_idctactecliente=$model->idcliente;
					if($model->save()){
						Yii::app()->user->setFlash('success', "<strong>Cliente creado correctamente.</strong>");
					$this->redirect('admin');
					}
					
				}
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
		$this->performAjaxValidation($model);

		if (isset($_POST['Cliente'])) {
			$model->attributes=$_POST['Cliente'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', "<strong>Cliente actualizado correctamente.</strong>");
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
		$dataProvider=new CActiveDataProvider('Cliente');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cliente('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cliente'])) {
			$model->attributes=$_GET['Cliente'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cliente the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cliente::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cliente $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='cliente-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionActivar($id, $estado){
        	if($estado == 1){
        		$estadofinal=0;
        	}else {
        		$estadofinal=1;
        	}
        	$command = Yii::app()->db->createCommand();
				$command->update('cliente', array(
				    'cliente.estado'=>new CDbExpression($estadofinal),
				), 'idcliente='.$id);
			//$this->redirect(array("admin"));
        }
	
        public function actionExcel(){
                $model=new Cliente('search');
                	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->Search(),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Clientes ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Clientes ' . date('m-d-Y H-i'),
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
				    'columns'              => array( // an array of your CGridColumns

				        array(
							'name'=>'nombre',
							'header'=>'NOMBRE',	
						),
						array(
							'name'=>'cuit',
							'header'=>'CUIT',	
						),
						array(
							'name'=>'direccion',
							'header'=>'DIRECCIÓN',	
						),
						array(
							'name'=>'telefono',
							'header'=>'TELÉFONO',	
						),
						array(
				         	'name'=>'estado',
						 	'header'=>'ESTADO',
				        	'value'=>'$data->estado == 1 ? "Activo" : "Inactivo"',
				        ),
					) 
				)); 
         }
	public function actionBusqueda(){
        $data = GxHtml::listDataEx(Localidad::model()->findAllAttributes(array('nombre','provincia_idprovincia'),true,array('order'=>'nombre ASC')),'idlocalidad','fullname');
        /*$result = array();
        foreach($data as $item):
           $result[] = array(
               'idlocalidad'   => $item->idlocalidad,
               'nombre' => $item->fullname,
           )
        endforeach;*/
       echo CJSON::encode( $data );
      
 }
}