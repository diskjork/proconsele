<?php
/* @var $this AsientoController */
/* @var $model Asiento */
$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nuevo asiento', 
		'url'=>array('/asiento/create'),
	),
);
?>

<h1>Asientos</h1>
<!-- search-form -->

<?php
$gridColumns= array(
		array(
				'header'=>'FECHA',
				'name'=>'fecha',
				'htmlOptions' => array('width' =>'90px'),
			),
		array(
				'header'=>'N°',
				'name'=>'idasiento',
				'htmlOptions' => array('width' =>'60px'),
			),
		
		array(
			'header'=>'DESCRIPCION',
			'name'=>'descripcion',
			'htmlOptions' => array('width' =>'60%',
										'style'=>'text-align:left;'),
		),
		
	);

Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'type' => 'striped bordered',
	'dataProvider' => $model->search(),
	'template' => "{items}",
	'columns' => array_merge(
					$gridColumns,
					array(
						array(
								'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
								'name' => 'Visualizar',
								'url' => $this->createUrl('asiento/grilla'),
								'value' =>'"Ver"',
								
								'afterAjaxUpdate' => 'js:function(tr,rowid,data){
								
								}'
							)
						) 	
						),
)); ?>