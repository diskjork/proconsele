<?php
/* @var $this TipodecontribuyenteController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Tipodecontribuyentes',
);

$this->menu=array(
	array('label'=>'Create Tipodecontribuyente','url'=>array('create')),
	array('label'=>'Manage Tipodecontribuyente','url'=>array('admin')),
);
?>

<h1>Tipodecontribuyentes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>