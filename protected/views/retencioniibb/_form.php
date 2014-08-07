<?php
/* @var $this RetencioniibbController */
/* @var $model Retencioniibb */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'retencioniibb-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'idretencionIIBB',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'nrocomprobante',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'cliente_idcliente',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'comp_relacionado',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'importe',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'tasa',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
        	'confirm'=>'Está seguro que desea guardar los datos?'
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->