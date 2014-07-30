<?php 

if($cantidad < 1){
	$valor=array(
		array('label'=>'Volver','url'=>Yii::app()->request->Urlreferrer),
		array('label'=>'Cargar Empresa','url'=>array('create'))
	);
}
 else {
	$valor=array(
		array('label'=>'Volver','url'=>Yii::app()->request->Urlreferrer)
		);
}
$this->menu=$valor;

?>
<h5 class="well well-small">DATOS DE EMPRESA</h5>
<br>
<?php
$dataProvider= $model->search();

$columnas=array(
		array(
			'name'=>'razonsocial',
			'header'=>'RAZON SOCIAL',
			'filter'=>false,
			),
		array(
			'name'=>'cuit',
			'header'=>'CUIT',
			'filter'=>false,
			),
		array(
			'name'=>'direccion',
			'header'=>'DIRECCIÓN',
			'filter'=>false,
			),
		array(
			'name'=>'telefono',
			'header'=>'TELÉFONO',
			'filter'=>false,
			),
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
			'htmlOptions' => array('style'=>'width:5%;text-align:center'),
		),	
		
	);
?>

<?php 
    $this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
    'dataProvider' => $dataProvider,
    'template' => "{items}",
    'filter'=>$model,
    'columns' => $columnas,
    ));

?>