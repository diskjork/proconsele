<?php
/* @var $this NotadebitoprovController */
/* @var $data Notadebitoprov */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idnotadebitoprov')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idnotadebitoprov),array('view','id'=>$data->idnotadebitoprov)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nronotadebitoprov')); ?>:</b>
	<?php echo CHtml::encode($data->nronotadebitoprov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor_idproveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor_idproveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iva')); ?>:</b>
	<?php echo CHtml::encode($data->iva); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('percepcionIIBB')); ?>:</b>
	<?php echo CHtml::encode($data->percepcionIIBB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importebruto')); ?>:</b>
	<?php echo CHtml::encode($data->importebruto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ivatotal')); ?>:</b>
	<?php echo CHtml::encode($data->ivatotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeneto')); ?>:</b>
	<?php echo CHtml::encode($data->importeneto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeIIBB')); ?>:</b>
	<?php echo CHtml::encode($data->importeIIBB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asiento_idasiento')); ?>:</b>
	<?php echo CHtml::encode($data->asiento_idasiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuenta_idcuenta')); ?>:</b>
	<?php echo CHtml::encode($data->cuenta_idcuenta); ?>
	<br />

	*/ ?>

</div>