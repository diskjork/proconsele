<?php
/* @var $this TipodecontribuyenteController */
/* @var $model Tipodecontribuyente */
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Actualizar</h4>',
			'content' => $this->renderPartial('_form', array('model'=>$model),true),
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
	'Tipodecontribuyentes'=>array('index'),
	$model->idtipodecontribuyente=>array('view','id'=>$model->idtipodecontribuyente),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tipodecontribuyente', 'url'=>array('index')),
	array('label'=>'Create Tipodecontribuyente', 'url'=>array('create')),
	array('label'=>'View Tipodecontribuyente', 'url'=>array('view', 'id'=>$model->idtipodecontribuyente)),
	array('label'=>'Manage Tipodecontribuyente', 'url'=>array('admin')),
);
?>
<?php /*
    <h1>Update Tipodecontribuyente <?php echo $model->idtipodecontribuyente; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); */?>