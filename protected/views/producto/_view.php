<?php
/* @var $this ProductoController */
/* @var $data Producto */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idproducto')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idproducto),array('view','id'=>$data->idproducto)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio')); ?>:</b>
	<?php echo CHtml::encode($data->precio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidad')); ?>:</b>
	<?php echo CHtml::encode($data->unidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidadventa')); ?>:</b>
	<?php echo CHtml::encode($data->cantidadventa); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cuenta_idcuenta')); ?>:</b>
	<?php echo CHtml::encode($data->cuenta_idcuenta); ?>
	<br />

	*/ ?>

</div>