<?php
/* @var $this RetencioniibbController */
/* @var $model Retencioniibb */
?>

<?php
$this->breadcrumbs=array(
	'Retencioniibbs'=>array('index'),
	$model->idretencionIIBB=>array('view','id'=>$model->idretencionIIBB),
	'Update',
);

$this->menu=array(
	array('label'=>'List Retencioniibb', 'url'=>array('index')),
	array('label'=>'Create Retencioniibb', 'url'=>array('create')),
	array('label'=>'View Retencioniibb', 'url'=>array('view', 'id'=>$model->idretencionIIBB)),
	array('label'=>'Manage Retencioniibb', 'url'=>array('admin')),
);
?>

    <h1>Update Retencioniibb <?php echo $model->idretencionIIBB; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>