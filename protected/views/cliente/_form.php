<?php
/* @var $this ClienteController */
/* @var $model Cliente */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cliente-form',
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

       <p class="help-block">Campos obligatorios <span class="required">*</span></p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>45)); ?>
			<div class="row-fluid">
				<div class="span6">			
					<?php echo $form->label($model, 'cuit');?>
					<?php 
						$this->widget(
							'yiiwheels.widgets.maskinput.WhMaskInput',
							array(
								'model'=>$model,
								'attribute' => 'cuit',
								'mask' => '00-00000000-0',
								'htmlOptions' => array('placeholder' => '00-00000000-0')
							)
					);?>
				</div>
				<div class="span5">
					<?php echo $form->label($model, 'tipodecontribuyente_idtipocontribuyente');?>
					<?php
					    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
						    'asDropDownList' => true,
						    'model'=>$model,
			    			'attribute' => 'tipodecontribuyente_idtipocontribuyente',
				    		'data' => GxHtml::listDataEx(Tipodecontribuyente::model()->findAllAttributes(null,true)),
						    'pluginOptions' => array(
						    	'width' => '100%',
					    		'minimumResultsForSearch' => '3',
					    	),
					    ));
					?>
				</div>
			</div>	
            <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>
			
            <?php echo $form->label($model, 'localidad_idlocalidad');?>
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
            <?php echo $form->textFieldControlGroup($model,'telefono',array('span'=>2,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'nombrecontacto',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'email',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'web',array('span'=>5,'maxlength'=>45)); ?>
			
			

        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Cargar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        	'confirm'=>'Está seguro que desea guardar los datos?'
		)); ?>
		<?php 
			echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cliente/admin',array ('class'=>'btn btn-primary'));
		?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->