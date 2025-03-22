<?php
/* @var $this SatuanController */
/* @var $model Satuan */

$this->breadcrumbs=array(
	'Satuans'=>array('index'),
	$model->Satuan_ID=>array('view','id'=>$model->Satuan_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Satuan', 'url'=>array('index')),
	array('label'=>'Create Satuan', 'url'=>array('create')),
	array('label'=>'View Satuan', 'url'=>array('view', 'id'=>$model->Satuan_ID)),
	array('label'=>'Manage Satuan', 'url'=>array('admin')),
);
?>

<h1>Update Satuan <?php echo $model->Satuan_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>