<?php
/* @var $this DetallectacteclienteController */
/* @var $model Detallectactecliente */

$idctacte=$_GET['id'];
$nombre=$_GET['nombre'];
$detalleprov=Ctacteprov::model()->findByPk($idctacte);
$saldo=$detalleprov->saldo;

$this->breadcrumbs=array(
	'Detallectacteproveedores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Nueva Orden de Pago', 'url'=>Yii::app()->createUrl("ordendepago/create", 
			array('idctacte'=>$idctacte,'nombre'=>$nombre))),
			);

?>
<h5 class="well well-small">DETALLE CTA. CTE.:  <?php echo $_GET['nombre'];?></h5>

<?php
$model->ctacteprov_idctacteprov=$_GET['id'];

//para la barra de los años 
		if(!isset($_GET['anioTab'])){
				$anioTab=date('Y');
			}else{
				$anioTab=$_GET['anioTab'];
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
			$arregloTabs [] =array('label'=>$i, 'url'=>array('admin','id'=>$idctacte,'nombre'=>$nombre,'saldo'=>$saldo,'anioTab'=>$i),'active'=>$$varTemp);
			}
	
	// ---------------------------BARRA DE AÑOS----------------------------------		
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
		$arregloTabsMeses[]=array('label'=>$meses[$i][1],'content'=>$this->renderPartial('gridctacteprov', array('model'=>$model,'mesTab'=>$meses[$i][0],'anioTab'=>$anioTab,'model->ctacteprov_idctacteprov'=>$model->ctacteprov_idctacteprov), true),'active'=>$$varTempMes);
		}


	$this->widget('bootstrap.widgets.TbTabs', array(
		'type' => TbHtml::NAV_TYPE_TABS,
		'tabs'=>$arregloTabsMeses,
	));
?>