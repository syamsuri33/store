<?php
/* @var $this BarangController */
/* @var $model Barang */

$this->breadcrumbs=array(
	'Barangs'=>array('index'),
	$model->Barang_ID,
);

$this->menu=array(
	array('label'=>'List Barang', 'url'=>array('index')),
	array('label'=>'Create Barang', 'url'=>array('create')),
	array('label'=>'Update Barang', 'url'=>array('update', 'id'=>$model->Barang_ID)),
	array('label'=>'Delete Barang', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Barang_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Barang', 'url'=>array('admin')),
);
?>

<h1>View Barang #<?php echo $model->Barang_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Barang_ID',
		'MasterBarang_ID',
		'StatusPPN',
		'Jumlah',
		'Unit',
		'Harga',
		'Modal',
		'StatusAktif',
		'Created',
		'UserCreated_ID',
		'Updated',
		'UserUpdated_ID',
	),
)); ?>
