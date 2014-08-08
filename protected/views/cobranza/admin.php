<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */


$this->breadcrumbs=array(
	'Cobranzas'=>array('index'),
	'Manage',
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
		'label'=>'Volver a Cte Cte', 
		'url'=>Yii::app()->createUrl('ctactecliente/admin'),
	),
);
?>
<?php
//////////////ALERT TEMPORIZADO////////////////////
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").delay(2000).fadeOut("slow");',
   	CClientScript::POS_READY
);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div id="bloqueAlert">
	    <div id="myAlert" class="alert alert-success fade in info estiloAlert" data-alert="alert">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
    </div>
<?php endif; 
///////////////////////////////////////////////////
?>

<h5 class="well well-small">COBRANZAS</h5>

<?php
//para la barra de los a�os 
		if(!isset($_GET['anioTab'])){
				//$_GET['anioTab']=0;
				$anioTab=date('Y');
			}else{
				$anioTab=$_GET['anioTab'];
			}
		//$minmax=2012;
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
		$arregloTabsMeses[]=array('label'=>$meses[$i][1],'content'=>$this->renderPartial('gridcobranza', array('model'=>$model,'mesTab'=>$meses[$i][0],'anioTab'=>$anioTab), true),'active'=>$$varTempMes);
		}


	$this->widget('bootstrap.widgets.TbTabs', array(
		'type' => TbHtml::NAV_TYPE_TABS,
		'tabs'=>$arregloTabsMeses,
	));
?>



<?php /*$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'cobranza-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idcobranza',
		'fecha',
		'descripcioncobranza',
		'importe',
		array(
			'name'=> 'ctactecliente_idctactecliente',
			'header'=>'Cliente',
			'value'=>array($this,'gridNombreCliente'),
				
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); */?>
