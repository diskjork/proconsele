<?php
/* @var $this CtabancariaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Ctabancarias',
);

$this->menu=array(
	array('label'=>'Create Ctabancaria','url'=>array('create')),
	array('label'=>'Manage Ctabancaria','url'=>array('admin')),
);
?>

<h1>Ctabancarias</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>