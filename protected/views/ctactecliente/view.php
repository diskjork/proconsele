<?php
/* @var $this CtacteclienteController */
/* @var $model Ctactecliente */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteclientes'=>array('index'),
	$model->idctactecliente,
);

$this->menu=array(
	array('label'=>'List Ctactecliente', 'url'=>array('index')),
	array('label'=>'Create Ctactecliente', 'url'=>array('create')),
	array('label'=>'Update Ctactecliente', 'url'=>array('update', 'id'=>$model->idctactecliente)),
	array('label'=>'Delete Ctactecliente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idctactecliente),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ctactecliente', 'url'=>array('admin')),
);
?>

<h1>View Ctactecliente #<?php echo $model->idctactecliente; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idctactecliente',
		'cliente_idcliente',
		'debe',
		'haber',
		'saldo',
	),
)); ?>