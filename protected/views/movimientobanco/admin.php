<?php
/* @var $this MovimientobancoController */
/* @var $model Movimientobanco */


$this->breadcrumbs=array(
	'Movimientos de Banco'=>array('index'),
	'Vista',
);
?>
<?php
$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nuevo', 
		'url'=>array('create'),
	),
);

$this->nav=$this->checkCtabancaria($model);

?>

<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'myModal',
    'header' => 'Nuevo',
	'content' => $this->renderPartial('_form',array('model'=>$modelform), true),
 )); 
?>

<?php if(isset($this->nav)){
		if($this->nav !== 0){
		 echo "	<h5 class='well well-small'>MOVIMIENTOS DE BANCO</h5><br>";
				
		 if(!isset($_GET['bancoIdTab'])){
				$bancoIdTab=0;
		}else{
				$bancoIdTab=$_GET['bancoIdTab'];
			}
		 
		$bancoVar='modoActive';
		for($i=0;$i<count($this->nav);$i++){
			$bancoTem=$bancoVar.$this->nav[$i]['idctabancaria'];
			$$bancoTem=false;
			if($bancoIdTab==$i){
				$$bancoTem=true;
			}
				$bancoNav []=array('label'=>$this->nav[$i]['nombre'],'url'=>array('admin','bancoIdTab'=>$i,'bancoid'=>$this->nav[$i]['idctabancaria']),'active'=>$$bancoTem);
			
		};
		 
		 
//--------------------------BARRA DE CTABANCARIAS CARGADOS-------------------
		$this->widget('bootstrap.widgets.TbNav', array(
	    'type' => TbHtml::NAV_TYPE_TABS,
	    'items' => $bancoNav,
		'activateItems'=> true,
	     )); 
//---------------------------------------------------------------------
		
//para la barra de los a�os 
		if(!isset($_GET['anioTab'])){
				//$_GET['anioTab']=0;
				$anioTab=date('Y');
			}else{
				$anioTab=$_GET['anioTab'];
			}
		if(!isset($_GET['bancoid'])){
			//$_GET['anioTab']=0;
			$bancoid=1;
		}else{
			$bancoid=$_GET['bancoid'];
		}
		
		$anioInicio=2014;
		$anioSiguiente=date('Y')+1;
		$nomVar='modoActive';
		
		for ($i=$anioInicio;$i<$anioSiguiente;$i++){	
			$varTemp=$nomVar.$i;
			$$varTemp=false;
			
			if ($anioTab==$i){
				$$varTemp=true;
				}
			$arregloTabs [] =array('label'=>$i, 'url'=>array('admin','anioTab'=>$i,'bancoid'=>$bancoid, 'bancoIdTab'=>$bancoIdTab),'active'=>$$varTemp);
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
		
		$arregloTabsMeses[]=array('label'=>$meses[$i][1],'content'=>$this->renderPartial('gridmovimientobanco', array('model'=>$model,'bancoid'=>$bancoid,'anioTab'=>$anioTab,'mesTab'=>$meses[$i][0],), true),'active'=>$$varTempMes);
		}
	//print_r($arregloTabsMeses);
	
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type' => TbHtml::NAV_TYPE_TABS,
		'tabs'=>$arregloTabsMeses,
	));
	
	} else {
		echo "<h1> Debe Cargar al menos una cuenta bancaria para comenzar a operar </h1>";
		}
	}
?>
<?php 

    $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'viewModal',
    'header' => '<h4>Detalle de movimiento</h4>',
    'fade'=>false,	
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
    
?>
