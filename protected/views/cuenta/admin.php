<?php
/* @var $this CuentaController */
/* @var $model Cuenta */


$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nueva cuenta', 
		'url'=>array('/cuenta/create'),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cuenta-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h5 class="well well-small">PLAN DE CUENTAS</h5>
<br>
<!-- search-form -->
<?php 
$dataProvider= $model->search();
$dataProvider->setPagination(array('pageSize'=>200));
$lista=CHtml::listData(Tipocuenta::model()->findAll(), 'idtipocuenta','nombre');
$columnas=array(
		array(
		'name'=>'codigocta',
		'htmlOptions' => array('width' =>'30px','style'=>'text-align:center'),
		),
		array(
		'name'=>'tipocuenta_idtipocuenta',
		'value'=>'$data->tipocuentaIdtipocuenta',
		'filter'=> $lista,
		),
		array(
		
			'header'=>'Tipo Gral.',
			'value'=>array($this,'nombreTipogral'),
			),
		'nombre',
		
		
		array(
			'header'=>'Asentable:',
			'value'=>'$data->asentable == 1 ? "SI" : "NO"',
			'htmlOptions' => array('width' =>'20px','style'=>'text-align:center'),
		),
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} ',
		),
		
	);
?>


<?php 
    $this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
    'dataProvider' => $dataProvider,
 //   'extraRowColumns' =>array('tipo'),
    'template' => "{items}",
    'filter'=>$model,
    'columns' => $columnas,
    'mergeColumns' => array('tipocuenta_idtipocuenta')
    ));

?>
<?php 

    $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'CuentaModal',
    'header' => '<h4>Nueva cuenta contable</h4>',
    'fade'=>false,	
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>