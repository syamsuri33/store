<?php
/* @var $this MasterbarangController */
/* @var $model Masterbarang */

$this->breadcrumbs=array(
	'Masterbarangs'=>array('index'),
	$model->MasterBarang_ID,
);

$this->menu=array(
	array('label'=>'List Masterbarang', 'url'=>array('index')),
	array('label'=>'Create Masterbarang', 'url'=>array('create')),
	array('label'=>'Update Masterbarang', 'url'=>array('update', 'id'=>$model->MasterBarang_ID)),
	array('label'=>'Delete Masterbarang', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->MasterBarang_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Masterbarang', 'url'=>array('admin')),
);
?>

<h1>View Masterbarang #<?php echo $model->MasterBarang_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'MasterBarang_ID',
		'Kode',
		'Nama',
		'Kategori',
		'Keterangan',
		'Harga',
		'Barcode',
		'MinStok',
		'StatusAktif',
	),
)); ?>
