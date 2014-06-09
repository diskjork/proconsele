<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */
/* @var $form TbActiveForm */
?>

<div class="form" id="jobDialogForm">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'proveedor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
    'htmlOptions'=>array('class'=>'well'),
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>4,'maxlength'=>45)); ?>

            <?php //echo $form->textFieldControlGroup($model,'cuit',array('span'=>5,'maxlength'=>20)); ?>
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
			
            <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>4,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'telefono',array('span'=>4,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'nombrecontacto',array('span'=>4,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'email',array('span'=>4,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'web',array('span'=>4,'maxlength'=>45)); ?>

            <?php //echo $form->textFieldControlGroup($model,'tipodecontribuyente_idtipodecontribuyente',array('span'=>5)); ?>
			<?php echo $form->label($model, 'tipodecontribuyente_idtipodecontribuyente');?>
			<?php
			    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				    'asDropDownList' => true,
				    'model'=>$model,
	    			'attribute' => 'tipodecontribuyente_idtipodecontribuyente',
		    		'data' => GxHtml::listDataEx(Tipodecontribuyente::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC'))),
				    'pluginOptions' => array(
				    	'width' => '70%',
			    		'minimumResultsForSearch' => '3',
			    	),
			    ));
			?>
			<br><br>	
            <?php //echo $form->textFieldControlGroup($model,'localidad_idlocalidad',array('span'=>5)); ?>
			<?php echo $form->label($model, 'localidad_idlocalidad');?>
			<?php
			    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				    'asDropDownList' => true,
				    'model'=>$model,
	    			'attribute' => 'localidad_idlocalidad',
		    		'data' => GxHtml::listDataEx(Localidad::model()->findAllAttributes(array('nombre','provincia_idprovincia'),true,array('order'=>'nombre ASC')),'idlocalidad','fullname'),
				    'pluginOptions' => array(
				    	'width' => '70%',
			    		'minimumResultsForSearch' => '3',
			    	),
			    ));
			?>
			
        <div class="form-actions">
        <?php /*echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_SMALL,
			));*/

        	 echo TbHtml::ajaxSubmitButton(Yii::t('proveedor','Nuevo Proveedor'),CHtml::normalizeUrl(array('proveedor/addnew','render'=>false)),array('success'=>'js: function(data) {
                        $("#Compras_proveedor_idproveedor").append(data);
                        $("#jobDialog").dialog("close");
                    }'),array('id'=>'closeJobDialog','color'=>TbHtml::BUTTON_COLOR_PRIMARY,'size'=>TbHtml::BUTTON_SIZE_SMALL));
		
			
        	 ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->