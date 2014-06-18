<?php
/* @var $this CajaController */
/* @var $model Caja */


$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	'Manage',
);


$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nueva caja', 
		'url'=>array('create'),
	),
	array(
		'label'=>'Habilitar caja', 
		'url'=>array('habilitar'),
	),
	
);
?>

<h5 class="well well-small">CAJAS</h5>

<?php 
	$dataProvider=$model->search($model->estado='1');
	$dataProvider->setPagination(array('pageSize'=>20)); 
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php 
	$gridColumns= array(
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
			'header'=>'DESCRIPCION',
			'name'=>'descripcion',
		),
		
		array(
			'header'=>'CTA. CONTABLE RELACIONADA',
			'name'=>'cuentaIdcuenta.codNombre',
		),
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{desactivar} {update} ',
            'buttons'=>array(
				 'desactivar'=>array(
					'label'=>'Desactivar',
	                    'icon'=>TbHtml::ICON_OFF,
						'visible'=>'$data->estado == 1',
	                   	'url'=> 'Yii::app()->createUrl("caja/activar", array("id"=>$data->idcaja,"estado"=>$data->estado))',
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
    'header' => '<h4>Detalle de Caja</h4>',
    'fade'=>false,
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>