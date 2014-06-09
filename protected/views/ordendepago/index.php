<?php
/* @var $this OrdendepagoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Ordendepagos',
);

$this->menu=array(
	array('label'=>'Create Ordendepago','url'=>array('create')),
	array('label'=>'Manage Ordendepago','url'=>array('admin')),
);
?>

<h1>Ordendepagos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>