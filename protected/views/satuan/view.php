<?php
/* @var $this SatuanController */
/* @var $model Satuan */

$this->breadcrumbs=array(
	'Satuans'=>array('index'),
	$model->Satuan_ID,
);

$this->menu=array(
	array('label'=>'List Satuan', 'url'=>array('index')),
	array('label'=>'Create Satuan', 'url'=>array('create')),
	array('label'=>'Update Satuan', 'url'=>array('update', 'id'=>$model->Satuan_ID)),
	array('label'=>'Delete Satuan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Satuan_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Satuan', 'url'=>array('admin')),
);
?>

<h1>View Satuan #<?php echo $model->Satuan_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Satuan_ID',
		'Satuan',
		'Jumlah',
		'Barang_ID',
		'Status',
	),
)); ?>
