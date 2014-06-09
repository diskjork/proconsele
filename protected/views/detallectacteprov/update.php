<?php
/* @var $this DetallectacteprovController */
/* @var $model Detallectacteprov */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteprovs'=>array('index'),
	$model->iddetallectacteprov=>array('view','id'=>$model->iddetallectacteprov),
	'Update',
);

$this->menu=array(
	array('label'=>'List Detallectacteprov', 'url'=>array('index')),
	array('label'=>'Create Detallectacteprov', 'url'=>array('create')),
	array('label'=>'View Detallectacteprov', 'url'=>array('view', 'id'=>$model->iddetallectacteprov)),
	array('label'=>'Manage Detallectacteprov', 'url'=>array('admin')),
);
?>

    <h1>Update Detallectacteprov <?php echo $model->iddetallectacteprov; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>