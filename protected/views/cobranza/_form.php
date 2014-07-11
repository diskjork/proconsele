<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js">
</script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/cobranza.js', CClientScript::POS_HEAD);?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js">
</script>

<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */
/* @var $form TbActiveForm */
?>
<?php if(isset($_GET['idctacte'])){
	//echo "si si".$_GET['idctacte']."ja".$_GET['nombre'];
	$idctactecliente=$_GET['idctacte'];
	$detallecliente=Ctactecliente::model()->findByPk($idctactecliente);
	$saldo=$detallecliente->saldo;
	//$model->detallectactecliente_iddetallectactecliente=$_GET['idctacte'];
} else {$idctactecliente=null;
		$saldo=null; }?>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cobranza-form',
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
				<div class="span4">
	
			<div class="well" style="width:50px;height:50px;padding-top:0px;text-align:center;margin-right:auto;margin-left:auto;">
				<h5 style="padding:0px">Saldo</h5>
				<h5 style="text-align:center;margin:0;margin-left:-4px;" id="saldoblock"><?php echo number_format($saldo,2,'.',',');?></h5>
			</div>
		
			</div>	
			</div>		
			<br>
			<?php echo $form->hiddenField($model,'ctactecliente_idctactecliente',array('span'=>5,'value'=>$idctactecliente)); ?>
            <?php echo $form->hiddenField($model,'descripcioncobranza',array('span'=>5,'maxlength'=>45,'value'=>'Cobranza')); ?>

            <?php echo $form->hiddenField($model,'importe',array('span'=>5,'maxlength'=>45)); ?>

            <?php //echo $form->textFieldControlGroup($model,'detallectactecliente_iddetallectactecliente',array('span'=>5)); ?>
           
		<div>
        <?php  
		$arrayBancos=GxHtml::listDataEx(Banco::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idBanco','nombre');
		$arrayCtasCargados=GxHtml::listDataEx(Ctabancaria::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idctabancaria','nombre');
		$arrayCajas=GxHtml::listDataEx(Caja::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idcaja','nombre');
		
		$memberFormConfig = array(
					      'elements'=>array(
					        'tipocobranza'=>array(
								
					            'type'=>'dropdownlist',
								'items'=>array('0'=>'Efectivo',
											   '1'=>'Cheque',
											   '2'=>'Transferencia',
											   '3'=>'Cert. Retención IIBB'),
								'prompt'=>'Seleccione tipo de cobro..',
					            'class'=>'span2',
								
								'onChange'=>'   var idselect=$(this).attr("id");
										        var valor=$(this).val();
										        var obj={ id:idselect, val:valor};
										        seleccion(obj);',
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
							'chequecuittitular'=>array(
					        	'type'=>'text',
					            'class'=>'span1',
					        ),
					        'chequebanco'=>array(
					            'type'=>'dropdownlist',
					           	'items'=>$arrayBancos,
								'prompt'=>'Seleccione un Banco..',
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
					        
					         'iibbnrocomp'=>array(
					            'type'=>'text',
					            'class'=>'span2',
					        	'onkeydown'=>'solonumeromod(event);',
					        ),
					        'iibbfecha'=>array(              
               					 'type'=>'zii.widgets.jui.CJuiDatePicker',
                				 'language'=>'es',
					                'options'=>array(
					                    'showAnim'=>'fold',
							            ),
			                ),
			                 'iibbcomprelac'=>array(
					            'type'=>'text',
					            'class'=>'span2',
					        ),
					        'iibbtasa'=>array(
					            'type'=>'text',
					            'class'=>'span1',
					        	'onkeydown'=>'solonumeromod(event);',
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
        'data' => $member->findAll('cobranza_idcobranza=:groupId', array(':groupId'=>$model->idcobranza)),
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
        	'onClick'=>'sumatotal();',
		     )); ?>
	    <?php 
	    	echo CHtml::link('Cancelar',Yii::app()->createUrl("ctactecliente/admin"),
			array('class'=>'btn btn-primary'));
		?>
    	</div>
		
    <?php $this->endWidget(); ?>

</div><!-- form -->