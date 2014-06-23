<?php
/* @var $this FacturaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Facturas',
);

$this->menu=array(
	array('label'=>'Create Factura','url'=>array('create')),
	array('label'=>'Manage Factura','url'=>array('admin')),
);
?>

<h1>Facturas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>