<?php
/* @var $this NotacreditoController */
/* @var $model Notacredito */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'idnotacredito',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nrodefactura',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'formadepago',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'cliente_idcliente',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'descrecar',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tipodescrecar',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'iva',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'retencionIIBB',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'cantidadproducto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'producto_idproducto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'nombreproducto',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'precioproducto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'stbruto_producto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'asiento_idasiento',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'impuestointerno',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'desc_imp_interno',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importebruto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ivatotal',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importeneto',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importeIIBB',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'importeImpInt',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'factura_idfactura',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->