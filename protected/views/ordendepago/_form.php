<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js">
</script>
<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/ordendepago.js', CClientScript::POS_HEAD);?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js">
</script>

<?php
/* @var $this OrdendepagoController */
/* @var $model ordendepago */
/* @var $form TbActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'ModalChequecargados',
    'header' => '<h4>Seleccione un Cheque </h4>',
	'fade'=>false,
    'content' => $this->renderPartial('gridcheque',array('modelchequecargado'=>$modelchequecargado), true),
  )); ?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'ordendepago-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('class'=>'well'),
)); ?>

   

   <?php
    //show errorsummary at the top for all models
    //build an array of all models to check
    echo $form->errorSummary(array_merge(array($model),$validatedMembers));
	?>
	
            <?php // echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>
           <div class="row-fluid"> 
           <div class="span6">
           <?php echo $form->labelEx($model, 'ctacteprov_idctacteprov');?>
			<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'ctacteprov_idctacteprov',
				  'data' =>GxHtml::listDataEx(Proveedor::model()->
						   				findAll('estado = :estado ORDER BY nombre ASC', array(':estado' => 1)),'ctacteprov_idctacteprov','nombre'),
				  'options'=>array(
					   'placeholder'=>'Proveedor',
					   'allowClear'=>true,
						'width'=> '70%',
						
					  ),
				)); ?>
			<?php  echo $form->error($model,'ctacteprov_idctacteprov',array('style'=>'color:#b94a48')); ?>
		
           </div>
           
           <div class="span3">
           
					<?php echo $form->label($model, 'fecha');?>
					 <div class="input-append" >
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
				<div class="span3">
			<div class="well" style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;" id="blocksaldo">
				<h5 style="padding:0px">Saldo</h5>
				<h5 style="text-align:center;margin:0;margin-left:-4px;" id="saldoblock"></h5>
			</div>
		
			</div>	
			</div>		
			<br>
			<?php //echo $form->hiddenField($model,'ctacteprov_idctacteprov',array('span'=>5)); ?>
            <?php echo $form->hiddenField($model,'descripcionordendepago',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->hiddenField($model,'importe',array('span'=>5,'maxlength'=>45)); ?>

            <?php //echo $form->textFieldControlGroup($model,'detallectactecliente_iddetallectactecliente',array('span'=>5)); ?>
            
		<div>
        <?php  
		$arrayBancos=GxHtml::listDataEx(Banco::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idBanco','nombre');
		$arrayBancosCargados=GxHtml::listDataEx(Banco::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idBanco','nombre');
		$arrayCtasCargados=GxHtml::listDataEx(Ctabancaria::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idctabancaria','nombre');
		$arrayCajas=GxHtml::listDataEx(Caja::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idcaja','nombre');
		$arrayChequeras=GxHtml::listDataEx(Chequera::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idchequera','nombre');
		$memberFormConfig = array(
					      'elements'=>array(
					        'tipoordendepago'=>array(
								
					            'type'=>'dropdownlist',
								'items'=>array('0'=>'Efectivo',
											   '1'=>'Cheque propio',
											   '2'=>'Transferencia',
											   '3'=>'Cheque de tercero'),
								'prompt'=>'Seleccione tipo de cobro..',
					            'class'=>'span2',
								
								'onChange'=>'   var idselect=$(this).attr("id");
										        var valor=$(this).val();
										        var obj={ id:idselect, val:valor};
										        borradoinputs(idselect);
										        seleccion(obj);
										        if(valor == 3){$("#ModalChequecargados").modal();
												var id_=this.id;
												objetoseleccionado={ id:id_};
												 }
										        ',
					        ),
					        'transferenciabanco'=>array(
								
					            'type'=>'dropdownlist',
								'items'=>$arrayCtasCargados,
								'prompt'=>'Seleccione un Cuenta..',
					            'class'=>'span2',
					        	
					        ),
					         'chequetitular'=>array(
					        	'type'=>'text',
					            'class'=>'span1',
					        ),
					        'idcheque'=>array(
					            'type'=>'text',
					            'class'=>'span1',
					        ),
					       
							'chequecuittitular'=>array(
					        	'type'=>'text',
					            'class'=>'span1',
					        ),
					        'chequebanco'=>array(
					            'type'=>'dropdownlist',
					           	'items'=>$arrayBancosCargados,
								'prompt'=>'Seleccione un Banco..',
					            'class'=>'span2',
					        ),
					        'chequera'=>array(
					            'type'=>'dropdownlist',
					           	'items'=>$arrayChequeras,
								'prompt'=>'Chequera...',
					            'class'=>'span2',
					        ),
					        'chequefechaingreso'=>array(              
               					 	'type'=>'zii.widgets.jui.CJuiDatePicker',
                				 	'language'=>'es',
			                		'options'=>array(
			                    	'showAnim'=>'fold',
					            ),
			                ),
					      
					        'chequefechacobro'=>array(              
               					 'type'=>'zii.widgets.jui.CJuiDatePicker',
                				 'language'=>'es',
			                'options'=>array(
			                    'showAnim'=>'fold',
					            ),
			                ),
					        'nrocheque'=>array(
					            'type'=>'text',
					            'class'=>'span1',
					        ),
					        'caja_idcaja'=>array(
								
					            'type'=>'dropdownlist',
								'items'=>$arrayCajas,
								'prompt'=>'Seleccione Caja..',
					            'class'=>'span2',
					        	
					        ),
					        'importe'=>array(
					            'type'=>'text',
					            'class'=>'span1',
					        	'onblur'=>'sumatotal();',
					        	'onkeydown'=>'solonumeromod(event);
					        				  this.val().toFixed(2);',
					        ),
					         
					    ));
		
		$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_member', //the unique widget id
        'formConfig' => $memberFormConfig, //the form configuration array
        'model' => $member, //instance of the form model
 		'bootstrapLayout'=>true,
   		//'jsAfterCloneCallback'=>'alertIds',
		'tableView' => true,
		
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
	</div>
		<div>
			<div class="well " style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
				<h5 style="padding:0px">Total</h5>
				<h5 style="text-align:center;margin:0;margin-left:-4px;" id="totalnetoblock"></h5>
			</div>
		</div>

        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Cargar' : 'Guardar',array(
		    'class'=>'btn btn-primary',
        	'id'=>'boton-submit',
        	'confirm'=>'Está seguro que desea guardar los datos?'
		     )); ?>
		     <?php 
		    	echo CHtml::link('Cancelar',Yii::app()->request->Urlreferrer,
				array('class'=>'btn btn-primary'));
			?>
		
    	</div>
		
    <?php $this->endWidget(); ?>

</div><!-- form -->