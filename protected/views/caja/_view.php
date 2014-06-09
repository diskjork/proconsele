<?php
/* @var $this CajaController */
/* @var $data Caja */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idcaja')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcaja),array('view','id'=>$data->idcaja)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />


</div>