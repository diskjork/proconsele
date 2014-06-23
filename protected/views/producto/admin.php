<?php
/* @var $this ProductoController */
/* @var $model Producto */


$this->breadcrumbs=array(
	'Productos'=>array('index'),
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
		'label'=>'Nuevo Producto', 
		'url'=>array('create'),
	),
);
?>

<h5 class="well well-small">PRODUCTOS</h5>

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
	$dataProvider->setPagination(array('pageSize'=>$model->count())); 
?>
<?php 
	$gridColumns= array(
		//'idproducto',
		array(
	    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
	        $this->grid->dataProvider->pagination->pageSize + $row+1',
	        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        ),
		array(
			'header'=>'NOMBRE',
			'name'=>'nombre',		
		),
		
		array(
			'header'=>'UNIDAD VTA.',
			'name'=>'unidad',		
		),
		array(
			'header'=>'EQ. UNIDAD VTA. (Kg)',
			'value'=>'$data->cantidadventa." Kg"',	
		),
		
		array(
			'header'=>'PRECIO ($)',
			'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
			'name' => 'precio',
			'sortable'=> false,
			'filter' => false,
			'editable' => array(
				'url' => $this->createUrl('producto/editable'),
				'placement' => 'right',
				'inputclass' => 'span1',
				'emptytext'=>'Vacio',
				'title'=>'Modificar Precio actual',
				
			),
			
		),
		//'stock',
		//'precio',
		array(
			'header'=>'DESCRIPCION',
			'name'=>'descripcion',		
		),
		array(
         	'name'=>'estado',
		 	'header'=>'Estado',
        	'value'=>'$data->estado == 1 ? "Activo" : "Inactivo"',
        ),
		//'costoproduccion',
		//'costomateriaprima',
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{activar} {desactivar} {view} {update} ',
			'htmlOptions' => array('width' =>'50px'),
            'buttons'=>array(
				'activar'=>array(
					'label'=>'Activar',
	                    'icon'=>TbHtml::ICON_OK,
						'visible'=>'$data->estado == 0',
	                   	'url'=> 'Yii::app()->createUrl("producto/activar", array("id"=>$data->idproducto,"estado"=>$data->estado))',
	                   	'click'=>"function(){
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
	                   	'url'=> 'Yii::app()->createUrl("producto/activar", array("id"=>$data->idproducto,"estado"=>$data->estado))',
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
                        'url'=>'Yii::app()->createUrl("producto/view", array("id"=>$data->idproducto))',
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
    'fade'=>false,
    'header' => 'Detalle de Producto',
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>
