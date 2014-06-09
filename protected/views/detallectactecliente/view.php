<?php
/* @var $this DetallectacteclienteController */
/* @var $model Detallectactecliente */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteclientes'=>array('index'),
	$model->iddetallectactecliente,
);

$this->menu=array(
	array('label'=>'List Detallectactecliente', 'url'=>array('index')),
	array('label'=>'Create Detallectactecliente', 'url'=>array('create')),
	array('label'=>'Update Detallectactecliente', 'url'=>array('update', 'id'=>$model->iddetallectactecliente)),
	array('label'=>'Delete Detallectactecliente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->iddetallectactecliente),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Detallectactecliente', 'url'=>array('admin')),
);
?>

<h1>View Detallectactecliente #<?php echo $model->iddetallectactecliente; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'iddetallectactecliente',
		'fecha',
		'descripcion',
		'tipo',
		'iddocumento',
		'debe',
		'haber',
		'ctactecliente_idctactecliente',
	),
)); ?>