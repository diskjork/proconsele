<?php
/* @var $this BancoController */
/* @var $model Banco */
?>

<?php
$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	$model->idBanco=>array('view','id'=>$model->idBanco),
	'Update',
);

$this->menu=array(
	array('label'=>'List Banco', 'url'=>array('index')),
	array('label'=>'Create Banco', 'url'=>array('create')),
	array('label'=>'View Banco', 'url'=>array('view', 'id'=>$model->idBanco)),
	array('label'=>'Manage Banco', 'url'=>array('admin')),
);
?>

    <h1>Update Banco <?php echo $model->idBanco; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>