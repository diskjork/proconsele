
<?php
/* @var $this AsientoController */
/* @var $model Asiento */
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/asiento.js', CClientScript::POS_HEAD);
$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nuevo asiento', 
		'url'=>array('/asiento/create'),
	),
);
?>

<h5 class="well well-small">ASIENTOS</h5>

<!-- search-form -->
<?php 

				 
		//para la barra de los años 
		if(!isset($_GET['anioTab'])){
				//$_GET['anioTab']=0;
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
			$arregloTabs [] =array('label'=>$i, 'url'=>array('admin','anioTab'=>$i),'active'=>$$varTemp);
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
	
	
	$nomVarMes='modoActive';
	for($i=0;$i<12;$i++){
		$varTempMes=$nomVarMes.$meses[$i][1];
		$$varTempMes=false;
		if (date('m')==$meses[$i][0]){
			$$varTempMes=true;
		}
		$arregloTabsMeses[]=array('label'=>$meses[$i][1],'content'=>$this->renderPartial('gridadmin', array('model'=>$model,'anioTab'=>$anioTab,'mesTab'=>$meses[$i][0],), true),'active'=>$$varTempMes);
		}
	//print_r($arregloTabsMeses);
	
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type' => TbHtml::NAV_TYPE_TABS,
		'tabs'=>$arregloTabsMeses,
	));
	
	
	
?>








