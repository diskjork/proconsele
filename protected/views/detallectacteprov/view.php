<?php
/* @var $this DetallectacteprovController */
/* @var $model Detallectacteprov */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteprovs'=>array('index'),
	$model->iddetallectacteprov,
);

$this->menu=array(
	array('label'=>'List Detallectacteprov', 'url'=>array('index')),
	array('label'=>'Create Detallectacteprov', 'url'=>array('create')),
	array('label'=>'Update Detallectacteprov', 'url'=>array('update', 'id'=>$model->iddetallectacteprov)),
	array('label'=>'Delete Detallectacteprov', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->iddetallectacteprov),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Detallectacteprov', 'url'=>array('admin')),
);
?>

<h1>View Detallectacteprov #<?php echo $model->iddetallectacteprov; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'iddetallectacteprov',
		'fecha',
		'descripcion',
		'tipo',
		'iddocumento',
		'debe',
		'haber',
		'ctacteprov_idctacteprov',
	),
)); ?>