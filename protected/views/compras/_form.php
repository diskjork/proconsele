<?php
/* @var $this FacturaController */
/* @var $model Factura */
/* @var $form TbActiveForm */
if(isset($_GET['vista'])){
		$vista=$_GET['vista'];
		
	}
	
?>
<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js', CClientScript::POS_HEAD);?>

<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/compras.js', CClientScript::POS_HEAD);?>
<?php 
if(isset($model->importeIIBB)){
		Yii::app()->clientScript->registerScript('IIBB',"
				$('#Compras_iibb').prop('checked',true);
				 $('#Compras_importeIIBB').show();
				 $('#Compras_importeIIBB').removeAttr('readonly');
          		$('#totaldiv-iibb').show();
				//$('div .form-actions').css('background-color','transparent');
				
				");
	}
?>

<div class="form" >

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'factura-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


    <?php echo $form->errorSummary($model); ?>

<div class="well" id="encabezadofactura" style="margin-bottom: 10px;  padding-bottom: 0px;padding-top: 5px;">	

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
			  'data' =>array('1'=>'A','2'=>'B','3'=>'C'),
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
		<?php echo $form->textFieldControlGroup($model,'nrodefactura',array('width'=>'10%','class'=>'mascara')); ?>
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
					   				findAll('estado = :estado ORDER BY nombre ASC', array(':estado' => 1)),'idproveedor','nombre'),
			  'options'=>array(
				   'placeholder'=>'Proveedor',
				   'allowClear'=>true,
					'width'=> '100%',
				  ),
			)); ?>
		<?php  echo $form->error($model,'proveedor_idproveedor',array('style'=>'color:#b94a48')); ?>
		</td>
		<td style="width:33%;">
		
		<?php echo $form->label($model, 'formadepago');?>
		<?php 
			$formPago=GxHtml::listDataEx(Caja::model()->
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
			)); ?>
		<?php  echo $form->error($model,'formadepago',array('style'=>'color:#b94a48')); ?>
	
		</td>
	<td style="width:34%;">
	
	</td>
	</tr>

	</table>

</div>
<div  class="well" style="margin-bottom: 10px; padding-bottom: 10px; padding-top: 5px;">
<?php echo $form->textAreaControlGroup($model,'descripcion', array('span' => 6, 'rows' => 3)); ?>
</div>
<div  class="well" style="margin-bottom: 10px; padding-bottom: 10px; padding-top: 5px;">
 <?php echo $form->label($model, 'cuenta_idcuenta');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'cuenta_idcuenta',
				  'data' => GxHtml::listDataEx(Cuenta::model()->findAllAttributes(array('codigocta,nombre'),true,array('condition'=>'asentable=1','order'=>'codigocta ASC')),'idcuenta','codNombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta',
					   'allowClear'=>true,
						'width'=> '300px',
					  ),
				)); ?>
<?php  echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
</div>		

<br>

<div class="row-fluid well" style="margin-top: -20px; padding-bottom: 0px; padding-top: 5px;width:96%">
	
			<div class="span5">	
				<div class="span7">
						<?php echo $form->label($model, 'iva');?>
						<?php $this->widget('ext.select2.ESelect2',array(
								  //'name'=>'cuenta_idcuenta',
								 'model'=>$model,
								 'attribute'=>'iva',
								  'data' => array("1.21"=>"21%","1.105"=>"10,5%"),
								
								  'options'=>array(
									   //'placeholder'=>'I.V.A.',
									   'allowClear'=>true,
										'width'=> '40%',
									  ),
								)); ?>
						<?php  echo $form->error($model,'iva',array('style'=>'color:#b94a48')); ?>
					
						<br><br>
						<?php echo $form->textFieldControlGroup($model,'ivatotal',array('span'=>5,
							'onkeydown'=>' 
	        				if(event.keyCode == 9 ||event.keyCode == 13)blockiva()',
	 							'onblur'=> 'blockiva();',)); ?>				
						<?php  echo $form->textFieldControlGroup($model,'importeneto',array('span'=>5,
							'onkeydown'=>' 
			        				if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
										'onblur'=>'sumatotal();'
			 				)); 
			 			?>
			 			
	 							
	 				</div>
		 			<div  style="float:top;">
		 				<?php echo $form->label($model, 'percepcionIIBB2');?>
						<?php echo $form->checkBox($model, 'iibb',array('value'=>1));echo " Percepción IIBB";?>
						<?php echo $form->textFieldControlGroup($model,'importeIIBB',array('span'=>3,
										'onkeydown'=>' 
			        				if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
										'onblur'=>'sumatotal();'
			 						
						)); ?>
					</div>
				
			</div>
	 		<div class="span7">
			<div style="float:right; margin-right:10px; margin-top:10px;" >
				<div class=" well" style="width:60px;height:60px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto; border: 3px solid #0E0D0D;">
						<h5 style="padding:0px">TOTAL</h5>
						<h5 style="text-align:center;margin:0;margin-left:-4px;" id="totalnetoblock"></h5>
				</div>
			 
			</div>
		
			<div style="float:right; margin-right:10px; margin-top:10px;">
				<div class=" well  " style="width:60px;height:60px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
					<h5 style="padding:0px;margin-left:-3px;">IVA</h5>
					<h6 style="text-align:center;margin:0;margin-left:-4px;" id="ivablock"></h6>
					
				</div>
			
			</div>
			<div style="float:right; margin-right:10px; margin-top:10px;display:none;" id="blockiibb">
				<div class=" well  " style="width:60px;height:60px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
						<h5 style="padding:0px">IIBB</h5>
						<h5 style="text-align:center;margin:0;margin-left:-4px;" id="totaiibbblock"></h5>
				</div>
			 
			</div>
		</div>		
</div>



			
	
	
	<?php  /*echo $form->textFieldControlGroup($model,'importeneto',array('span'=>3,
					'onkeydown'=>' 
	        				 		if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
					'onblur'=>'sumatotal();'
	 				)); */?>


	<?php echo $form->hiddenField($model,'asiento_idasiento',array('span'=>5)); ?>
	<?php echo $form->hiddenField($model,'vista',array('span'=>5)); ?>
        

        <div class="form-actions" align="center">
        <?php 
        
        echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'id'=>'boton-submit',
        	'confirm'=>'Está seguro que desea guardar los datos?'
		)); ?>
		
		<?php 				
				echo CHtml::link('Cancelar', Yii::app()->request->Urlreferrer,array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
   		</div>

    <?php $this->endWidget(); ?>
<?php 
if(isset($vista)){
		Yii::app()->clientScript->registerScript('vista','
		$("#Compras_vista").val("'.$vista.'");');
	}
?>
</div><!-- form -->
 <?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				
				"); ?> 	