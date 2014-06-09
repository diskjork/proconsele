<?php
/* @var $this EmpresaController */
/* @var $model Empresa */
?>

<?php
$this->breadcrumbs=array(
	'Empresas'=>array('index'),
	$model->idempresa=>array('view','id'=>$model->idempresa),
	'Update',
);

$this->menu=array(
	array('label'=>'List Empresa', 'url'=>array('index')),
	array('label'=>'Create Empresa', 'url'=>array('create')),
	array('label'=>'View Empresa', 'url'=>array('view', 'id'=>$model->idempresa)),
	array('label'=>'Manage Empresa', 'url'=>array('admin')),
);
?>

    <h1>Update Empresa <?php echo $model->idempresa; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>