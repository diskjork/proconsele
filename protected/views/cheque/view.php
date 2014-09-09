<?php
/* @var $this ChequeController */
/* @var $model Cheque */
?>

<?php
$this->breadcrumbs=array(
	'Cheques'=>array('index'),
	$model->idcheque,
);
$arrayEstado=array('A pagar','Pagado','A cobrar','Cobrado por Ventanilla','Endozado','Depositado en Banco Propio', 'Rechazado');

?>

<?php $this->widget('yiiwheels.widgets.detail.WhDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
	),
    'type' => 'striped bordered',
     'data'=>$model,
   'attributes'=>array(
		'nrocheque',
		'titular',
		'cuittitular',
		'fechaingreso',
		'fechacobro',
		array(
			'name'=>'debe',
			'value'=> ($model->debe == null)? '-' : $model->debe,
		),
		array(
			'name'=>'haber',
			'value'=> ($model->haber == null)? '-' : $model->haber,
		),
		'bancoIdBanco',
		array(
			'name'=>'proveedorIdproveedor',
			'header'=>'Proveedor',
			'visible'=>$model->proveedor_idproveedor != NULL,
		),
		array(
			'label'=>'CUIT del Acreedor',
			'visible'=>$model->proveedor_idproveedor != NULL,
			'value'=>$model->proveedor_idproveedor != NULL ? $model->proveedorIdproveedor->cuit : "-",
		),
		array(
			'name'=>'clienteIdcliente',
			'header'=>'Cliente',
			'visible'=>$model->cliente_idcliente != NULL,
		),
		array(
			'label'=>'CUIT Liberador',
			'visible'=>$model->cliente_idcliente != NULL,
			'value'=>$model->cliente_idcliente != NULL ? $model->clienteIdcliente->cuit : "-",
		),
		array(
			'name'=>'estado',
			'value'=>$arrayEstado[$model->estado],
		),
		array(
			'name'=>'comentario',
			'value'=>($model->comentario == null)? "-" : $model->comentario,
		),				
	),
)); ?>