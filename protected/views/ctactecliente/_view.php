<?php
/* @var $this CtacteclienteController */
/* @var $data Ctactecliente */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idctactecliente')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idctactecliente),array('view','id'=>$data->idctactecliente)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_idcliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_idcliente); ?>
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


</div>