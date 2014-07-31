<?php
/* @var $this NotacreditoprovController */
/* @var $model Notacreditoprov */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditoprovs'=>array('index'),
	$model->idnotacreditoprov=>array('view','id'=>$model->idnotacreditoprov),
	'Update',
);

$this->menu=array(
	array('label'=>'Administrar', 'url'=>array('admin')),
	array('label'=>'Nueva Nota Credito', 'url'=>array('create')),
	
);
?>

 <h5 class="well well-small">ACTUALIZAR NOTA DE CREDITO - PROVEEDOR</h5>
<br><br>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>