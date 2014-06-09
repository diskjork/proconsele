<?php
/* @var $this CtacteprovController */
/* @var $model Ctacteprov */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteprovs'=>array('index'),
	$model->idctacteprov,
);

$this->menu=array(
	array('label'=>'List Ctacteprov', 'url'=>array('index')),
	array('label'=>'Create Ctacteprov', 'url'=>array('create')),
	array('label'=>'Update Ctacteprov', 'url'=>array('update', 'id'=>$model->idctacteprov)),
	array('label'=>'Delete Ctacteprov', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idctacteprov),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ctacteprov', 'url'=>array('admin')),
);
?>

<h1>View Ctacteprov #<?php echo $model->idctacteprov; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idctacteprov',
		'debe',
		'haber',
		'saldo',
		'proveedor_idproveedor',
	),
)); ?>