<?php
/* @var $this CobranzaController */
/* @var $data Cobranza */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idcobranza')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcobranza),array('view','id'=>$data->idcobranza)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcioncobranza')); ?>:</b>
	<?php echo CHtml::encode($data->descripcioncobranza); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importe')); ?>:</b>
	<?php echo CHtml::encode($data->importe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctactecliente_idctactecliente')); ?>:</b>
	<?php echo CHtml::encode($data->ctactecliente_idctactecliente); ?>
	<br />


</div>