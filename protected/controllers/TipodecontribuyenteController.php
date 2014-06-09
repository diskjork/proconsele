<?php

class TipodecontribuyenteController extends Controller
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
			//array('auth.filters.AuthFilter'),
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
				'actions'=>array('index','view','editable'),
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
		$model=new Tipodecontribuyente;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Tipodecontribuyente'])) {
			$model->attributes=$_POST['Tipodecontribuyente'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', "<strong>Contribuyente creado correctamente.</strong>");
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Tipodecontribuyente'])) {
			$model->attributes=$_POST['Tipodecontribuyente'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', "<strong>Contribuyente actualizado correctamente.</strong>");
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
		$dataProvider=new CActiveDataProvider('Tipodecontribuyente');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$modelform=new Tipodecontribuyente;
		
		$this->performAjaxValidation($modelform);
		
		 if (isset($_POST['Tipodecontribuyente'])) {
			$modelform->attributes=$_POST['Tipodecontribuyente'];
			if ($modelform->save()) {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
   					 '<strong>EXITO !!</strong>  -- El Tipo de contribuyente fue creado con exito.');
				$this->redirect(array('admin','model'=>$modelform));
			} else {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,
    				'<strong>Error  !!</strong>   -- No se ha podido crear el tipo de contribuyente.');
			}
		} 
		
		$model=new Tipodecontribuyente('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Tipodecontribuyente'])) {
			$model->attributes=$_GET['Tipodecontribuyente'];
		}

		$this->render('admin',array(
			'model'=>$model,
			'modelform'=>$modelform,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tipodecontribuyente the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tipodecontribuyente::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tipodecontribuyente $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='tipodecontribuyente-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionEditable()
    {
    	//Yii::import('ext.editable.EditableSaver'); //or you can add import 'ext.editable.*' to config
    	$es = new EditableSaver('Tipodecontribuyente'); // 'User' is classname of model to be updated
    	$es->update();
    }
}