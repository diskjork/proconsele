<?php
/* @var $this IvamovimientoController */
/* @var $data Ivamovimiento */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idivamovimiento')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idivamovimiento),array('view','id'=>$data->idivamovimiento)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipomoviento')); ?>:</b>
	<?php echo CHtml::encode($data->tipomoviento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrocomprobante')); ?>:</b>
	<?php echo CHtml::encode($data->nrocomprobante); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor_idproveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor_idproveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_idcliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_idcliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuitentidad')); ?>:</b>
	<?php echo CHtml::encode($data->cuitentidad); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tipofactura')); ?>:</b>
	<?php echo CHtml::encode($data->tipofactura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoiva')); ?>:</b>
	<?php echo CHtml::encode($data->tipoiva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeiibb')); ?>:</b>
	<?php echo CHtml::encode($data->importeiibb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeiva')); ?>:</b>
	<?php echo CHtml::encode($data->importeiva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeneto')); ?>:</b>
	<?php echo CHtml::encode($data->importeneto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('compra_idcompra')); ?>:</b>
	<?php echo CHtml::encode($data->compra_idcompra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factura_idfactura')); ?>:</b>
	<?php echo CHtml::encode($data->factura_idfactura); ?>
	<br />

	*/ ?>

</div>