<?php
/* @var $this BancoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Bancos',
);

$this->menu=array(
	array('label'=>'Create Banco','url'=>array('create')),
	array('label'=>'Manage Banco','url'=>array('admin')),
);
?>

<h1>Bancos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>