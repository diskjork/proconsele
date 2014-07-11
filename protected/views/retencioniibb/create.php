<?php
/* @var $this RetencioniibbController */
/* @var $model Retencioniibb */
?>

<?php
$this->breadcrumbs=array(
	'Retencioniibbs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Retencioniibb', 'url'=>array('index')),
	array('label'=>'Manage Retencioniibb', 'url'=>array('admin')),
);
?>

<h1>Create Retencioniibb</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>