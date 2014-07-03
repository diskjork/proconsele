<?php
/* @var $this IvamovimientoController */
/* @var $model Ivamovimiento */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'ivamovimiento-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'tipomoviento',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'nrocomprobante',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'proveedor_idproveedor',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'cliente_idcliente',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'cuitentidad',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'tipofactura',array('span'=>5,'maxlength'=>1)); ?>

            <?php echo $form->textFieldControlGroup($model,'tipoiva',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'importeiibb',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'importeiva',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'importeneto',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'compra_idcompra',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'factura_idfactura',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->