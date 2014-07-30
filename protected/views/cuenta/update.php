<?php
/* @var $this CuentaController */
/* @var $model Cuenta */
?>

<?php
$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	$model->idcuenta=>array('view','id'=>$model->idcuenta),
	'Update',
);

?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Actualizar Cuenta</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>