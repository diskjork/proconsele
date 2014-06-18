<?php
/* @var $this CajaController */
/* @var $model Caja */
?>

<?php
$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	$model->idcaja,
);

$this->menu=array(
	array('label'=>'List Caja', 'url'=>array('index')),
	array('label'=>'Create Caja', 'url'=>array('create')),
	array('label'=>'Update Caja', 'url'=>array('update', 'id'=>$model->idcaja)),
	array('label'=>'Delete Caja', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idcaja),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Caja', 'url'=>array('admin')),
);
?>

<h1>View Caja #<?php echo $model->idcaja; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idcaja',
		'nombre',
		'descripcion',
		'estado',
		'cuenta_idcuenta',
	),
)); ?>