<?php
/* @var $this ChequeController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Cheques',
);

$this->menu=array(
	array('label'=>'Create Cheque','url'=>array('create')),
	array('label'=>'Manage Cheque','url'=>array('admin')),
);
?>

<h1>Cheques</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>