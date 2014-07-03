<?php
/* @var $this IvamovimientoController */
/* @var $model Ivamovimiento */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idivamovimiento',array('span'=>5)); ?>

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
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->