<?php
/* @var $this CuentaController */
/* @var $model Cuenta */
?>

<?php
$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	'Crear',
);
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalcreate',
    		'header' => '<h4>Nueva cuenta contable</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>