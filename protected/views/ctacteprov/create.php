<?php
/* @var $this CtacteprovController */
/* @var $model Ctacteprov */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteprovs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ctacteprov', 'url'=>array('index')),
	array('label'=>'Manage Ctacteprov', 'url'=>array('admin')),
);
?>

<h1>Create Ctacteprov</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>