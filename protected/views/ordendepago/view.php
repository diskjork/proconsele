<?php
/* @var $this OrdendepagoController */
/* @var $model Ordendepago */
?>

<?php
$this->breadcrumbs=array(
	'Ordendepagos'=>array('index'),
	$model->idordendepago,
);

$this->menu=array(
	array('label'=>'List Ordendepago', 'url'=>array('index')),
	array('label'=>'Create Ordendepago', 'url'=>array('create')),
	array('label'=>'Update Ordendepago', 'url'=>array('update', 'id'=>$model->idordendepago)),
	array('label'=>'Delete Ordendepago', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idordendepago),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ordendepago', 'url'=>array('admin')),
);
?>

<h1>View Ordendepago #<?php echo $model->idordendepago; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idordendepago',
		'fecha',
		'descripcionordendepago',
		'importe',
		'ctacteprov_idctacteprov',
	),
)); ?>