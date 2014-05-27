<?php
/* @var $this AsientoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Asientos',
);

$this->menu=array(
	array('label'=>'Create Asiento','url'=>array('create')),
	array('label'=>'Manage Asiento','url'=>array('admin')),
);
?>

<h1>Asientos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>