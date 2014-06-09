<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */
?>

<?php
$this->breadcrumbs=array(
	'Cobranzas'=>array('index'),
	$model->idcobranza=>array('view','id'=>$model->idcobranza),
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
	
<h5 class="well well-small">ACTUALIZAR COBRANZA</h5>
<br>
<?php $this->renderPartial('_form',array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers,'idctacte'=>$idctacte,'nombre'=>$nombre)); ?>