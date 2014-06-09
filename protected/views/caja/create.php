<?php
/* @var $this CajaController */
/* @var $model Caja */
?>

<?php
$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Caja', 'url'=>array('index')),
	array('label'=>'Manage Caja', 'url'=>array('admin')),
);
?>

<h1>Create Caja</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>