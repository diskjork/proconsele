<?php
/* @var $this CtacteprovController */
/* @var $model Ctacteprov */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idctacteprov',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'debe',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'haber',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'saldo',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'proveedor_idproveedor',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->