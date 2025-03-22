<?php
/* @var $this VendorController */
/* @var $model Vendor */

$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	$model->Vendor_ID=>array('view','id'=>$model->Vendor_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vendor', 'url'=>array('index')),
	array('label'=>'Create Vendor', 'url'=>array('create')),
	array('label'=>'View Vendor', 'url'=>array('view', 'id'=>$model->Vendor_ID)),
	array('label'=>'Manage Vendor', 'url'=>array('admin')),
);
?>

<h1>Update Vendor <?php echo $model->Vendor_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>