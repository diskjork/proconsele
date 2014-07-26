<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugins/bootbox.min.js', CClientScript::POS_HEAD);?>
<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */


$this->breadcrumbs=array(
	'Proveedors'=>array('index'),
	'Manage',
);

$valores=array('0'=>'Inactivo','1'=>'Activo');
?>
<?php
$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nuevo Proveedor', 
		'url'=>array('create'),
	),
);
?>
<h5 class="well well-small">PROVEEDORES</h5>

<?php
//////////////ALERT TEMPORIZADO////////////////////
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
<?php endif; 
///////////////////////////////////////////////////  
?>
<?php 
	$dataProvider=$model->search();
	$dataProvider->setPagination(array('pageSize'=>20)); 
?>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php 
	$gridColumns= array(
		array(
	    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
	        $this->grid->dataProvider->pagination->pageSize + $row+1',
	        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        ),
		array(
			'name'=>'nombre',
			'header'=>'NOMBRE',	
		),
		array(
			'name'=>'cuit',
			'header'=>'CUIT',	
		),
		array(
			'name'=>'direccion',
			'header'=>'DIRECCIÓN',	
		),
		array(
			'name'=>'telefono',
			'header'=>'TELÉFONO',	
		),
		array(
         	'name'=>'estado',
		 	'header'=>'Estado',
        	'value'=>'$data->estado == 1 ? "Activo" : "Inactivo"',
			'filter' => CHtml::activeDropDownList($model, 'estado', $valores, array('prompt' => '','style'=>'width:100%;')),
        ),
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{activar} {desactivar} {view} {update} ',
            'buttons'=>array(
				'activar'=>array(
					'label'=>'Activar',
	                    'icon'=>TbHtml::ICON_OK,
						'visible'=>'$data->estado == 0',
	                   	'url'=> 'Yii::app()->createUrl("proveedor/activar", array("id"=>$data->idproveedor,"estado"=>$data->estado))',
	                   	'click'=>"
	                   			 function(){
                                    $.fn.yiiGridView.update($('div.grid-view').attr('id'), {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function() {
                                              $.fn.yiiGridView.update($('div.grid-view').attr('id'));
                                        }
                                    })
                                    return false;
                                    
                              }
                     ",
	                  ),
	            'desactivar'=>array(
					'label'=>'Desactivar',
	                    'icon'=>TbHtml::ICON_OFF,
						'visible'=>'$data->estado == 1',
	                   	'url'=> 'Yii::app()->createUrl("proveedor/activar", array("id"=>$data->idproveedor,"estado"=>$data->estado))',
	                   	'click'=>"
	                   			 function(){
                                    $.fn.yiiGridView.update($('div.grid-view').attr('id'), {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function() {
                                              $.fn.yiiGridView.update($('div.grid-view').attr('id'));
                                        }
                                    })
                                    return false;
                                    
                              }
                     ",
	                  ),
                'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("proveedor/view", array("id"=>$data->idproveedor))',
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
    //'template' => "{items}",
    'columns' => $gridColumns,
	
    ));
?>
<?php 
    $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'viewModal',
    'header' => 'Detalle de Proveedor',
    'fade'=>false,
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>