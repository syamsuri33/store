<?php
/* @var $this BarangController */
/* @var $model Barang */

$this->breadcrumbs=array(
	'Barangs'=>array('index'),
	$model->Barang_ID=>array('view','id'=>$model->Barang_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Barang', 'url'=>array('index')),
	array('label'=>'Create Barang', 'url'=>array('create')),
	array('label'=>'View Barang', 'url'=>array('view', 'id'=>$model->Barang_ID)),
	array('label'=>'Manage Barang', 'url'=>array('admin')),
);
?>

<h1>Update Barang <?php echo $model->Barang_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>