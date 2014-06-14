<?php
/* @var $this BancoController */
/* @var $model Banco */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idBanco',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'telefono',array('span'=>5,'maxlength'=>20)); ?>

                    <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'propio',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'localidad_idlocalidad',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->