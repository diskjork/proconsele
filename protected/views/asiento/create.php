<?php
/* @var $this AsientoController */
/* @var $model Asiento */
?>

<?php
$this->breadcrumbs=array(
	'Asientos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Asiento', 'url'=>array('index')),
	array('label'=>'Manage Asiento', 'url'=>array('admin')),
);
?>

<h1>Nuevo asiento</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers)); ?>