<?php
/* @var $this DetallectacteclienteController */
/* @var $model Detallectactecliente */

$idctacte=$_GET['id'];
$nombre=$_GET['nombre'];
$detallecliente=Ctactecliente::model()->findByPk($idctacte);
$saldo=$detallecliente->saldo;

$this->breadcrumbs=array(
	'Detallectacteclientes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
		'label'=>'Ctas. Ctes. Cliente', 
		'url'=>Yii::app()->createUrl('ctactecliente/admin'),
	),
	array(
		'label'=>'Vista secuencial',
		'url'=>Yii::app()->createUrl('detallectactecliente/secuencial',array("id"=>$idctacte,"nombre"=>$nombre)
	)),
	
	array(
		'label'=>'Nueva Cobranza', 
		'url'=>Yii::app()->createUrl("cobranza/create")
		),
	array(
		'label'=>'Nueva Nota Crédito', 
		'url'=>Yii::app()->createUrl("notacredito/create")
		),	
	array(
		'label'=>'Nueva Nota Débito', 
		'url'=>Yii::app()->createUrl("notadebito/create")
		),
			);

?>

<h5 class="well well-small">CTA. CTE. - CLIENTE - <?php echo $_GET['nombre'];?></h5>


<br>
<?php // $this->renderPartial('gridctactecliente', array('model'=>$model,'idctacte'=>$idctacte)); ?>
<?php 
$model->ctactecliente_idctactecliente=$_GET['id'];

//para la barra de los a�os 
		if(!isset($_GET['anioTab'])){
				$anioTab=date('Y');
			}else{
				$anioTab=$_GET['anioTab'];
			}
		$anioInicio=2013;
		$anioSiguiente=date('Y')+1;
		$nomVar='modoActive';
		
		for ($i=$anioInicio;$i<$anioSiguiente;$i++){	
			$varTemp=$nomVar.$i;
			$$varTemp=false;
			
			if ($anioTab==$i){
				$$varTemp=true;
				}
			$arregloTabs [] =array('label'=>$i, 'url'=>array('admin','id'=>$idctacte,'nombre'=>$nombre,'anioTab'=>$i),'active'=>$$varTemp);
			}
	
	// ---------------------------BARRA DE A�OS----------------------------------		
		$this->widget('bootstrap.widgets.TbNav', array(
	    'type'=> TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
	    'stacked'=>false, // whether this is a stacked menu
	    'items'=>$arregloTabs,
		)); 
	//---------------------------------------------------------------		
	
	$meses=array(
		array('01','ENE'),array('02','FEB'),array('03','MAR'),array('04','ABR'),
		array('05','MAY'),array('06','JUN'),array('07','JUL'),array('08','AGO'),
		array('09','SET'),array('10','OCT'),array('11','NOV'),array('12','DIC'),
	);
	if(!isset($_GET['bancoid'])){
			//$_GET['anioTab']=0;
			$bancoid=1;
		}else{
			$bancoid=$_GET['bancoid'];
		}
	
	$nomVarMes='modoActive';
	for($i=0;$i<12;$i++){
		$varTempMes=$nomVarMes.$meses[$i][1];
		$$varTempMes=false;
		if (date('m')==$meses[$i][0]){
			$$varTempMes=true;
		}
		$arregloTabsMeses[]=array('label'=>$meses[$i][1],'content'=>$this->renderPartial('gridctactecliente', array('model'=>$model,'mesTab'=>$meses[$i][0],'anioTab'=>$anioTab,'model->ctactecliente_idctactecliente'=>$model->ctactecliente_idctactecliente,'nombre'=>$nombre), true),'active'=>$$varTempMes);
		}


	$this->widget('bootstrap.widgets.TbTabs', array(
		'type' => TbHtml::NAV_TYPE_TABS,
		'tabs'=>$arregloTabsMeses,
	));
?>