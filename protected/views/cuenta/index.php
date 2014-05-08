<?php
/* @var $this CuentaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Cuentas',
);

$this->menu=array(
	array('label'=>'Create Cuenta','url'=>array('create')),
	array('label'=>'Manage Cuenta','url'=>array('admin')),
);
?>

<h1>Cuentas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>