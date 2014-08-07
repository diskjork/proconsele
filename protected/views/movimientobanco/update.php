<?php
/* @var $this MovimientobancoController */
/* @var $model Movimientobanco */
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
	'Movimientobancos'=>array('index'),
	$model->idmovimientobanco=>array('view','id'=>$model->idmovimientobanco),
	'Update',
);
?>
<?php /*
<h1>Update Movimientobanco <?php echo $model->idmovimientobanco; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); */?>