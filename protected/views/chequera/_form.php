<?php
/* @var $this ChequeraController */
/* @var $model Chequera */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'Chequera-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,      //-----
    'clientOptions' => array(       // lo que hay q agregar para que te valide ajax en el modal
        'validateOnSubmit' => true,		//
    ),
)); ?>

    <p class="help-block">Campos requeridos <span class="required"> *</span>.</p>

    <?php echo $form->errorSummary($model); ?>

            
		
		<?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5)); ?>
			
        <?php echo $form->textAreaControlGroup($model,'descripcion',array('rows'=>2,'span'=>5));?>
       	
        <?php echo $form->labelEx($model, 'tipo');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'tipo',
				  'data' => array('Pago directo','Pago diferido'),
				  'options'=>array(
					   'placeholder'=>'Seleccione el tipo',
					   'allowClear'=>true,
						'width'=> '50%',
					  ),
				)); ?>
				<?php  echo $form->error($model,'tipo',array('style'=>'color:#b94a48')); ?>
		<br><br>
		
		
        <?php //cuenta bancaria relacionada a la chequera, de donde sale el dinero, se usa para cdo
        	// se hace el movimiento banco, debitar.
        echo $form->labelEx($model, 'ctabancaria_idctabancaria');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'ctabancaria_idctabancaria',
				  'data' => GxHtml::listDataEx(Ctabancaria::model()->findAllAttributes(array('idctabancaria,nombre'),true,
       						array('condition'=>'estado=1','order'=>'nombre ASC')),'idctabancaria','nombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta bancaria',
					   'allowClear'=>true,
					   'width'=> '70%',
					  ),
				)); ?>
		<?php  echo $form->error($model,'ctabancaria_idctabancaria',array('style'=>'color:#b94a48')); ?>
		
		<br><br>
		
        <?php 
        // cuenta bancaria cdo se genera un cheque, cuando se emite un cheque se utiliza esta cuenta
        echo $form->labelEx($model, 'cuenta_idcuenta');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'cuenta_idcuenta',
				 'data' => GxHtml::listDataEx(Cuenta::model()->findAllAttributes(array('codigocta,nombre'),true,
       					array('condition'=>'asentable=1','order'=>'codigocta ASC')),'idcuenta','codNombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta..',
					   'allowClear'=>true,
					   'width'=> '70%',
					  ),
				)); ?>
		<?php  echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
         </div>    
					
        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_DEFAULT,
        	'confirm'=>'Está seguro que desea guardar los datos?'
		)); ?>
		<?php 
			echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/chequera/admin',array ('class'=>'btn btn-primary'));
		?>
	

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
						
	       				
				");?> 	