<?php
/* @var $this MovimientobancoController */
/* @var $model Movimientobanco */
/* @var $form TbActiveForm */
if(isset($_GET['vista'])){
		$vista=$_GET['vista'];
		
	}
	if(isset($vista)){
		Yii::app()->clientScript->registerScript('vista',"
		$('#Movimientobanco_vista').val('".$vista."');");
	}
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'movimientobanco-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
        'clientOptions' => array(
        'validateOnSubmit' => true,
        ),
)); 

?>

    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
			
    		<?php echo $form->inlineRadioButtonListControlGroup($model, 'debeohaber', array(
				'Ingreso',
				'Egreso')
			 ); ?>
            
            <div class="row-fluid">
    				<div class="span5">
    				<?php  echo $form->label($model, 'fecha')?>
			            <div class="input-append">
				            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
				        		'model' => $model,
				            	'attribute' => 'fecha',
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
            </div>
			 <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>45)); ?>
            
			
            <?php // echo $form->textFieldControlGroup($model,'Banco_idBanco',array('span'=>5)); ?>
			<?php echo $form->label($model, 'ctabancaria_idctabancaria');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'ctabancaria_idctabancaria',
				  'data' => GxHtml::listDataEx(Ctabancaria::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idctabancaria','nombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta',
					   'allowClear'=>true,
						'width'=> '60%',
					  ),
				)); ?>
				<?php  echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
            <?php //echo  $form->textFieldControlGroup($model,'formadepago_idformadepago',array('span'=>5)); ?>
			 <?php //echo $form->label($model, 'formadepago_idformadepago');?>
            <?php //echo $form->hiddenField($model,'formadepago_idformadepago', array('value'=>'3')); ?>
			 <div>
			 <br>
            <?php echo $form->label($model, 'cuenta_idcuenta');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'cuenta_idcuenta',
				  'data' => GxHtml::listDataEx(Cuenta::model()->findAllAttributes(array('codigocta,nombre'),true,array('condition'=>'asentable=1','order'=>'codigocta ASC')),'idcuenta','codNombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta',
					   'allowClear'=>true,
						'width'=> '60%',
					  ),
				)); ?>
				<?php  echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
            <?php echo $form->hiddenField($model, 'vista', array());?>
		
        <div class="form-actions" align="center">
        <?php 
        
        echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
		
		<?php 
			
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/movimientobanco/admin',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
    </div>
</div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				
				"); ?> 	