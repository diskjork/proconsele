<?php
/* @var $this MovimientocajaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Movimientocajas',
);

$this->menu=array(
	array('label'=>'Create Movimientocaja','url'=>array('create')),
	array('label'=>'Manage Movimientocaja','url'=>array('admin')),
);
?>

<h1>Movimientocajas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>