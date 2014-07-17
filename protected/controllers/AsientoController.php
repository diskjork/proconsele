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
              
               {
                 //the value for the foreign key 'groupid'
                 $masterValues = array ('asiento_idasiento'=>$model->idasiento);
                 if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
				$this->redirect(array('view','id'=>$model->idasiento));
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
				$this->redirect(array('view','id'=>$model->idasiento));

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
		$dataProvider=new CActiveDataProvider('Asiento');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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

	public function actionExcel(){
				$mes_tab=$_GET['mesTab'];
                $anio_tab=$_GET['anioTab'];
                $model=new Detalleasiento('search');
                /*
                $dataproviderDEBE=$model->generarArrayDEBE($anio_tab, $mes_tab)->data;
                $dataproviderHABER=$model->generarArrayHABER($anio_tab, $mes_tab)->data;
                $cantDEBE=count($dataproviderDEBE);
                $cantHABER=count($dataproviderHABER);
                $cantTOTAL=$cantDEBE+$cantHABER;
                
               for($i=0;$i<$cantTOTAL;$i++){
               	if($i < ($cantDEBE)){
               		$Resultado[$i]=$dataproviderDEBE[$i];
               		$Resultado[$i]['haber']=null;
               	}
               		if($i >= $cantDEBE){
               			$e=$i-$cantDEBE;
               			$Resultado[$i]=$dataproviderHABER[$e];
               			$Resultado[$i]['debe']=null;
               		}
               }
               $var=0;
               for($a=0;$a < count($Resultado);$a++){
               		if(!(($Resultado[$a]['debe']== null) and ($Resultado[$a]['haber'] == null))){
               			$ResultadoTotal[$var]=$Resultado[$a];
               			$var=$var+1;
               		}
               	
               }
              
               $dataProvider=new CArrayDataProvider($ResultadoTotal, array(
				    //'id'=>'',
				    'sort'=>array(
				        'attributes'=>array(
				             'codigo', 'cuenta', 'debe','haber'
				        ),
				    ),
				    'pagination'=>array(
				        'pageSize'=>10,
				    ),
				)); 
                */ 
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->generarGrid($anio_tab, $mes_tab),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Libro diario ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'CC Proveedores ' . date('m-d-Y H-i'),
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
               				'name' => 'codigo',
							'header' => 'COD. CUENTA',
               				
						),	
						array(
							'name' => 'NombreCta',
							'header' => 'NOMBRE',
										
						),
						array(
							//'name' => 'totaldebe',
							'header' => 'DEBE',
							'value'=>'($data->totaldebe !== null)? number_format($data->totaldebe, 2, ",", "."):""',
							//'value'=>'($data->totaldebe !== null)? "$".number_format($data->totaldebe, 2, ",", "."): ""',		
						),
						array(
							//'name' => 'totalhaber',
							'header' => 'HABER',
							'value'=>'($data->totalhaber !== null)? number_format($data->totalhaber, 2, ",", "."):""',
							//'value'=>'($data->totalhaber !== null)? "$".number_format($data->totalhaber, 2, ",", "."): ""',		
						),
					), 
				)); 
               
        	
	}
}