<?php
/* @var $this RetencioniibbController */
/* @var $model Retencioniibb */


$this->breadcrumbs=array(
	'Retencioniibbs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Retencioniibb', 'url'=>array('index')),
	array('label'=>'Create Retencioniibb', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#retencioniibb-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Retencioniibbs</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'retencioniibb-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idretencionIIBB',
		'nrocomprobante',
		'cliente_idcliente',
		'fecha',
		'comp_relacionado',
		'importe',
		/*
		'tasa',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>