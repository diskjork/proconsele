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

	<b><?php echo CHtml::encode($data->getAttributeLabel('costoproduccion')); ?>:</b>
	<?php echo CHtml::encode($data->costoproduccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costomateriaprima')); ?>:</b>
	<?php echo CHtml::encode($data->costomateriaprima); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

</div>