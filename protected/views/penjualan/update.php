<h1>Update Penjualan <?php echo $model->Penjualan_ID; ?></h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
	'penjualanDetail' => $penjualanDetail,
	'id' => $model->Penjualan_ID,
	'customerList' => $customerList,
	'barangList' => $barangList,
)); ?>