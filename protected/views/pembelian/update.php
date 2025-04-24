<?php
/* @var $this PembelianController */
/* @var $model Pembelian */

$this->breadcrumbs = array(
	'Pembelians' => array('index'),
	$model->Pembelian_ID => array('view', 'id' => $model->Pembelian_ID),
	'Update',
);

$this->menu = array(
	array('label' => 'List Pembelian', 'url' => array('index')),
	array('label' => 'Create Pembelian', 'url' => array('create')),
	array('label' => 'View Pembelian', 'url' => array('view', 'id' => $model->Pembelian_ID)),
	array('label' => 'Manage Pembelian', 'url' => array('admin')),
);
?>

<h1>Update Pembelian <?php echo $model->Pembelian_ID; ?></h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
	'pembelianDetail' => $pembelianDetail,
	'barangList' => $barangList,
)); ?>