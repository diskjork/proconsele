<?php
/* @var $this ChequeraController */
/* @var $model Chequera */
?>

<?php
$this->breadcrumbs=array(
	'Chequeras'=>array('index'),
	$model->idchequera=>array('view','id'=>$model->idchequera),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Factura', 'url'=>array('index')),
	array('label'=>'Administrar', 'url'=>array('admin')),
);
?>

<h5 class="well well-small">ACTUALIZACIÓN DE CHEQUERA (<?php echo $model->idchequera?>)</h5>
<br><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>