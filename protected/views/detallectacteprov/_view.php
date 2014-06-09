<?php
/* @var $this DetallectacteprovController */
/* @var $data Detallectacteprov */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('iddetallectacteprov')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->iddetallectacteprov),array('view','id'=>$data->iddetallectacteprov)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddocumento')); ?>:</b>
	<?php echo CHtml::encode($data->iddocumento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debe')); ?>:</b>
	<?php echo CHtml::encode($data->debe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('haber')); ?>:</b>
	<?php echo CHtml::encode($data->haber); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ctacteprov_idctacteprov')); ?>:</b>
	<?php echo CHtml::encode($data->ctacteprov_idctacteprov); ?>
	<br />

	*/ ?>

</div>