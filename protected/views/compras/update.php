<?php
/* @var $this ComprasController */
/* @var $model Compras */
?>

<?php
$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
	),
	
);
?>
<h5 class="well well-small">ACTUALIZAR FACTURA - COMPRA (<?php echo $model->nrodefactura;?>)</h5>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>