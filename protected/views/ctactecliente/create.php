<?php
/* @var $this CtacteclienteController */
/* @var $model Ctactecliente */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteclientes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ctactecliente', 'url'=>array('index')),
	array('label'=>'Manage Ctactecliente', 'url'=>array('admin')),
);
?>

<h1>Create Ctactecliente</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>