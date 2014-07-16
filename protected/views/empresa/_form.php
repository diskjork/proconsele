<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'proveedor-form',
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

    <p class="help-block">Campos requeridos <span class="required">*</span>.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'razonsocial',array('span'=>5,'maxlength'=>45)); ?>
			<div class="row-fluid">
				<div class="span6" >			
					<?php echo $form->labelEx($model, 'cuit');?>
					<?php 
						$this->widget(
							'yiiwheels.widgets.maskinput.WhMaskInput',
							array(
								'model'=>$model,
								'attribute' => 'cuit',
								'mask' => '00-00000000-0',
								'htmlOptions' => array(
												'placeholder' => '00-00000000-0',
												)
							)
					);?>
				</div>
				<div class="span5">
					<?php echo $form->textFieldControlGroup($model,'nombrefantasia',array('span'=>5,'maxlength'=>200,'style'=>'width: 100%;')); ?>
				</div>
			</div>	
            <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45,'style'=>'width: 70%;')); ?>
			
            <?php echo $form->labelEx($model, 'localidad_idlocalidad');?>
			<?php
			    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				    'asDropDownList' => true,
				    'model'=>$model,
	    			'attribute' => 'localidad_idlocalidad',
		    		'data' => GxHtml::listDataEx(Localidad::model()->findAllAttributes(array('nombre','provincia_idprovincia'),true,array('order'=>'nombre ASC')),'idlocalidad','fullname'),
				    'pluginOptions' => array(
				    	'width' => '50%',
			    		'minimumResultsForSearch' => '3',
			    	),
			    ));
			?>
			<br><br>
			<?php echo $form->textFieldControlGroup($model,'tiposociedad',array('span'=>5,'maxlength'=>45 ,'style'=>'width: 70%;')); ?>
			
            <?php echo $form->textFieldControlGroup($model,'telefono',array('span'=>2,'maxlength'=>45,'style'=>'width: 70%;')); ?>

            <?php echo $form->textFieldControlGroup($model,'telefax',array('span'=>5,'maxlength'=>45,'style'=>'width: 70%;')); ?>

            <?php echo $form->textFieldControlGroup($model,'email',array('span'=>5,'maxlength'=>45,'style'=>'width: 70%;')); ?>

            <?php echo $form->textFieldControlGroup($model,'web',array('span'=>5,'maxlength'=>45,'style'=>'width: 70%;')); ?>
            			
        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
		<?php 
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/index.php',array ('class'=>'btn btn-primary'));
		?>
    </div>



    <?php $this->endWidget(); ?>

</div><!-- form -->