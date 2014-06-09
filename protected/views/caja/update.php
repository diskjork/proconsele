<?php
/* @var $this CajaController */
/* @var $model Caja */
?>

<?php
$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	$model->idcaja=>array('view','id'=>$model->idcaja),
	'Update',
);

$this->menu=array(
	array('label'=>'List Caja', 'url'=>array('index')),
	array('label'=>'Create Caja', 'url'=>array('create')),
	array('label'=>'View Caja', 'url'=>array('view', 'id'=>$model->idcaja)),
	array('label'=>'Manage Caja', 'url'=>array('admin')),
);
?>

    <h1>Update Caja <?php echo $model->idcaja; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>