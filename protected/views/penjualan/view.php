<?php
/* @var $this PenjualanController */
/* @var $model Penjualan */

$this->breadcrumbs=array(
	'Penjualans'=>array('index'),
	$model->Penjualan_ID,
);

$this->menu=array(
	array('label'=>'List Penjualan', 'url'=>array('index')),
	array('label'=>'Create Penjualan', 'url'=>array('create')),
	array('label'=>'Update Penjualan', 'url'=>array('update', 'id'=>$model->Penjualan_ID)),
	array('label'=>'Delete Penjualan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Penjualan_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Penjualan', 'url'=>array('admin')),
);
?>

<h1>View Penjualan #<?php echo $model->Penjualan_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Penjualan_ID',
		'Tanggal',
		'Created',
		'UserCreated_ID',
		'Updated',
		'UserUpdated_ID',
		'Total',
		'StatusAktif',
	),
)); ?>
