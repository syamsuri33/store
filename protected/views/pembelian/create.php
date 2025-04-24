<?php
/* @var $this PembelianController */
/* @var $model Pembelian */

$this->breadcrumbs = array(
	'Pembelians' => array('index'),
	'Create',
);

$this->menu = array(
	array('label' => 'List Pembelian', 'url' => array('index')),
	array('label' => 'Manage Pembelian', 'url' => array('admin')),
);
?>

<h1>Create Pembelian</h1>

<?php $id = null;?>
<?php $this->renderPartial('_form', array(
	'model' => $model,
	'pembelianDetail' => $pembelianDetail,
	'id' => $id,
	'barangList' => $barangList,
)); ?>