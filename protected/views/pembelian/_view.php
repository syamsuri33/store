<?php
/* @var $this PembelianController */
/* @var $data Pembelian */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Pembelian_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Pembelian_ID), array('view', 'id'=>$data->Pembelian_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tanggal')); ?>:</b>
	<?php echo CHtml::encode($data->Tanggal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Total')); ?>:</b>
	<?php echo CHtml::encode($data->Total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Created')); ?>:</b>
	<?php echo CHtml::encode($data->Created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UserCreated_ID')); ?>:</b>
	<?php echo CHtml::encode($data->UserCreated_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Updated')); ?>:</b>
	<?php echo CHtml::encode($data->Updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UserUpdated_ID')); ?>:</b>
	<?php echo CHtml::encode($data->UserUpdated_ID); ?>
	<br />


</div>