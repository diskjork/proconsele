<?php
/* @var $this CajaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Cajas',
);

$this->menu=array(
	array('label'=>'Create Caja','url'=>array('create')),
	array('label'=>'Manage Caja','url'=>array('admin')),
);
?>

<h1>Cajas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>