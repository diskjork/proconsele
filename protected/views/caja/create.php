<?php
/* @var $this CajaController */
/* @var $model Caja */
?>

<?php
$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	'Create',
);
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Carga de nueva caja</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); ?>
