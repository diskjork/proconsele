<?php
/* @var $this FacturaController */
/* @var $model Factura */
/* @var $form TbActiveForm */
if(isset($_GET['vista'])){
		$vista=$_GET['vista'];
		
	}
?>
<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js', CClientScript::POS_HEAD);?>

<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/factura.js', CClientScript::POS_HEAD);?>

<?php 
//print_r($model->attributes);
	if(isset($model->descrecar)){
		Yii::app()->clientScript->registerScript('descuento',"
				$('#Factura_desRec').prop('checked',true);
				$('#radiobutton-descRec').show();
				
				");
	}
	if(isset($model->retencionIIBB)){
		Yii::app()->clientScript->registerScript('IIBB',"
				$('#Factura_iibb').prop('checked',true);
				 $('#Factura_retencionIIBB').show();
          $('#totaldiv-iibb').show();
				//$('div .form-actions').css('background-color','transparent');
				
				");
	}
	if(isset($model->impuestointerno)){
		Yii::app()->clientScript->registerScript('impint',"
				$('#Factura_impInt').prop('checked',true);
				 $('#Factura_impuestointerno').show();
          $('#totaldiv-impint').show();
				//$('div .form-actions').css('background-color','transparent');
				
				");
	}
?>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'factura-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'ModalProducto',
    'header' => '<h4>Seleccione un Producto</h4>',
	'fade'=>false,
    'content' => $this->renderPartial('gridproductos',array('modelproducto'=>$modelformprod), true),
  )); ?>
   

    <?php echo $form->errorSummary($model); ?>
<div class="row-fluid well" id="encabezadofactura" style="margin-bottom: 5px;">
	

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
		
							
			
		
			<?php echo $form->textFieldControlGroup($model,'nrodefactura',array('width'=>'10%','class'=>'mascara')); ?>
			</div>
			<div id="nroremito" >
			<?php echo $form->textFieldControlGroup($model,'nroremito',array('width'=>'10%')); ?>
			</div>
			<div id="nropresupuesto" style="display:none;">
			<?php echo $form->textFieldControlGroup($model,'nropresupuesto',array('width'=>'10%',)); ?>
			</div>
		</td>
	</tr>
	<tr style="width:100%;">
		<td style="width:33%;">
		<?php echo $form->labelEx($model, 'cliente_idcliente');?>
		<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'cliente_idcliente',
			  'data' =>GxHtml::listDataEx(Cliente::model()->
					   				findAll('estado = :estado', array(':estado' => 1)),'idcliente','nombre'),
			  'options'=>array(
				   'placeholder'=>'Cliente',
				   'allowClear'=>true,
					'width'=> '100%',
				  ),
			)); ?>
		<?php  echo $form->error($model,'cliente_idcliente',array('style'=>'color:#b94a48')); ?>
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
<div id="detallefactura" class="row-fluid well" style="margin-bottom: 5px;">
	
	<table style="width:100%;" class="well" id="detalle">
	<thead>
	<tr>
	<th>CANTIDAD</th>
	<th>CODIGO</th>
	<th>DESCRIPCIÓN</th>
	<th>PRECIO U.</th>
	<th>SUBTOTAL</th>
	</tr>
	
	</thead>
	<tr >
	<td style="width:6%; text-align: center;">
	
	<?php echo $form->textFieldControlGroup($model,'cantidadproducto',array('label'=>false,'style'=>'width:40px;',
							'onkeydown'=> 'if((event.keyCode == 9) || (event.keyCode == 13 )  ){
            									var idselect=this.id;
            									var valor=this.value;
				        						var obj={
				        						id:idselect,
				        						val:valor};
				        						blurcantidad(obj);
				        						
            								}',
            				'onblur'=>'	var idselect=this.id;
				        						var valor=this.value;
				        						var obj={
				        						id:idselect,
				        						val:valor};
				        						blurcantidad(obj)')); ?>
	</td>
	<td style="width:6%; text-align: center;">
	<?php echo $form->textFieldControlGroup($model,'producto_idproducto',array('label'=>false,'style'=>'width:40px;',
						'onclick'=>
							'$(this).dblclick(function(){
		   						 $("#ModalProducto").modal();
		   						 var id_=this.id;
		        				 //objetoseleccionado={id:id_};
								});',
				        'onkeydown'=>
					        'if((event.keyCode == 9) || (event.keyCode == 13 )){
	        	 				var idselect=this.id;
	        					var valor=this.value;
	        					var obj={
	        						id:idselect,
	        						val:valor};
	        						//codigo(obj);
	        					codigo(obj);
					        		}',
				     	'onblur'=>
				     		'var idselect=this.id;
        					var valor=this.value;
        					var obj={
        					id:idselect,
        					val:valor};
        					//codigo(obj);',  
				 		)
	); ?>
	</td>
	<td style="width:48%; text-align: center;">
	<?php echo $form->textFieldControlGroup($model,'nombreproducto',array('label'=>false,'style'=>'width:98%;','maxlength'=>100)); ?>
	</td>
	<td style="width:15%; text-align: center;"> 
	<?php echo $form->textFieldControlGroup($model,'precioproducto',array('label'=>false,'style'=>'width:70px;',
							'onkeydown'=> 'if((event.keyCode == 9) || (event.keyCode == 13 )  ){
            					var obj={
	        						id:this.id,
	        						val:this.value};sumaSubtotal(obj);sumatotal();}',
            				'onblur'=>'var obj={
	        						id:this.id,
	        						val:this.value};sumaSubtotal(obj);sumatotal();')); ?>
											
	</td>
	<td style="width:15%; text-align: center;">
	<?php echo $form->textFieldControlGroup($model,'stbruto_producto',array('label'=>false,'style'=>'width:70px;','readonly' => true,)); ?>
	</td>
	</tr>
	</table>
<div class="row-fluid">
	<div style="float:right; margin-right:10px; margin-top:10px;" >
	<div class=" well" style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto; border: 3px solid #0E0D0D;">
			<h5 style="padding:0px">TOTAL</h5>
			<h5 style="text-align:center;margin:0;margin-left:-4px;" id="totalnetoblock"></h5>
	</div>
	 
	</div>
	
	<div  style="float:right; margin-right:10px; margin-top:10px;">
	
	<div class="well " style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-6px;">SubTotal</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="subtotalblock"></h6>
	</div>
	
	</div>
	<div style="float:right; margin-right:10px; margin-top:10px;" id="totalivadiv">
	<div class=" well  " style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-3px;">IVA</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="ivablock"></h6>
		
	</div>
	
	</div>	
	<div style="float:right; margin-right:10px; margin-top:10px; display:none;" id="totaldiv-impint">
	<div  class=" well " style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-15%;" id="label-iibb">Imp.Int.</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="total-impint"></h6>
	</div>	
	</div>
	<div style="float:right; margin-right:10px; margin-top:10px; display:none;" id="desc_recar">
	<div  class=" well " style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-15%;" id="descuento_recargo"></h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="descuento_recargo_importe"></h6>
	</div>	
	</div>		
</div>		
</div>		
				<?php echo $form->hiddenField($model,'importeneto',array('span'=>4,)); ?>
				<?php echo $form->hiddenField($model,'ivatotal',array('span'=>4,)); ?>
				<?php echo $form->hiddenField($model,'importeIIBB',array('span'=>4,)); ?>
				<?php echo $form->hiddenField($model,'importeImpInt',array('span'=>4,)); ?>
				<?php echo $form->hiddenField($model,'importebruto',array('span'=>5)); ?>
				<?php //echo $form->textFieldControlGroup($model,'descrecar',array('span'=>5)); ?>

           		 <?php // echo $form->textFieldControlGroup($model,'tipodescrecar',array('span'=>5)); ?>
				


<div class="row-fluid well" style="padding-bottom: 2px;">
	<table >
	<tr style="width:100%;">
	
	</tr>
	<tr style="width:100%;" >
	<td style="width:25%; vertical-align: top;" class="well" >
	
	<?php echo $form->label($model, 'desRec',array('label'=>'Descuento - Recargo'));?>
	<?php echo $form->checkBox($model, 'desRec',array('value'=>1));echo " Descuento - Recargo";?>
	<div id="radiobutton-descRec" style="display:none;">
	<?php echo $form->radioButtonListControlGroup($model, 'tipodescrecar', array(
	'Descuento %',
	'Recargo %',
	),array('label'=>false)); ?>
	
	
	    <?php echo $form->textFieldControlGroup(
	 			$model,
	 			'descrecar',
	 			array('span'=>4,
	 				'label'=>false,
	 				'style'=> 'width:20%',
	 				'margin-left'=>' 20%',
	 				'onkeydown'=>' 
	        				 		if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
	 				'onblur'=> 'sumatotal();',
	 				//'placeholder'=>'%',
					)); ?> 
	</div>
	</td>
	
	<td style="width:25%; vertical-align: top;" class="well" >
	
	<div >	
	
	<?php echo $form->label($model, 'iva');?>
	
 	<?php $this->widget('ext.select2.ESelect2',array(
			  //'name'=>'cuenta_idcuenta',
			 'model'=>$model,
			 'attribute'=>'iva',
			  'data' => array("1.21"=>"21%","1.105"=>"10,5%"),
			'events'=>array(
				 					'change'=>'js:sumatotal'
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
	<td style="width:25%; vertical-align: top;"  class="well" >
	
	<div >	
	<?php echo $form->label($model, 'retencionIIBB');?>
	<?php echo $form->checkBox($model, 'iibb',array('value'=>1));echo " Percepción IIBB";?>
	<?php echo $form->textFieldControlGroup($model,'retencionIIBB',array('style'=>'width:20%;','label'=>false,
				'onkeydown'=>'if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
	)); ?>
	<div style="float:left; margin-right:10px;  display:none;" id="totaldiv-iibb">
	<div  class=" well " style="width:60px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
		<h5 style="padding:0px;margin-left:-15%;" id="label-iibb">IIBB</h5>
		<h6 style="text-align:center;margin:0;margin-left:-4px;" id="total-iibb"></h6>
	</div>	
	</div>
	</div>
	</td>
	<td style="width:25%; vertical-align: top;"  class="well" >
	
	<div class="row-fluid">	
	<?php echo $form->label($model, 'impuestointerno');?>
	<?php echo $form->checkBox($model, 'impInt',array('value'=>1));echo " Imp. Interno";?>
	<?php echo $form->textFieldControlGroup($model,'impuestointerno',array('style'=>'width:20%;','label'=>false,
			'onkeydown'=>'if(event.keyCode == 9 ||event.keyCode == 13)sumatotal()',
	)); ?>
	
	
	</div>
	<div class="row-fluid" id="descripcionimpint" style="display:none;"> 
	<?php echo $form->textFieldControlGroup($model,'desc_imp_interno',array('maxlength'=>100)); ?>
	</div>
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
$('#Factura_vista').val('".$vista."');");
}?>
</div><!-- form -->
 <?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				
				"); ?> 	