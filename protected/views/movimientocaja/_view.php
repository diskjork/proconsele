<?php
/* @var $this MovimientocajaController */
/* @var $data Movimientocaja */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idmovimientocaja')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idmovimientocaja),array('view','id'=>$data->idmovimientocaja)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debe')); ?>:</b>
	<?php echo CHtml::encode($data->debe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('haber')); ?>:</b>
	<?php echo CHtml::encode($data->haber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numerooperacion')); ?>:</b>
	<?php echo CHtml::encode($data->numerooperacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('caja_idcaja')); ?>:</b>
	<?php echo CHtml::encode($data->caja_idcaja); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rubro_idrubro')); ?>:</b>
	<?php echo CHtml::encode($data->rubro_idrubro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formadepago_idformadepago')); ?>:</b>
	<?php echo CHtml::encode($data->formadepago_idformadepago); ?>
	<br />

	*/ ?>

</div>