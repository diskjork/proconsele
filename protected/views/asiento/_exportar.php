<?php 
$anio=date('Y');
$anios[2013]=2013;
$valor=2013;
for($i=1;$i<=($anio - $valor);$i++){
	$anios[$valor + $i]=$valor + $i;
}
$meses[1]="Enero";
$meses[2]="Febrero";
$meses[3]="Marzo";
$meses[4]="Abril";
$meses[5]="Mayo";
$meses[6]="Junio";
$meses[7]="Julio";
$meses[8]="Agosto";
$meses[9]="Septiembre";
$meses[10]="Octubre";
$meses[11]="Noviembre";
$meses[12]="Diciembre";
?>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'exportar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<table>
  <tr>
    
    <th></th>
  </tr>
  <tr>
    <td>
    <br>
    Exportar asiento resumen del año
    </td>
    <td>
  	 <?php echo $form->label($model, 'anio');?>
			<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'anio',
			  'data' =>$anios,
			  'options'=>array(
				   //'placeholder'=>'Forma de pago',
				   'allowClear'=>true,
					'width'=>'60%'
				  ),
			)); ?>
		<?php  echo $form->error($model,'anio',array('style'=>'color:#b94a48')); ?>
	</td>
	<td>
	<?php echo TbHtml::ajaxButton('Cargar', CController::createUrl('asiento/excel'), 
										array(//'update' => '#grillacuenta',
											  'type'=>'get',
											  'data'=>array(
															'anioTab'=>'js:$("#Asiento_anio").val()',
															'mesTab'=>'js:$("#Asiento_mes").val()',
															'tipo'=>2,
															),
												),  array(
														'id'=>'botonajax',
														'color' => TbHtml::BUTTON_COLOR_PRIMARY))?>
	</td>
	
  </tr>
  <tr>
    <td><br>Exportar asiento resumen del mes</td>
    <td>
    
    <div class="row-fluid">
     <div class="span6">
    <?php echo $form->label($model, 'anio');?>
			<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'anio2',
			  'data' =>$anios,
			  'options'=>array(
				   //'placeholder'=>'Forma de pago',
				   'allowClear'=>true,
					//'width'=>'60%'
				  ),
			)); ?>
	
    </div>
    <div class="span6">
    <?php echo $form->label($model, 'mes');?>
			<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'mes',
			  'data' =>$meses,
			  'options'=>array(
				   //'placeholder'=>'Forma de pago',
				   'allowClear'=>true,
					'width'=>'100%'
				  ),
			)); ?>
		
    	</div>
  	</div> 
  	
				</td>
				<td>
				</td>
  </tr>
</table>
<?php $this->endWidget(); ?>
</div><!-- form -->