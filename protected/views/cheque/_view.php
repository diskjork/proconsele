<?php
/* @var $this ChequeController */
/* @var $data Cheque */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idcheque')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcheque),array('view','id'=>$data->idcheque)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrocheque')); ?>:</b>
	<?php echo CHtml::encode($data->nrocheque); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('titular')); ?>:</b>
	<?php echo CHtml::encode($data->titular); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('cuittitular')); ?>:</b>
	<?php echo CHtml::encode($data->cuittitular); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaingreso')); ?>:</b>
	<?php echo CHtml::encode($data->fechaingreso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechacobro')); ?>:</b>
	<?php echo CHtml::encode($data->fechacobro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debe')); ?>:</b>
	<?php echo CHtml::encode($data->debe); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('haber')); ?>:</b>
	<?php echo CHtml::encode($data->haber); ?>
	<br />
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('debeohaber')); ?>:</b>
	<?php echo CHtml::encode($data->debeohaber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Banco_idBanco')); ?>:</b>
	<?php echo CHtml::encode($data->Banco_idBanco); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor_idproveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor_idproveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_idcliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_idcliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	*/ ?>

</div>