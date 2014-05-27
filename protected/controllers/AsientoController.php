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
	
/*	public function actionGrilla($id)
	{
		$model=Detalleasiento::model()->findAll('asiento_idasiento=:idasiento',array(':idasiento'=>$id));
		$this->render('gridasiento',array(
			'model'=>$model,
		));
	}*/
}