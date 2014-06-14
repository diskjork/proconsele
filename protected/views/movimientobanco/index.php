<?php
/* @var $this MovimientobancoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Movimientobancos',
);

$this->menu=array(
	array('label'=>'Create Movimientobanco','url'=>array('create')),
	array('label'=>'Manage Movimientobanco','url'=>array('admin')),
);
?>

<h1>Movimientobancos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>