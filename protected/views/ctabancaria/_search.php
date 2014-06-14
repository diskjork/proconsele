<?php
/* @var $this CtabancariaController */
/* @var $model Ctabancaria */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idctabancaria',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textAreaControlGroup($model,'descripcion',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'banco_idBanco',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tipoctabancaria_idtipoctabancaria',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->