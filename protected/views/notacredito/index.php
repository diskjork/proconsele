<?php
/* @var $this NotacreditoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditos',
);

$this->menu=array(
	array('label'=>'Create Notacredito','url'=>array('create')),
	array('label'=>'Manage Notacredito','url'=>array('admin')),
);
?>

<h1>Notacreditos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>