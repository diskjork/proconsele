<?php
/* @var $this IvamovimientoController */
/* @var $model Ivamovimiento */
?>

<?php
$this->breadcrumbs=array(
	'Ivamovimientos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ivamovimiento', 'url'=>array('index')),
	array('label'=>'Manage Ivamovimiento', 'url'=>array('admin')),
);
?>

<h1>Create Ivamovimiento</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>