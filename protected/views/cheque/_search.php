<?php
/* @var $this ChequeController */
/* @var $model Cheque */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idcheque',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nrocheque',array('span'=>5,'maxlength'=>20)); ?>

                    <?php echo $form->textFieldControlGroup($model,'titular',array('span'=>5,'maxlength'=>45)); ?>
                    
                    <?php echo $form->textFieldControlGroup($model,'cuittitular',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fechaingreso',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fechacobro',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'debe',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'haber',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'debeohaber',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'Banco_idBanco',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'proveedor_idproveedor',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'cliente_idcliente',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->