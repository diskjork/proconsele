<?php
/* @var $this MovimientobancoController */
/* @var $model Movimientobanco */
?>

<?php
$this->breadcrumbs=array(
	'Movimientobancos'=>array('index'),
	'Create',
);
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Cargar Movimiento Banco</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); ?>
