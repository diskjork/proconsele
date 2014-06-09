<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */
?>

<?php
$this->breadcrumbs=array(
	'Orden de pagos'=>array('index'),
	$model->idordendepago=>array('view','id'=>$model->idordendepago),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List Cobranza', 'url'=>array('index')),
	array('label'=>'Create Cobranza', 'url'=>array('create')),
	array('label'=>'View Cobranza', 'url'=>array('view', 'id'=>$model->idcobranza)),
	array('label'=>'Manage Cobranza', 'url'=>array('admin')),
);*/
?>
<?php 
if(isset($_GET['idctacte'])){
	$idctacte=$_GET['idctacte'];
	$nombre=$_GET['nombre'];
	
	} else{
	$idctacte=null;
	$nombre=null;
	
	}?>
	
<h5 class="well well-small">ACTUALIZAR ORDEN DE PAGO</h5>
<br>
<?php $this->renderPartial('_form',array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers,'idctacte'=>$idctacte,'nombre'=>$nombre,'modelchequecargado'=>$modelchequecargado)); ?>