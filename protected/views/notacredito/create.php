<?php
/* @var $this NotacreditoController */
/* @var $model Notacredito */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditos'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Administrar', 'url'=>array('admin')),
);
?>

<h5 class="well well-small">CARGAR NUEVA NOTA DE CREDITO</h5>
<br><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>