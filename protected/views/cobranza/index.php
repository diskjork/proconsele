<?php
/* @var $this CobranzaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Cobranzas',
);

$this->menu=array(
	array('label'=>'Create Cobranza','url'=>array('create')),
	array('label'=>'Manage Cobranza','url'=>array('admin')),
);
?>

<h1>Cobranzas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>