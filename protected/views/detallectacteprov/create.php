<?php
/* @var $this DetallectacteprovController */
/* @var $model Detallectacteprov */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteprovs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Detallectacteprov', 'url'=>array('index')),
	array('label'=>'Manage Detallectacteprov', 'url'=>array('admin')),
);
?>

<h1>Create Detallectacteprov</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>