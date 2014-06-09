<?php
/* @var $this CtacteclienteController */
/* @var $model Ctactecliente */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteclientes'=>array('index'),
	$model->idctactecliente=>array('view','id'=>$model->idctactecliente),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ctactecliente', 'url'=>array('index')),
	array('label'=>'Create Ctactecliente', 'url'=>array('create')),
	array('label'=>'View Ctactecliente', 'url'=>array('view', 'id'=>$model->idctactecliente)),
	array('label'=>'Manage Ctactecliente', 'url'=>array('admin')),
);
?>

    <h1>Update Ctactecliente <?php echo $model->idctactecliente; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>