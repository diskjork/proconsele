<?php
/* @var $this RetencioniibbController */
/* @var $model Retencioniibb */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idretencionIIBB',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nrocomprobante',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'cliente_idcliente',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'comp_relacionado',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importe',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tasa',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->