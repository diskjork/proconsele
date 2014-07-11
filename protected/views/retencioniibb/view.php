<?php
/* @var $this RetencioniibbController */
/* @var $model Retencioniibb */
?>

<?php
$this->breadcrumbs=array(
	'Retencioniibbs'=>array('index'),
	$model->idretencionIIBB,
);

$this->menu=array(
	array('label'=>'List Retencioniibb', 'url'=>array('index')),
	array('label'=>'Create Retencioniibb', 'url'=>array('create')),
	array('label'=>'Update Retencioniibb', 'url'=>array('update', 'id'=>$model->idretencionIIBB)),
	array('label'=>'Delete Retencioniibb', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idretencionIIBB),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Retencioniibb', 'url'=>array('admin')),
);
?>

<h1>View Retencioniibb #<?php echo $model->idretencionIIBB; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idretencionIIBB',
		'nrocomprobante',
		'cliente_idcliente',
		'fecha',
		'comp_relacionado',
		'importe',
		'tasa',
	),
)); ?>