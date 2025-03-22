<?php
/* @var $this VendorController */
/* @var $data Vendor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vendor_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Vendor_ID), array('view', 'id'=>$data->Vendor_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vendor')); ?>:</b>
	<?php echo CHtml::encode($data->Vendor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Alamat')); ?>:</b>
	<?php echo CHtml::encode($data->Alamat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('StatusAktif')); ?>:</b>
	<?php echo CHtml::encode($data->StatusAktif); ?>
	<br />


</div>