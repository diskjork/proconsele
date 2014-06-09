<?php
/* @var $this MovimientocajaController */
/* @var $model Movimientocaja */
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Actualizar',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>
<?php
$this->breadcrumbs=array(
	'Movimientocajas'=>array('index'),
	$model->idmovimientocaja=>array('view','id'=>$model->idmovimientocaja),
	'Update',
);

$this->menu=array(
	array('label'=>'List Movimientocaja', 'url'=>array('index')),
	array('label'=>'Create Movimientocaja', 'url'=>array('create')),
	array('label'=>'View Movimientocaja', 'url'=>array('view', 'id'=>$model->idmovimientocaja)),
	array('label'=>'Manage Movimientocaja', 'url'=>array('admin')),
);
?>
<?php /*
    <h1>Update Movimientocaja <?php echo $model->idmovimientocaja; ?></h1>

<?php  $this->renderPartial('_form', array('model'=>$model)); */?>