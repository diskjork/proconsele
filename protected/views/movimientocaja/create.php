<?php
/* @var $this MovimientocajaController */
/* @var $model Movimientocaja */
?>

<?php
$this->breadcrumbs=array(
	'Movimientocajas'=>array('index'),
	'Create',
);
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalcreate',
    		'header' => '<h4>Cargar Movimiento Caja</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>