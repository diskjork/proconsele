<?php
/* @var $this IvamovimientoController */
/* @var $model Ivamovimiento */
?>

<?php
$this->breadcrumbs=array(
	'Ivamovimientos'=>array('index'),
	$model->idivamovimiento=>array('view','id'=>$model->idivamovimiento),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ivamovimiento', 'url'=>array('index')),
	array('label'=>'Create Ivamovimiento', 'url'=>array('create')),
	array('label'=>'View Ivamovimiento', 'url'=>array('view', 'id'=>$model->idivamovimiento)),
	array('label'=>'Manage Ivamovimiento', 'url'=>array('admin')),
);
?>

    <h1>Update Ivamovimiento <?php echo $model->idivamovimiento; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>