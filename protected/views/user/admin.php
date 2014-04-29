<?php
/* @var $this UserController */
/* @var $model User */


$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);
?>

<?php

$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nuevo Usuario', 
		'url'=>array('create'),
	),
	array(
		'label'=>'Permisos', 
		'url'=>array('/index.php/auth/assignment'),
	),
);
?>

<h5 class="well well-small">ADMINISTRACION DE USUARIOS</h5>

<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").delay(2000).fadeOut("slow");',
   	CClientScript::POS_READY
);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div id="bloqueAlert">
	    <div id="myAlert" class="alert alert-success fade in info estiloAlert" data-alert="alert">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
    </div>
<?php endif; ?>
     
<?php 
	$dataProvider=$model->search();
	$dataProvider->setPagination(array('pageSize'=>20)); 
?>

<?php 
	$gridColumns= array(
		array(
	    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
	        $this->grid->dataProvider->pagination->pageSize + $row+1',
	        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        ),
		array(
			'header'=>'NOMBRE',
			'name'=>'firstname'
		),
		array(
			'header'=>'APELLIDO',
			'name'=>'lastname'
		),
		array(
			'header'=>'USUARIO',
			'name'=>'username'
		),
		array(
			'header'=>'EMAIL',
			'name'=>'email'
		),
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'buttons'=>array(
                'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("user/view", array("id"=>$data->iduser))',
                        'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                            ),
                        ),
                    ),
            ),
        ),
	);
	$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'filter'=>$model,
    'fixedHeader' => false,
    'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    ));
?>
<?php 
    $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'viewModal',
    'header' => 'Detalle de Usuario',
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>