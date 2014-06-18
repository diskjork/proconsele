<?php
/* @var $this MovimientocajaController */
/* @var $model Movimientocaja */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idmovimientocaja',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'debe',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'haber',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'numerooperacion',array('span'=>5,'maxlength'=>20)); ?>

                    <?php echo $form->textFieldControlGroup($model,'caja_idcaja',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'rubro_idrubro',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'formadepago_idformadepago',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->