<?php

class ChequeController extends Controller
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
				'actions'=>array('admin','delete','debitar','labelEstado','acreditar','acreditarcaja','listabanco'),
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
		$model=new Cheque;
		
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if (isset($_POST['Cheque'])) {
			
			$model->attributes=$_POST['Cheque'];
				if($model->debeohaber == 0){
					$model->estado=2;
					$model->debe= $this->cargaImporte($_POST['Cheque']['importe']);
					
				} elseif($model->debeohaber == 1){
					$model->estado=0;
					$model->haber= $this->cargaImporte($_POST['Cheque']['importe']);
				}
			if ($model->save()) {
				$this->redirect('admin');
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
		if($model->debeohaber == 0){
			$model->importe=$model->debe;
		} elseif($model->debeohaber == 1){
			$model->importe=$model->haber;
		}
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['Cheque'])) {
			if($model->debeohaber != $_POST['Cheque']['debeohaber']){
				if($_POST['Cheque']['debeohaber'] == 1){
					$_POST['Cheque']['debe']= NULL;
					$_POST['Cheque']['cliente_idcliente']=NULL;
					
					}
				if($_POST['Cheque']['debeohaber'] == 0){
					$_POST['Cheque']['haber']= NULL;
					$_POST['Cheque']['proveedor_idproveedor']=NULL;
					}
			}
			
			$model->attributes=$_POST['Cheque'];
				if($model->debeohaber == 0){
					$model->debe= $this->cargaImporte($_POST['Cheque']['importe']);
					//$model->debe= $_POST['Cheque']['importe'];
					$model->estado=2;
				} elseif($model->debeohaber == 1){
					$model->haber= $this->cargaImporte($_POST['Cheque']['importe']);
					//$model->haber= $_POST['Cheque']['importe'];
					$model->estado=0;
				}
		
			if ($model->save()) 
				
				$this->redirect(Yii::app()->request->baseUrl.'/cheque/admin');
			
			
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
		$dataProvider=new CActiveDataProvider('Cheque');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionEmitido()
	{
		$model=new Cheque('search');
		$modelBanco=new Banco;
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cheque'])) {
			$model->attributes=$_GET['Cheque'];
		}
		if (isset($_POST['Banco'])) {
			$modelBanco->attributes=$_POST['Banco'];
			if ($modelBanco->save()) {
				$this->redirect(array('admin'));
			}
		}
		//-----------

		$this->render('emitido',array(
			'model'=>$model,
			'modelBanco'=>$modelBanco,
		));
	}
	public function actionRecibido()
	{
		$model=new Cheque('search');
		$modelBanco=new Banco;
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cheque'])) {
			$model->attributes=$_GET['Cheque'];
		}
		if (isset($_POST['Banco'])) {
			$modelBanco->attributes=$_POST['Banco'];
			if ($modelBanco->save()) {
				$this->redirect(array('admin'));
			}
		}
		//-----------

		$this->render('recibido',array(
			'model'=>$model,
			'modelBanco'=>$modelBanco,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cheque the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cheque::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cheque $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='cheque-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
public function cargaImporte($arr){
		$temp=$arr;
		$temp = str_replace(",","",$temp); //borro los separadores de miles, si hay
 		if(settype($temp,"double"))
			return $temp;	
	
}
public function cargaEstado($arr){
			if($arr['debeohaber']==0){
				$arr['estado']=2; //a cobrar
				return $arr;
			} else {
				$arr['estado']=0; //a pagar
				return $arr;
				}
	}
/**
 * action para debitar cheque del Banco
 * @param unknown_type $arr
 * @return number
 */
public function actionDebitar($id){
	
	$model=$this->loadModel($id); //cheque a debitar
	$modelBanco= new Movimientobanco; //movimientobanco
		if(isset($_POST['Cheque'],$_POST['Movimientobanco'])){
						$modelBanco->attributes=$_POST['Movimientobanco'];
						$model->attributes=$_POST['Cheque'];
						
						$array = array('check' => 'success');
						
						if($modelBanco->save()){
							if($model->save()){
					            	$json = json_encode($array);
					            	echo $json;
					            	Yii::app()->end(); 
									$this->redirect(Yii::app()->request->baseUrl.'/cheque/admin');
									}
						}else {
							echo CActiveForm::validate($modelBanco);
				           	Yii::app()->end();
							}
		}	
	$this->render('debitar',array(
			'model'=>$model,
			'modelBanco'=>$modelBanco,
		));
	}
public function labelEstado($data, $row){	
	switch ($data->estado){
			case '0':
				$text="A pagar";
				return $text;
				break;
			case '1':
				$text="Pagado";
				return $text;
				break;
			case '2':
				$text="A cobrar";
				return $text;
				break;
			case '3':
				$text="Cobrado-Caja";
				return $text;
				break;
			case '4':
				$text="Endozado";
				return $text;
				break;
			case '5':
				$text="Cobrado-Banco";
				return $text;
				break;
		}
	}
	public function actionAcreditar($id){
		$model=$this->loadModel($id);
	    $modelBanco= new Movimientobanco;
		
		if(isset($_POST['Cheque'],$_POST['Movimientobanco'])){
						$modelBanco->attributes=$_POST['Movimientobanco'];
						$model->attributes=$_POST['Cheque'];
						
						$array = array('check' => 'success');
						if($modelBanco->save()){
							if($model->save()){
					            	$json = json_encode($array);
					            	echo $json;
					            	Yii::app()->end(); 
									$this->redirect(Yii::app()->request->baseUrl.'/cheque/admin');
									}
						}else {
							echo CActiveForm::validate($modelBanco);
				           	Yii::app()->end();
							}
		}	
		
		$this->render('acreditar',array(
			'model'=>$model,
			'modelBanco'=>$modelBanco,
		));
		
	}
	public function actionAcreditarCaja($id){
		$modelCheque=$this->loadModel($id);
		$modelCaja= new Movimientocaja;
		
		if(isset($_POST['Cheque'],$_POST['Movimientocaja'])){
			
						$modelCaja->attributes=$_POST['Movimientocaja'];
						$modelCheque->attributes=$_POST['Cheque'];
						$array = array('check' => 'success');
						$array2 = array('check'=> 'caja');
						
						if($modelCaja->save()){
							
							if($modelCheque->save()){
								$this->nuevoAsientoCaja($modelCheque, $_POST['Movimientocaja']['fecha'],$modelCaja);
				            	$json = json_encode($array);
				            	echo $json;
				            	Yii::app()->end(); 
								$this->redirect(Yii::app()->request->baseUrl.'/cheque/recibido');
								}
						}else {
							
							echo CActiveForm::validate($modelCaja);
							
				           	Yii::app()->end();
							}	
			} 
		$this->render('acreditarcaja',array(
			'modelCaja'=>$modelCaja,
			'modelCheque'=>$modelCheque,
			
		));
	}
	public function compararFechas($primera,$segunda)
	 {
	  $valoresPrimera = explode ("/", $primera);   
	  $valoresSegunda = explode ("/", $segunda); 

	  $diaP = $valoresPrimera[0];  
	  $mesP = $valoresPrimera[1];  
	  $anyoP = $valoresPrimera[2]; 
		
	  $diaS = $valoresSegunda[0];  
	  $mesS = $valoresSegunda[1];  
	  $anyoS = $valoresSegunda[2];
	
	  $diasPJuliano = gregoriantojd($mesP, $diaP, $anyoP);  
	  $diasSJuliano = gregoriantojd($mesS, $diaS, $anyoS);     
	  
	  if(!checkdate($mesP, $diaP, $anyoP)){
	    // "La fecha ".$primera." no es v&aacute;lida";
	    return 0;
	  }elseif(!checkdate($mesS, $diaS, $anyoS)){
	    // "La fecha ".$segunda." no es v&aacute;lida";
	     return 0;
	  }else{
	   return $diasPJuliano-$diasSJuliano;
	     }
	}
	
	public function actionAcreditarendozar($id){
		Yii::import('ext.multimodelform.MultiModelForm');
		$modelCheque=$this->loadModel($id);
		$model = new Ordendepago;
 		$member = new Detalleordendepago;
   		 $validatedMembers = array();  //ensure an empty array
 	
    if(isset($_POST['Ordendepago']))
    {
    	
    	
        $model->attributes=$_POST['Ordendepago'];
	        
	    if(isset($_POST['Cheque'])){
	 		$modelCheque->estado=4;
	 		$modelCheque->proveedor_idproveedor=$model->ctacteprov_idctacteprov;
	 		$modelCheque->save();
	 	}
 		
        if( //validate detail before saving the master
            MultiModelForm::validate($member,$validatedMembers,$deleteItems) &&
            $model->save()
           )
           
           {
             //the value for the foreign key 'groupid'
             $masterValues = array ('ordendepago_idordendepago'=>$model->idordendepago);
             if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
             {
             	
          //para  sumar en el haber de cta cte del PROVEEDOR----------
          
			$idctacteprov=$model->ctacteprov_idctacteprov;
			$importeDetalle=$_POST['Ordendepago']['importe'];
			$this->incrementoCtacte($idctacteprov, $importeDetalle);
			
//para generar el modelo de detallectacteprov que corresponde a la nueva ordendepago
			$proveedor=$this->idProveedor($model->ctacteprov_idctacteprov);
			$modelDeCCprov= new Detallectacteprov;
           	$modelDeCCprov->fecha=$_POST['Ordendepago']['fecha'];
           	$modelDeCCprov->descripcion="ORDEN DE PAGO - Cheque endozado Nro:".$model->idordendepago."";
           	$modelDeCCprov->tipo= 1; //tipo ordendepago,0 para compra
           	$modelDeCCprov->iddocumento=$model->idordendepago;
           	$modelDeCCprov->haber=$model->importe;
           	$modelDeCCprov->ctacteprov_idctacteprov=$model->ctacteprov_idctacteprov;
           	$modelDeCCprov->save();
             	
             $this->redirect(array('admin'));
             }
            }
            
    }
		
		$this->render('acreditarendozar',array(
			'modelcheque'=>$modelCheque,
			'model'=>$model,
	        //submit the member and validatedItems to the widget in the edit form
	        'member'=>$member,
	        'validatedMembers' => $validatedMembers,
			
		));
	}
	public function incrementoCtacte($idctacte,$importe){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctacteprov', array(
				    'ctacteprov.haber'=>new CDbExpression('ctacteprov.haber + '.$importe),
				), 'idctacteprov='.$idctacte);
		$this->updateSaldoCtaCte($idctacte);
 	}
	public function updateSaldoCtaCte($idctacte){
 		$command = Yii::app()->db->createCommand();
				$command->update('ctacteprov', array(
				    'ctacteprov.saldo'=>new CDbExpression('ROUND(ctacteprov.debe - ctacteprov.haber,2)'),
				), 'idctacteprov='.$idctacte);
 	}
	public function idProveedor($idctacte){
		$sql="SELECT proveedor.idproveedor as idprov, proveedor.nombre AS nombreprov  FROM proveedor,ctacteprov,ordendepago 
				WHERE proveedor.idproveedor =ctacteprov.proveedor_idproveedor and  ctacteprov.idctacteprov = ".$idctacte." LIMIT 1;";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$resultado = $dbCommand->queryAll();
			//$nombreprov=$resultado[0]['nombreproveedor'];
		
		return $resultado;
	}
	
	public function actionExcel(){
                $model=new Cheque('search');
                	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->Search(),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Cheques ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Cheques ' . date('m-d-Y H-i'),
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
               				'name' => 'nrocheque',
							'header' => 'NRO. CHEQUE',
						),
						array(
							'name' => 'fechaingreso',
							'header' => 'F.RECEPCIÓN',
						),
						array(
							'name' => 'fechacobro',
							'header' => 'F.COBRO',
						),
						array(
							'header'=>'ENTIDAD',
							'value'=>'$data->proveedor_idproveedor != NULL ? $data->proveedorIdproveedor : $data->clienteIdcliente',
						),
						array(
							'header' => 'BANCO',
							'value'=> '$data->bancoIdBanco',
						),	
						array(	
							'header' => 'RECIBIDO',
							'value'=>'($data->debe !== null)?number_format($data->debe, 2, ",", "."): ""',			
						),
						array(
							'header' => 'EMITIDO',
							'value'=>'($data->haber !== null)?number_format($data->haber, 2, ",", "."): ""',
						),	
						/*array(
							'value'=>'proveedorIdproveedor',
							'header'=>'PROVEEDOR',
							'visible'=>$model->proveedor_idproveedor != NULL,
						),
						array(
							'value'=>'clienteIdcliente',
							'header'=>'CLIENTE',
							'visible'=>$model->cliente_idcliente != NULL,
						),*/
						array(
							'header' => 'ESTADO',
							'value'=>array($this,'labelEstado'),
						),
               	
					) 
				)); 
               
        	
	}
	
	public function actionEndosados()
	{
		
		$model=new Cheque('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Cheque'])) {
			$model->attributes=$_GET['Cheque'];
		}

		$this->render('endosados',array(
			'model'=>$model,
			
		));
	}
	
	public function actionExcelEndosados(){
                $model=new Cheque('search');
                	
               	$this->widget('application.components.widgets.EExcelView', array(
                	
				    'id'                   => 'some-grid',
				    'dataProvider'		   => $model->Search($model->estado=4),
				    'grid_mode'            => 'export', // Same usage as EExcelView v0.33
				    //'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
				    'title'                => 'Endosados ' . date('d-m-Y'),
				    'creator'              => 'YVN',
				    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
				    'description'          => mb_convert_encoding('Etat de production g�n�r� � la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
				    'lastModifiedBy'       => 'YVN',
				    'sheetTitle'           => 'Endosados ' . date('m-d-Y H-i'),
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
               				'name' => 'nrocheque',
							'header' => 'NRO. CHEQUE',
						),
						array(
							'name' => 'fechaingreso',
							'header' => 'F.RECEPCIÓN',
						),
						array(
							'name' => 'fechacobro',
							'header' => 'F.COBRO',
						),
						array(
							'header'=>'RECIBIDO DE',
							'value'=>'$data->clienteIdcliente',
						),
						array(
							'header'=>'CUIT LIBERADOR',
							'value'=>'$data->clienteIdcliente->cuit',
						),			
						array(
							'header'=>'ENTREGADO A',
							'value'=>'$data->proveedorIdproveedor',
						),
						array(
							'header'=>'CUIT ACREEDOR',
							'value'=>'$data->proveedorIdproveedor->cuit',
						),
						array(
							'header' => 'BANCO',
							'value'=> '$data->bancoIdBanco',
						),	
						array(	
							'header' => 'RECIBIDO',
							'value'=>'($data->debe !== null)?number_format($data->debe, 2, ",", "."): ""',			
						),
						/*array(
							'header' => 'EMITIDO',
							'value'=>'($data->haber !== null)?number_format($data->haber, 2, ",", "."): ""',
						),	
						/*array(
							'value'=>'proveedorIdproveedor',
							'header'=>'PROVEEDOR',
							'visible'=>$model->proveedor_idproveedor != NULL,
						),
						array(
							'value'=>'clienteIdcliente',
							'header'=>'CLIENTE',
							'visible'=>$model->cliente_idcliente != NULL,
						),*/
						/*array(
							'header' => 'ESTADO',
							'value'=>array($this,'labelEstado'),
						),*/
               	
					) 
				)); 
               
        	
	}
	public function actionListabanco(){
		$tipocheque=$_POST['data'];
		if($tipocheque == 1){
			$listabancos=Banco::model()->findAllAttributes(array('nombre'),true,array('condition'=>'propio=:tipocheque','order'=>'nombre ASC','params'=>array(':tipocheque'=>$tipocheque)));
			
			foreach($listabancos as $value=>$valor)
		    {
		    	
		    	
		        echo CHtml::tag('option',array('value'=>$valor->idBanco),CHtml::encode($valor->nombre),true);
		    }
		} else {
			$listabancos=Banco::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC'));
			foreach($listabancos as $value=>$valor)
		    {
		    	
		    	
		        echo CHtml::tag('option',array('value'=>$valor->idBanco),CHtml::encode($valor->nombre),true);
		    }
		}
	}
	
	/**
	 * Método para generar el asiento en el caso de acreditar un cheque de tercero por ventanilla
	 * 
	 */
	public function nuevoAsientoCaja($cheque, $fecha, $movcaja){
		$asiento=new Asiento;
		$asiento->descripcion="Cobro de cheque N°: ".$cheque->nrocheque." de: ".$cheque->clienteIdcliente;
		$asiento->fecha=$fecha;
		$asiento->movimientocaja_idmovimientocaja=$movcaja->idmovimientocaja;
		if($asiento->save()){
			$DeAsCaja=new Detalleasiento;
			$DeAsRel=new Detalleasiento;
			$DeAsCaja->debe=$cheque->debe;
			$DeAsCaja->cuenta_idcuenta=$movcaja->cajaIdcaja->cuenta_idcuenta;
			$DeAsCaja->asiento_idasiento=$asiento->idasiento;
			$DeAsRel->haber=$cheque->debe;
			$DeAsRel->cuenta_idcuenta=5; //cuenta cheque de 3ros a cobrar
			$DeAsRel->asiento_idasiento=$asiento->idasiento;
			if($DeAsCaja->save()){
				if($DeAsRel->save()){
					return true;
				} else {
				print_r($DeAsRel->getErrors()); die();
				}
			} else {
				print_r($DeAsCaja->getErrors()); die();
			}
		} else {
			print_r($asiento->getErrors()); die();
			return false;
		}
	}
	
}//end app