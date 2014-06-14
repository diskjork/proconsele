<?php
/* @var $this MovimientobancoController */
/* @var $model Movimientobanco */
?>

<?php
$this->breadcrumbs=array(
	'Movimientobancos'=>array('index'),
	$model->idmovimientobanco,
);
?>

<?php $this->widget('yiiwheels.widgets.detail.WhDetailView',array(
    'htmlOptions' => array(
       'class' => 'table table-striped table-condensed table-hover',
    ),
    'type' => 'striped bordered',
    'data'=>$model,
    'attributes'=>array(
		'descripcion',
		'fecha',
		'debe',
		'haber',
		'rubroIdrubro',
		'bancoIdBanco',
		'formadepagoIdformadepago',
		'chequeIdcheque',

	),
)); ?>
