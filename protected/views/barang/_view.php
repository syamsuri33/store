<?php
/* @var $this BarangController */
/* @var $data Barang */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Barang_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Barang_ID), array('view', 'id'=>$data->Barang_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MasterBarang_ID')); ?>:</b>
	<?php echo CHtml::encode($data->MasterBarang_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('StatusPPN')); ?>:</b>
	<?php echo CHtml::encode($data->StatusPPN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Jumlah')); ?>:</b>
	<?php echo CHtml::encode($data->Jumlah); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Unit')); ?>:</b>
	<?php echo CHtml::encode($data->Unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Harga')); ?>:</b>
	<?php echo CHtml::encode($data->Harga); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Modal')); ?>:</b>
	<?php echo CHtml::encode($data->Modal); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('StatusAktif')); ?>:</b>
	<?php echo CHtml::encode($data->StatusAktif); ?>
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

	*/ ?>

</div>