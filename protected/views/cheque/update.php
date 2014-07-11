<?php
/* @var $this ChequeController */
/* @var $model Cheque */
?>
<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Actualizar',
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
	'Cheques'=>array('index'),
	$model->idcheque=>array('view','id'=>$model->idcheque),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cheque', 'url'=>array('index')),
	array('label'=>'Create Cheque', 'url'=>array('create')),
	array('label'=>'View Cheque', 'url'=>array('view', 'id'=>$model->idcheque)),
	array('label'=>'Manage Cheque', 'url'=>array('admin')),
);
?>
<?php /*
    <h1>Update Cheque <?php echo $model->idcheque; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); */?>