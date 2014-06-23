<?php
/* @var $this FacturaController */
/* @var $model Factura */
?>

<?php
$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	$model->idfactura,
);

$this->menu=array(
	array('label'=>'List Factura', 'url'=>array('index')),
	array('label'=>'Create Factura', 'url'=>array('create')),
	array('label'=>'Update Factura', 'url'=>array('update', 'id'=>$model->idfactura)),
	array('label'=>'Delete Factura', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idfactura),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Factura', 'url'=>array('admin')),
);
?>

<h1>View Factura #<?php echo $model->idfactura; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idfactura',
		'nrodefactura',
		'tipofactura',
		'nroremito',
		'fecha',
		'formadepago',
		'cliente_idcliente',
		'estado',
		'descrecar',
		'tipodescrecar',
		'iva',
		'retencionIIBB',
		'presupuesto',
		'nropresupuesto',
		'importebruto',
		'ivatotal',
		'cantidadproducto',
		'producto_idproducto',
		'nombreproducto',
		'precioproducto',
		'stbruto_producto',
		'asiento_idasiento',
		'impuestointerno',
		'desc_imp_interno',
		'importeneto',
	),
)); ?>