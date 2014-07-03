<?php
/* @var $this ComprasController */
/* @var $model Compras */
?>

<?php
$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Factura', 'url'=>array('index')),
	array('label'=>'Administrar', 'url'=>array('admin')),
);
?>

<h5 class="well well-small">CARGAR NUEVA FACTURA COMPRA</h5>
<br><br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>