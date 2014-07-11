<?php
/* @var $this ChequeraController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Chequeras',
);

$this->menu=array(
	array('label'=>'Create Chequera','url'=>array('create')),
	array('label'=>'Manage Chequera','url'=>array('admin')),
);
?>

<h1>Chequeras</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>