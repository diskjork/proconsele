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

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'empresa-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'razonsocial',
			'header'=>'Razon Social',
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
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' =>'text-align: right'),
			'template'=>'{view} {update}',
		),
	),
)); ?>