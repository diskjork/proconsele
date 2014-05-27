<?php
/* @var $this AsientoController */
/* @var $model Asiento */
?>

<?php
$this->breadcrumbs=array(
	'Asientos'=>array('index'),
	$model->idasiento=>array('view','id'=>$model->idasiento),
	'Update',
);

$this->menu=array(
	array('label'=>'List Asiento', 'url'=>array('index')),
	array('label'=>'Create Asiento', 'url'=>array('create')),
	array('label'=>'View Asiento', 'url'=>array('view', 'id'=>$model->idasiento)),
	array('label'=>'Manage Asiento', 'url'=>array('admin')),
);
?>

    <h1>Update Asiento <?php echo $model->idasiento; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers)); ?>