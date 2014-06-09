<?php
/* @var $this CtacteprovController */
/* @var $data Ctacteprov */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idctacteprov')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idctacteprov),array('view','id'=>$data->idctacteprov)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debe')); ?>:</b>
	<?php echo CHtml::encode($data->debe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('haber')); ?>:</b>
	<?php echo CHtml::encode($data->haber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saldo')); ?>:</b>
	<?php echo CHtml::encode($data->saldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor_idproveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor_idproveedor); ?>
	<br />


</div>