<?php
/* @var $this SatuanController */
/* @var $data Satuan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Satuan_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Satuan_ID), array('view', 'id'=>$data->Satuan_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Satuan')); ?>:</b>
	<?php echo CHtml::encode($data->Satuan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Jumlah')); ?>:</b>
	<?php echo CHtml::encode($data->Jumlah); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Barang_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Barang_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />


</div>