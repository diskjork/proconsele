<?php
/* @var $this MovimientobancoController */
/* @var $data Movimientobanco */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idmovimientobanco')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idmovimientobanco),array('view','id'=>$data->idmovimientobanco)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('rubro_idrubro')); ?>:</b>
	<?php echo CHtml::encode($data->rubro_idrubro); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Banco_idBanco')); ?>:</b>
	<?php echo CHtml::encode($data->Banco_idBanco); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formadepago_idformadepago')); ?>:</b>
	<?php echo CHtml::encode($data->formadepago_idformadepago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_idcheque')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_idcheque); ?>
	<br />

	*/ ?>

</div>