<?php
/* @var $this CuentaController */
/* @var $model Cuenta */
?>

<?php
$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	$model->idcuenta=>array('view','id'=>$model->idcuenta),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cuenta', 'url'=>array('index')),
	array('label'=>'Create Cuenta', 'url'=>array('create')),
	array('label'=>'View Cuenta', 'url'=>array('view', 'id'=>$model->idcuenta)),
	array('label'=>'Manage Cuenta', 'url'=>array('admin')),
);
?>

    <h1>Update Cuenta <?php echo $model->idcuenta; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>