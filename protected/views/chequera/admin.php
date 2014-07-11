<?php
/* @var $this ChequeraController */
/* @var $model Chequera */


$this->breadcrumbs=array(
	'Chequeras'=>array('index'),
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
		'label'=>'Nueva cuenta', 
		'url'=>array('/chequera/create'),
	),
	array(
		'label'=>'Habilitar Chequera', 
		'url'=>array('habilitar'),
	),
);
?>

<h5 class="well well-small">CHEQUERAS HABILITADAS</h5>




<?php 
	$dataProvider=$model->search($model->estado='1');
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
			'name'=>'nombre',
		),
		array(
			'header'=>'CUENTA BANCARIA',
			'name'=>'ctabancariaIdctabancaria',
		),
		array(
			'header'=>'TIPO ',
			'name'=>'tipo',
			'value'=>'$data->tipo == 1 ? "Pago diferido" : "Pago directo"',
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
	                   	'url'=> 'Yii::app()->createUrl("chequera/activar", array("id"=>$data->idchequera,"estado"=>$data->estado))',
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
    'header' => '<h4>Detalle chequera</h4>',
    'fade'=>false,
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>