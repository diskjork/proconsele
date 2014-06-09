<?php
/* @var $this DetallectacteclienteController */
/* @var $model Detallectactecliente */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteclientes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Detallectactecliente', 'url'=>array('index')),
	array('label'=>'Manage Detallectactecliente', 'url'=>array('admin')),
);
?>

<h1>Create Detallectactecliente</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>