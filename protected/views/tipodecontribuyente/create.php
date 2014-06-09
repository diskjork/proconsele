<?php
/* @var $this TipodecontribuyenteController */
/* @var $model Tipodecontribuyente */
?>

<?php
$this->breadcrumbs=array(
	'Tipodecontribuyentes'=>array('index'),
	'Create',
);
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Cargar Contribuyente</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); ?>