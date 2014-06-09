<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */
?>

<?php
$this->breadcrumbs=array(
	'Cobranzas'=>array('index'),
	$model->idcobranza,
);

$this->menu=array(
	array('label'=>'List Cobranza', 'url'=>array('index')),
	array('label'=>'Create Cobranza', 'url'=>array('create')),
	array('label'=>'Update Cobranza', 'url'=>array('update', 'id'=>$model->idcobranza)),
	array('label'=>'Delete Cobranza', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idcobranza),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cobranza', 'url'=>array('admin')),
);
?>


<?php $this->widget('yiiwheels.widgets.detail.WhDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
	),
    'type' => 'striped bordered',
    
    'data'=>$model,
     'attributes'=>array(
		//'idcobranza',
		'fecha',
		'descripcioncobranza',
		'importe',
		//'ctactecliente_idctactecliente',
	),
)); ?>