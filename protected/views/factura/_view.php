<?php
/* @var $this FacturaController */
/* @var $data Factura */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idfactura')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idfactura),array('view','id'=>$data->idfactura)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrodefactura')); ?>:</b>
	<?php echo CHtml::encode($data->nrodefactura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipofactura')); ?>:</b>
	<?php echo CHtml::encode($data->tipofactura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nroremito')); ?>:</b>
	<?php echo CHtml::encode($data->nroremito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formadepago')); ?>:</b>
	<?php echo CHtml::encode($data->formadepago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_idcliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_idcliente); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descrecar')); ?>:</b>
	<?php echo CHtml::encode($data->descrecar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipodescrecar')); ?>:</b>
	<?php echo CHtml::encode($data->tipodescrecar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iva')); ?>:</b>
	<?php echo CHtml::encode($data->iva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('retencionIIBB')); ?>:</b>
	<?php echo CHtml::encode($data->retencionIIBB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('presupuesto')); ?>:</b>
	<?php echo CHtml::encode($data->presupuesto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nropresupuesto')); ?>:</b>
	<?php echo CHtml::encode($data->nropresupuesto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importebruto')); ?>:</b>
	<?php echo CHtml::encode($data->importebruto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ivatotal')); ?>:</b>
	<?php echo CHtml::encode($data->ivatotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidadproducto')); ?>:</b>
	<?php echo CHtml::encode($data->cantidadproducto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producto_idproducto')); ?>:</b>
	<?php echo CHtml::encode($data->producto_idproducto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreproducto')); ?>:</b>
	<?php echo CHtml::encode($data->nombreproducto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precioproducto')); ?>:</b>
	<?php echo CHtml::encode($data->precioproducto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stbruto_producto')); ?>:</b>
	<?php echo CHtml::encode($data->stbruto_producto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asiento_idasiento')); ?>:</b>
	<?php echo CHtml::encode($data->asiento_idasiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('impuestointerno')); ?>:</b>
	<?php echo CHtml::encode($data->impuestointerno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desc_imp_interno')); ?>:</b>
	<?php echo CHtml::encode($data->desc_imp_interno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeneto')); ?>:</b>
	<?php echo CHtml::encode($data->importeneto); ?>
	<br />

	*/ ?>

</div>