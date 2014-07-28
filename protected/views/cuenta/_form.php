<?php
/* @var $this CuentaController */
/* @var $model Cuenta */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cuenta-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'codigocta',array('span'=>2,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>45)); ?>

            <?php //echo $form->textFieldControlGroup($model,'tipocuenta_idtipocuenta',array('span'=>5)); ?>
			
					<?php echo $form->label($model, 'tipocuenta_idtipocuenta');?>
					<?php
					    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
						    'asDropDownList' => true,
						    'model'=>$model,
					    	'language'=>'es',
			    			'attribute' => 'tipocuenta_idtipocuenta',
				    		'data' => GxHtml::listDataEx(Tipocuenta::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idtipocuenta','nombre'),
						    'pluginOptions' => array(
						    	'width' => '50%',
					    		 'placeholder' => 'type 2amigos',
					    	),
					    ));
					?>
			<br><br>	
            <?php // echo $form->textFieldControlGroup($model,'asentable',array('span'=>5)); ?>
            <?php echo $form->labelEx($model, 'asentable');?>
					<?php
					    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
						    'asDropDownList' => true,
						    'model'=>$model,
					    	'language'=>'es',
			    			'attribute' => 'asentable',
				    		'data' => array('1'=>'Se asienta','0'=>'No se asienta'),
						    'pluginOptions' => array(
						    	'width' => '20%',
					    		//'minimumResultsForSearch' => '3',
					    	),
					    ));
					?>

        <div class="form-actions" align="center">
        <?php 
        
        echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
		
		<?php 
			
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cuenta/admin',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				
				"); ?> 	