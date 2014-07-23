<?php
/* @var $this NotacreditoController */
/* @var $model Notacredito */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditos'=>array('index'),
	$model->idnotacredito=>array('view','id'=>$model->idnotacredito),
	'Update',
);

$this->menu=array(
	array('label'=>'Administrar', 'url'=>array('admin')),
	array('label'=>'Nueva Nota Credito', 'url'=>array('create')),
	
);
?>

 <h5 class="well well-small">ACTUALIZAR NOTA DE CREDITO</h5>
<br><br>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>