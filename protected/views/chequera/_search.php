<?php
/* @var $this ChequeraController */
/* @var $model Chequera */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idchequera',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tipo',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ctabancaria_idctabancaria',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->