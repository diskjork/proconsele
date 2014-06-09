<?php
/* @var $this MovimientocajaController */
/* @var $model Movimientocaja */
?>

<?php
$this->breadcrumbs=array(
	'Movimientocajas'=>array('index'),
	$model->idmovimientocaja,
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

	),
)); ?>
