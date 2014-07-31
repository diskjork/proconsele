<?php
/* @var $this NotacreditoprovController */
/* @var $model Notacreditoprov */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idnotacreditoprov',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nrodefactura',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tipofactura',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>150)); ?>

                    <?php echo $form->textFieldControlGroup($model,'proveedor_idproveedor',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'iva',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'percepcionIIBB',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importebruto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ivatotal',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importeneto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importeIIBB',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'asiento_idasiento',array('span'=>5)); ?>

                   

                    <?php echo $form->textFieldControlGroup($model,'compras_idcompras',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nronotacreditoprov',array('span'=>5,'maxlength'=>45)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->