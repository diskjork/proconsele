<?php
/* @var $this NotacreditoprovController */
/* @var $model Notacreditoprov */
/* @var $form TbActiveForm */
if(isset($_GET['vista'])){
		$vista=$_GET['vista'];
		
	}
?>
<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js', CClientScript::POS_HEAD);?>

<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/notacreditoprov.js', CClientScript::POS_HEAD);?>

<?php 
//print_r($model->attributes);
	if(isset($model->descrecar)){
		Yii::app()->clientScript->registerScript('descuento',"
				$('#Notacredito_desRec').prop('checked',true);
				$('#radiobutton-descRec').show();
				
				");
	}
	if(isset($model->retencionIIBB)){
		Yii::app()->clientScript->registerScript('IIBB',"
				$('#Notacredito_iibb').prop('checked',true);
				 $('#Notacredito_retencionIIBB').show();
          $('#totaldiv-iibb').show();
				//$('div .form-actions').css('background-color','transparent');
				
				");
	}
	if(isset($model->impuestointerno)){
		Yii::app()->clientScript->registerScript('impint',"
				$('#Notacredito_impInt').prop('checked',true);
				 $('#Notacredito_impuestointerno').show();
          $('#totaldiv-impint').show();
				//$('div .form-actions').css('background-color','transparent');
				
				");
	}
?>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'Notacredito-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

   

    <?php echo $form->errorSummary($model); ?>
<div class="row-fluid" id="encabezadofactura">
	

	<table style="width:100%;">
	<tr style="width:100%;">
		<td style="width:33%;">
			<?php echo $form->labelEx($model, 'fecha',array());?>
			
				<div class="input-append">
					<?php if (!isset($model->fecha))$fecha=date('d/m/Y'); else $fecha=$model->fecha;?>
			            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						        'model' => $model,
								'attribute' => 'fecha',
						        'pluginOptions' => array(
						            'format' => 'dd/mm/yyyy',
			            			'language'=>'es'
						        ),
						        'htmlOptions' => array(
						            //'placeholder' => 'Seleccionar fecha',
						        	'class' => 'input-medium',
						        'value'=>$fecha,
						        )
						    ));
						?>
					<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
		</td>
		<td style="width:33%;" >
		<div style="width:40%" class="well">
			<?php echo $form->label($model, 'tipofactura');?>
			<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'tipofactura',
			  'data' =>array('1'=>'A','2'=>'B'),
			  'options'=>array(
				   //'placeholder'=>'Forma de pago',
				   'allowClear'=>true,
					'width'=>'80%'
				  ),
			)); ?>
		<?php  echo $form->error($model,'tipofactura',array('style'=>'color:#b94a48')); ?>
		</div>
		</td>
		<td style="width:34%;">
		<div id="nrofactura" >
		
							
			<?php echo $form->textFieldControlGroup($model,'nronotacreditoprov',array('width'=>'10%','class'=>'mascara')); ?>
		
			<?php echo $form->textFieldControlGroup($model,'nrodefactura',array('width'=>'10%','class'=>'mascara')); ?>
			</div>
			
			<div id="nropresupuesto" style="display:none;">
			
			</div>
		</td>
	</tr>
	<tr>
	<td colspan="3">
	<div class="alert">
	<?php echo $form->labelEx($model, 'compras_idcompras');?>
		<?php 
		
		$mes=(int)date('m');
		switch ($mes){
			case '3':
				$mesv=12;
			break;
			case '2':
				$mesv=11;
			break;
			case '1':
				$mesv=10;
			default:
				$mesv=$mes - 3;
				break;
		}
		$cond1="MONTH(fecha)>=".$mesv;
		$años=(int)date('Y');
		$cond2=$cond1." AND YEAR(fecha)>=".date('Y');
		
		$this->widget('ext.select2.ESelect2',array(
			 
			 'model'=>$model,
			 'attribute'=>'compras_idcompras',
			  'data' =>GxHtml::listDataEx(Compras::model()->
					   				findAllAttributes(array('nrodefactura, fecha, importeneto,estado'),true,array('condition'=>$cond2,'order'=>'fecha ASC')),'idcompra','nombrecompra'),
			  'options'=>array(
				   'placeholder'=>'Factura compra',
				   'allowClear'=>true,
					'width'=> '70%',
					
				  ),
			)); ?>
		<?php  echo $form->error($model,'compras_idcompras',array('style'=>'color:#b94a48')); ?>
	</div>	
	</td>
	</tr>
	
	<tr style="width:100%;">
		<td style="width:33%;">
		<?php echo $form->labelEx($model, 'proveedor_idproveedor');?>
		<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'proveedor_idproveedor',
			  'data' =>GxHtml::listDataEx(Proveedor::model()->
					   				findAll('estado = :estado', array(':estado' => 1)),'idproveedor','nombre'),
			  'options'=>array(
				   'placeholder'=>'Proveedor',
				   'allowClear'=>true,
					'width'=> '100%',
				  ),
			)); ?>
		<?php  echo $form->error($model,'proveedor_idproveedor',array('style'=>'color:#b94a48')); ?>
		</td>
		<td style="width:33%;">
		
		<?php // echo $form->label($model, 'formadepago');?>
		<?php 
			/*$formPago=GxHtml::listDataEx(Caja::model()->
					   				findAll('estado = :estado', array(':estado' => 1)),'idcaja','nombre');
			$formPago['99999']='Cta Cte (Cheque, Trans. bancaria)';	
			//print_r($formPago);	   				
			$this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'formadepago',
			  'data' =>$formPago,//array('1'=>'Efectivo','4'=>'Cta Cte (Cheque, Trans. bancaria)'),
			  'options'=>array(
				   'placeholder'=>'Forma de pago',
				   'allowClear'=>true,
					'width'=> '100%',
				  ),
			));*/ ?>
		<?php // echo $form->error($model,'formadepago',array('style'=>'color:#b94a48')); ?>
	
		</td>
	<td style="width:34%;">
	
	</td>
	</tr>

	</table>

</div>
<div class="row-fluid " id="totalesfactura" >
<h5 style="text-align: right;"> TOTALES DE FACTURA</h5>
	<div style="float:right; margin-right:10px; margin-top:10px;" >
	<div class=" well" style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto; border: 3px solid #0E0D0D;">
			<h5 style="padding:0px">TOTAL</h5>
			<h5 style="text-align:center;margin:0;margin-left:-4px;" id="totalnetoblock"></h5>
	</div>
	 
	</div>
	
	
	<div style="float:right; margin-right:10px; margin-top:10px;" id="totalivadiv">
	<div class=" well  " style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-3px;">IVA</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="ivablock"></h6>
		
	</div>
	
	</div>	

	<div style="float:right; margin-right:10px; margin-top:10px; display:none;" id="totaldiv-iibb">
	<div  class=" well " style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-15%;" id="label-iibb">IIBB</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="total-iibb"></h6>
	</div>	
	</div>
	
</div>

<div class="row-fluid alert" id="totalesnotacredito" style="margin-top: 10px;margin-bottom: -10px;padding: 2px 2px 2px 0px;">
	<h5 style="text-align: right;"> TOTALES DE NOTA DE CREDITO</h5>
	<div style="float:right; margin-right:10px; margin-top:10px;" >
	<div class=" well" style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto; border: 3px solid #0E0D0D;">
			<h5 style="padding:0px">TOTAL</h5>
			<h5 style="text-align:center;margin:0;margin-left:-4px;" id="totalnetoblockNC"></h5>
	</div>
	</div>
	
	
	<div style="float:right; margin-right:10px; margin-top:10px;" id="totalivadivNC">
	<div class=" well  " style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-3px;">IVA</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="ivablockNC"></h6>
		
	</div>
	
	</div>	
	
	<div style="float:right; margin-right:10px; margin-top:10px; display:none;" id="totaldiv-iibbNC">
	<div  class=" well " style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-15%;" id="label-iibb">IIBB</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="total-iibbNC"></h6>
	</div>	
	</div>	
		
</div>		
				<?php  //echo $form->hiddenField($model,'importeneto',array('span'=>4,)); ?>
				<?php // echo $form->hiddenField($model,'ivatotal',array('span'=>4,)); ?>
				<?php //echo $form->hiddenField($model,'importeIIBB',array('span'=>4,)); ?>
				<?php echo $form->hiddenField($model,'importebruto',array('span'=>5)); ?>
				
				

<br>
<div class="row-fluid">
	<table >
	<tr style="width:100%;">
	
	</tr>
	<tr style="width:100%;" >
	<td style="width:25%; vertical-align: top;" class="well" >
	<div >	
	
	<?php echo $form->label($model, 'iva');?>
	
 	<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'iva',
			  'data' => array("1.21"=>"21%","1.105"=>"10,5%"),
			'events'=>array(
				 					
				 					),
			  'options'=>array(
				   //'placeholder'=>'I.V.A.',
				   'allowClear'=>true,
					'width'=> '60%',
				  ),
			)); ?>
		<?php  echo $form->error($model,'iva',array('style'=>'color:#b94a48')); ?>
		
	</div>		
	
	
	</td>
	
	<td style="width:25%; vertical-align: top;" class="well" >
	<?php echo $form->textFieldControlGroup($model,'ivatotal',array('span'=>5,
							'onkeydown'=>' 
	        				if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
	 							'onblur'=> 'sumatotal();',)); ?>				
	<?php  echo $form->textFieldControlGroup($model,'importeneto',array('span'=>5,
			'onkeydown'=>' 
	        				if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
	 							'onblur'=> 'sumatotal();'
 		)); 
 	?>
	
	</td>
	<td style="width:25%; vertical-align: top;"  class="well" >
	<div >	
	<?php echo $form->label($model, 'percepcionIIBB');?>
	<?php echo $form->checkBox($model, 'iibb',array('value'=>1));echo "Percepción IIBB";?>
	<br><br>
	<?php echo $form->textFieldControlGroup($model,'importeIIBB',array('style'=>'width:20%;',
	'onkeydown'=>' 
	        				if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
	 							'onblur'=> 'sumatotal();'
	)); ?>
	
	</div>
	
	</td>
	<td style="width:25%; vertical-align: top;"  class="well" >
	
	
	</td>
	</tr>
	</table>
	

</div>	
			
   	
	<?php echo $form->hiddenField($model,'asiento_idasiento',array('span'=>5)); ?>
    <?php echo $form->hiddenField($model, 'vista', array());?>    
            

            
        <div class="form-actions" align="center">
        <?php 
        
        echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'id'=>'boton-submit',
		)); ?>
		
		<?php 
			
				echo CHtml::link('Cancelar', Yii::app()->request->Urlreferrer ,array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
   		</div>

    <?php $this->endWidget(); ?>
<?php if(isset($vista)){
	 Yii::app()->clientScript->registerScript('vista',"
$('#Notacredito_vista').val('".$vista."');");
}?>
</div><!-- form -->
 <?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				
				"); ?> 	