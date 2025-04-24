<h1>Create Penjualan</h1>

<?php $id = null; ?>
<?php $this->renderPartial('_form', array(
	'model' => $model,
	'penjualanDetail' => $penjualanDetail,
	'id' => $id,
	//'details' => $details,
	'customerList' => $customerList,
	'barangList' => $barangList,
	//'satuanList' => $satuanList
)); ?>