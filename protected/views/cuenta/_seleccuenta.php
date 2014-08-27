
<?php
	$dataProvider= $model->generargrilladetallecuenta($idcuenta, $fecha, $fecha2);
	//print_r($dataProvider); die();
	$dataArray=$dataProvider->getData();
	
	$dataDebeTotal=0;$dataHaberTotal=0;

	for ($i=0;$i<count($dataArray);$i++){
		$dataDebeTotal+=$dataArray[$i]['debeT'];
		$dataHaberTotal+=$dataArray[$i]['haberT'];
	}
?>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
		array('Excel','idcuenta'=>$idcuenta,'fecha'=>$fecha,'fecha2'=>$fecha2),
		'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$valores=array('0'=>'A Pagar', '1'=>'Pagado');
$columnas=array(
	array(			'header' => '#',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('class' =>'span1','style'=>'text-align:center'),
       				),
		
		array(
			'name'=>'fechaasiento',
			'header' => 'FECHA',
			'htmlOptions' => array('class' =>'span2'),
				
	            ), 
		array(
			'name'=>'descripcionasiento',
			'header'=>'DESCRIPCION',
			//'value'=>'$data["descripcionasiento"]',
			'htmlOptions' => array('class' =>'span6'),
		),
		
		array(//'name' => 'debeT',
					'header' => 'DEBE',
					'value'=>'($data["debeT"] != null)?"$".number_format($data["debeT"], 2, ".", ","):""',
					'htmlOptions' => array('class' =>'span2'),
					'footer'=>"$".number_format($dataDebeTotal, 2, ".", ","),	
					//'filter' => CHtml::activeDropDownList($model, 'chequeraIdchequera', CHtml::listData(Chequera::model()->findAll(), 'idchequera', 'nombre'), array('prompt' => ' ')),
		),	
		
		array(//'name' => 'haberT',
				'header' => 'HABER',
				'value'=>'($data["haberT"] != null)?"$".number_format($data["haberT"], 2, ".", ","):""',
				'htmlOptions' => array('class' =>'span2'),
				'footer'=>"$".number_format($dataHaberTotal, 2, ".", ","),				
		),	
		

		
		 );
?>
<?php
	
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'cuentas-grid',
	'dataProvider'=>$dataProvider,
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	//'filter'=>$model,
	//'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
	'columns'=>$columnas,
	'template' => "{items}{pager}",
)); 
 
?>

<script type="text/javascript">

var $table = $("#cuentas-grid").children('table');
var $tbody = $table.children('tfoot');
var debe=$("tfoot > tr > td:eq(3)").text();
debe=parseFloat(Number(debe.replace(/[^0-9\.]+/g,"")));
var haber=$("tfoot > tr > td:eq(4)").text();
haber=parseFloat(Number(haber.replace(/[^0-9\.]+/g,"")));
var saldo= debe - haber;
saldo="Saldo:  $"+$.number(saldo,2);
$tbody.append('<tr> <td></td> <td></td> <td></td> <td colspan=2 style="text-align:center;">'+saldo+'</td>  </tr>');

</script>
