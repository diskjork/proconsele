<?php
/* @var $this CtacteprovController */
/* @var $model Ctacteprov */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteprovs'=>array('index'),
	$model->idctacteprov=>array('view','id'=>$model->idctacteprov),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ctacteprov', 'url'=>array('index')),
	array('label'=>'Create Ctacteprov', 'url'=>array('create')),
	array('label'=>'View Ctacteprov', 'url'=>array('view', 'id'=>$model->idctacteprov)),
	array('label'=>'Manage Ctacteprov', 'url'=>array('admin')),
);
?>

    <h1>Update Ctacteprov <?php echo $model->idctacteprov; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>