<?php
/* @var $this DetallectacteclienteController */
/* @var $model Detallectactecliente */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteclientes'=>array('index'),
	$model->iddetallectactecliente=>array('view','id'=>$model->iddetallectactecliente),
	'Update',
);

$this->menu=array(
	array('label'=>'List Detallectactecliente', 'url'=>array('index')),
	array('label'=>'Create Detallectactecliente', 'url'=>array('create')),
	array('label'=>'View Detallectactecliente', 'url'=>array('view', 'id'=>$model->iddetallectactecliente)),
	array('label'=>'Manage Detallectactecliente', 'url'=>array('admin')),
);
?>

    <h1>Update Detallectactecliente <?php echo $model->iddetallectactecliente; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>