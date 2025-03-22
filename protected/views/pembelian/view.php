<?php
/* @var $this PembelianController */
/* @var $model Pembelian */

$this->breadcrumbs=array(
	'Pembelians'=>array('index'),
	$model->Pembelian_ID,
);

$this->menu=array(
	array('label'=>'List Pembelian', 'url'=>array('index')),
	array('label'=>'Create Pembelian', 'url'=>array('create')),
	array('label'=>'Update Pembelian', 'url'=>array('update', 'id'=>$model->Pembelian_ID)),
	array('label'=>'Delete Pembelian', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Pembelian_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pembelian', 'url'=>array('admin')),
);
?>

<h1>View Pembelian #<?php echo $model->Pembelian_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Pembelian_ID',
		'Tanggal',
		'Total',
		'Created',
		'UserCreated_ID',
		'Updated',
		'UserUpdated_ID',
	),
)); ?>
