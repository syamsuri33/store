<?php
/* @var $this PenjualanController */
/* @var $model Penjualan */

$this->breadcrumbs=array(
	'Penjualans'=>array('index'),
	$model->Penjualan_ID=>array('view','id'=>$model->Penjualan_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Penjualan', 'url'=>array('index')),
	array('label'=>'Create Penjualan', 'url'=>array('create')),
	array('label'=>'View Penjualan', 'url'=>array('view', 'id'=>$model->Penjualan_ID)),
	array('label'=>'Manage Penjualan', 'url'=>array('admin')),
);
?>

<h1>Update Penjualan <?php echo $model->Penjualan_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>