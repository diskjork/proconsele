<?php
/* @var $this DetallectacteclienteController */
/* @var $model Detallectactecliente */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'iddetallectactecliente',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tipo',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'iddocumento',array('span'=>5,'maxlength'=>20)); ?>

                    <?php echo $form->textFieldControlGroup($model,'debe',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'haber',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ctactecliente_idctactecliente',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->