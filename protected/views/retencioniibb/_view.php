<?php
/* @var $this RetencioniibbController */
/* @var $data Retencioniibb */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idretencionIIBB')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idretencionIIBB),array('view','id'=>$data->idretencionIIBB)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrocomprobante')); ?>:</b>
	<?php echo CHtml::encode($data->nrocomprobante); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_idcliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_idcliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comp_relacionado')); ?>:</b>
	<?php echo CHtml::encode($data->comp_relacionado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importe')); ?>:</b>
	<?php echo CHtml::encode($data->importe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tasa')); ?>:</b>
	<?php echo CHtml::encode($data->tasa); ?>
	<br />


</div>