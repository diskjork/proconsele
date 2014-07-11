<?php
/* @var $this ChequeController */
/* @var $model Cheque */
/* @var $modelCaja Movimientocaja */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'acreditarendozar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
	//'enableAjaxValidation'=>true,
	//'enableAjaxValidation'=>true,
	'enableAjaxValidation'=>false,
    
)); ?>
    
     
	<div class="container-fluid">
    	<div class="row-fluid">
	    	<div class="well">
  			<?php echo "<strong>Banco: </strong>".$modelcheque->bancoIdBanco."<br>";?>	
    		<?php echo "<strong>Cheque Nro.: </strong>".$modelcheque->nrocheque."<br>";?>
    		<?php echo "<strong>Titular: </strong>".$modelcheque->titular."<br>";?>
            <?php //echo $form->textFieldControlGroup($model,'concepto',array('span'=>5,'maxlength'=>45,'disabled'=>true)); ?>
			<?php echo "<strong>Fecha de Recepción: </strong>".$modelcheque->fechaingreso."<br>";?>
			<?php echo "<strong>Fecha de Cobro: </strong>".$modelcheque->fechacobro."<br>";?>
			<?php echo "<strong>Relacionado a la Entidad: </strong>".$modelcheque->clienteIdcliente."<br>";?>
			</div>
					
			<!--  Cambio de estado del cheque -->
			<?php echo $form->hiddenField($modelcheque,'estado', array('value'=>'3')); ?>
			<?php echo $form->hiddenField($modelcheque,'importe',array('value'=>$modelcheque->debe)); ?>
			
			
			<p><b>Importe</b></p>
            <div class="input-prepend">
            
				<span class="add-on">$</span>
				<?php $this->widget('yiiwheels.widgets.maskmoney.WhMaskMoney', array(
				'model'=>$modelcheque,
				'attribute' => 'debe',
				'htmlOptions'=>array('disabled' => true)
				));?>
				</div>
			<br>
		</div>
		</div>	

    
   

              <?php // echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>
           <div class="row-fluid"> 
           <div class="span4">
            <div class="input-append" >
					<?php echo $form->label($model, 'fecha');?>
		            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
					        'model' => $model,
							'attribute' => 'fecha',
		            	    'pluginOptions' => array(
					            'format' => 'dd/mm/yyyy',
		            			),
					        'htmlOptions' => array(
					            //'placeholder' => 'Seleccionar fecha',
					        	'class' => 'input-medium',
					        	
					            'value'=>date('d/m/Y'),
					        )
					    ));
					    ?>
					
					<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
				</div>
				
			</div>		
			<br>
			 <?php echo $form->label($model, 'ctacteprov_idctacteprov');?>	
			 <?php $sql="SELECT proveedor.nombre as nombre, ctacteprov.idctacteprov as idctacte
    							FROM proveedor, ctacteprov
    							WHERE proveedor.idproveedor = ctacteprov.proveedor_idproveedor;";
    							$dbCommand = Yii::app()->db->createCommand($sql);
								$resultado = $dbCommand->queryAll();
    							
    							?>
			            <?php
						   $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
							    'asDropDownList' => true,
							    'model'=>$model,
						   		'language'=>'es',
				    			'attribute' => 'ctacteprov_idctacteprov',
					    		'data' => GxHtml::listDataEx($resultado,'idctacte','nombre'),
					    		'pluginOptions' => array(
							    	'width' => '90%',
						    		'minimumResultsForSearch' => '3',
						   			
						    	),
						    ));
						?>
            <?php echo $form->hiddenField($model,'descripcionordendepago',array('span'=>5,'maxlength'=>45,'value'=>'Orden de pago-Cheque Endozado')); ?>

            <?php echo $form->hiddenField($model,'importe',array('span'=>5,'maxlength'=>45)); ?>

            <?php //echo $form->textFieldControlGroup($model,'detallectactecliente_iddetallectactecliente',array('span'=>5)); ?>
            
		
        <?php  
		//$arrayBancos=GxHtml::listDataEx(Banco::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idBanco','nombre');
		//$arrayBancosCargados=GxHtml::listDataEx(Banco::model()->findAllAttributes(array('nombre'),true,array('condition'=>'propio=1','order'=>'nombre ASC')),'idBanco','nombre');
		$memberFormConfig = array(
					      'elements'=>array(
					        'tipoordendepago'=>array(
					            'type'=>'text',
								
							),
					        'transferenciabanco'=>array(
								'type'=>'text',
					            		        	
					        ),
					        'idcheque'=>array(
					            'type'=>'text',
					        ),
					        'chequebanco'=>array(
					            'type'=>'text',
					            
					        ),
					        'chequetitular'=>array(
					            'type'=>'text',
					            
			                ),
			                'chequecuittitular'=>array(
					            'type'=>'text',
					            
			                ),
					        'chequefechaingreso'=>array(
					            'type'=>'text',
					            
			                ),
					      
					        'chequefechacobro'=>array(
					            'type'=>'text',
					            
			                ),
					        'nrocheque'=>array(
					            'type'=>'text',
					            
					        ),
					        'importe'=>array(
					            'type'=>'text',
					         
					        ),
					         
					    ));
		
		$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_member', //the unique widget id
        'formConfig' => $memberFormConfig, //the form configuration array
        'model' => $member, //instance of the form model
 		'bootstrapLayout'=>true,
   		//'jsAfterCloneCallback'=>'alertIds',
		'tableView' => false,
		
		'addItemText' => '(+)',
		'removeText' => '(-)',
		'removeConfirm' => 'Quitar este elemento?',
		'showErrorSummary' => false,
		'showAddItemOnError'=>true,
   		'hideCopyTemplate'=>true,
   		'addItemAsButton'=>true,
        //if submitted not empty from the controller,
        //the form will be rendered with validation errors
        'validatedItems' => $validatedMembers,
		'jsAfterNewId' => MultiModelForm::afterNewIdDatePicker($memberFormConfig['elements']['chequefechaingreso']),
 
        //array of member instances loaded from db
        'data' => $member->findAll('ordendepago_idordendepago=:groupId', array(':groupId'=>$model->idordendepago)),
    ));
	?>	
	
		

        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton('Endozar',array(
		    'class'=>'btn btn-primary',
        	//'id'=>'boton-submit',
		     )); ?>
		<?php 
			
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cheque/admin',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
    	</div>
		
    <?php $this->endWidget(); ?>
   </div><!-- form -->
    
    <script>
   	$("#id_member").css("display","none");
    $("#Ordendepago_importe").val(<?php echo $modelcheque->debe;?>);
    $("#Detalleordendepago_importe").val(<?php echo $modelcheque->debe;?>);
    $("#Detalleordendepago_chequefechaingreso").val("<?php echo $modelcheque->fechaingreso;?>");
    $("#Detalleordendepago_idcheque").val("<?php echo $modelcheque->idcheque;?>");
    $("#Detalleordendepago_tipoordendepago").val("3");
    $("#Detalleordendepago_chequebanco").val(<?php echo $modelcheque->Banco_idBanco;?>);
    $("#Detalleordendepago_chequetitular").val("<?php echo $modelcheque->titular;?>");
    $("#Detalleordendepago_chequecuittitular").val(<?php echo $modelcheque->cuittitular;?>);
    
    $("#Detalleordendepago_chequefechacobro").val("<?php echo $modelcheque->fechacobro;?>");
    $("#Detalleordendepago_nrocheque").val("<?php echo $modelcheque->nrocheque;?>");
    
    </script>