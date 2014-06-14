<?php
/* @var $this BancoController */
/* @var $model Banco */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'banco-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>100)); ?>

            <?php echo $form->textFieldControlGroup($model,'telefono',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'propio',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'localidad_idlocalidad',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->