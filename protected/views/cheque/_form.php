<?php
/* @var $this ChequeController */
/* @var $model Cheque */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cheque-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
        'clientOptions' => array(
        'validateOnSubmit' => true,
        ),
)); 
//$data_select_banco=null;
?>
		<script type="text/javascript">
			
			function clienprov(valor)
			{   
				//$('#select-cliente').hide();
				
			    if(valor == 1){
				    $('#select-cliente').hide();
			        $('#select-proveedor').show();
			        $('#Titular').hide();
			        $('#Cheque_titular').val("YVN S.R.L");
			        
			        $.ajax({
			  		  type: "POST",
			  		  url: '<?php echo $this->createUrl('listabanco');?>',
			  		  data: {data:valor},
			  		  success: function (data){
			  			
			  			$('#Cheque_Banco_idBanco').html(data);
			  			$('.select2-container').css('width','50%');
			  			$('#Cheque_Banco_idBanco').prop("selectedIndex", -1);
			  			$('a.select2-choice > span').html("Seleccione un Banco");
			  			
			  			  },
			  		  dataType: "html"
			  		  });
			  
    
			    } else {
			    	$('#select-proveedor').hide();
			    	$('#select-cliente').show();
			    	$('#Titular').show();
			    	$('#Cheque_titular').val('<?php if($model->debeohaber == 0){ echo $model->titular;}else{ echo "";}?>');
			    	$.ajax({
				  		  type: "POST",
				  		  url: '<?php echo $this->createUrl('listabanco');?>',
				  		  data: {data:valor},
				  		  success: function (data){
				  			  
				  			  
				  			$('#Cheque_Banco_idBanco').html(data);
				  			$('.select2-container').css('width','50%');
				  			$('#Cheque_Banco_idBanco').prop("selectedIndex", -1);
				  			$('a.select2-choice > span').html("Seleccione un Banco");
				  			
				  			  },
				  		  dataType: "html"
				  		  });
			        
				}
			}
		</script>
    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>
<?php if(isset($model->debeohaber)){
		if($model->debeohaber == 0){
		Yii::app()->clientScript->registerScript('test',"
				clienprov(0);"); 	
		} else {
		Yii::app()->clientScript->registerScript('test',"
				clienprov(1);"); 	
		}
}
	?>			

    <?php // echo $form->errorSummary($model); ?>
    		
    		
    		<?php echo $form->inlineRadioButtonListControlGroup($model, 'debeohaber', array(
				'Recibido',
				'Liberado'),
    			array('onChange' => 'clienprov(this.value);')
    		); ?>
    		<div class="row-fluid">
    			<div class="span5">
		    		 <?php  echo $form->label($model, 'fechaingreso')?>
		            <div class="input-append">
		            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
		        		'model' => $model,
		            	'attribute' => 'fechaingreso',
		            	'pluginOptions' => array(
		         				'format' => 'dd/mm/yyyy',
		         				'width' => '40',
		            			),
		            	'htmlOptions' => array(
								            'placeholder' => 'Seleccionar fecha',
								        	'class' => 'input-medium',
								        ),
		  			  ));
					?>
					 <span class="add-on"><icon class="icon-calendar"></icon></span>
					 </div>
				</div>
				<div class="span5">	
		           	<?php  echo $form->label($model, 'fechacobro')?>
		            <div class="input-append">
		           
		            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
		        		'model' => $model,
		            	'attribute' => 'fechacobro',
		            	'pluginOptions' => array(
		         				'format' => 'dd/mm/yyyy',
		         				'width' => '40',
		            			),
		            	'htmlOptions' => array(
								            'placeholder' => 'Seleccionar fecha',
								        	'class' => 'input-medium',
								        ),
		  			  ));
					?>
					 <span class="add-on"><icon class="icon-calendar"></icon></span>
					 </div>
				</div>
			</div>
            <div class="row-fluid">
    			<div class="span5">
		           	<?php  echo $form->label($model, 'importe')?>
		    			<div class="input-prepend">
							<span class="add-on">$</span>
							<?php $this->widget('yiiwheels.widgets.maskmoney.WhMaskMoney', array(
								'model'=>$model,
								'attribute' => 'importe',
								'htmlOptions' => array(
									'placeholder' => '$',
									'class' => 'input-medium',
								),
							));?>
						</div>
					</div>
				<div class="span6">
					<?php  echo $form->textFieldControlGroup($model,'nrocheque'); ?>
				</div>
    		</div>
			 <div id="select-cliente" style="display:none">
           	<?php echo $form->dropDownListControlGroup(
			 		$model, 
			 		'cliente_idcliente',
			 		GxHtml::listDataEx(Cliente::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idcliente','nombre'),
			 		array('empty' => 'Seleccione un Cliente')
			 		); ?>
			</div>
			<div id="select-proveedor" style="display:none">
			<?php echo $form->dropDownListControlGroup(
			 		$model, 
			 		'proveedor_idproveedor',
			 		GxHtml::listDataEx(Proveedor::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idproveedor','nombre'),
			 		array('empty' => 'Seleccione un Proveedor')
			 		); ?>
			</div>
			<div>
            <?php echo $form->textFieldControlGroup($model,'titular',array('span'=>5,'maxlength'=>45, 'onClick'=>'$(this).val("");')); ?>
           </div>
           <div>
            <?php echo $form->label($model, 'cuittitular');?>
					<?php 
						$this->widget(
							'yiiwheels.widgets.maskinput.WhMaskInput',
							array(
								'model'=>$model,
								'attribute' => 'cuittitular',
								'mask' => '00-00000000-0',
								'htmlOptions' => array('placeholder' => '00-00000000-0')
							)
					);?>
			</div>
			
			<div>
            <?php echo $form->label($model, 'Banco_idBanco');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'listabancos',
				  'model'=>$model,
				  'attribute'=>'Banco_idBanco',
				  //'data'=>array('0'=>null),
				  'options'=>array(
					   'placeholder'=>'Seleccione un Banco',
					   'allowClear'=>true,
						'width'=> '50%',
					  ),
				)); ?>
				<?php echo $form->error($model,'Banco_idBanco',array('style'=>'color:#b94a48')); ?>
			</div>
             
       <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
		
		<?php 
			
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cheque/admin',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
$('.form-actions').css('background-color','transparent');

function solonumeromod(event) {
    if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
        (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode == 110 || event.keyCode == 190) ) {
            return;
        }
        else {
        
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) ) {
                event.preventDefault();
            }
        }
    }
$("#Cheque_nrocheque").keydown(function(event){
	solonumeromod(event);});
</script>