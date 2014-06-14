<?php

class CtabancariaController extends Controller
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
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('create','update','habilitar','activar'),
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
		$model=new Ctabancaria;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Ctabancaria'])) {
			$model->attributes=$_POST['Ctabancaria'];
			
			if ($model->save()) {
				$this->redirect(array('admin','id'=>$model->idctabancaria));
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

		if (isset($_POST['Ctabancaria'])) {
			$model->attributes=$_POST['Ctabancaria'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->idctabancaria));
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
		$dataProvider=new CActiveDataProvider('Ctabancaria');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ctabancaria('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Ctabancaria'])) {
			$model->attributes=$_GET['Ctabancaria'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ctabancaria the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ctabancaria::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ctabancaria $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='ctabancaria-form') {
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
				$command->update('ctabancaria', array(
				    'ctabancaria.estado'=>new CDbExpression($estadofinal),
				), 'idctabancaria='.$id);
			//$this->redirect(array("admin"));
        }
	public function actionHabilitar(){
		$model=new Ctabancaria;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if (isset($_POST['Ctabancaria'])) {
			$modelhabilitar=$this->loadModel($_POST['Ctabancaria']['nombre']);
			$modelhabilitar->estado=1;
			if ($modelhabilitar->save()) {
					Yii::app()->user->setFlash('success', "<strong>Cuenta bancaria habilitada correctamente.</strong>");
					$this->redirect(array('admin'));
			}
		}

		$this->render('habilitar',array(
			'model'=>$model,
		));
	}
	
}