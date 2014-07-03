<?php
/* @var $this FacturaController */
/* @var $model Factura */
?>

<?php
$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	$model->idfactura=>array('view','id'=>$model->idfactura),
	'Update',
);
?>
<?php
$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
	),
	array(
		'label'=>'Nueva Factura', 
		'url'=>array('create'),
		'active' => true,
	),
);
?>
<h5 class="well well-small">ACTUALIZAR FACTURA (<?php echo $model->nrodefactura;?>)</h5>

<?php $this->renderPartial('_form', array('model'=>$model, 'modelformprod'=>$modelformprod)); ?>