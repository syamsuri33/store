<?php
/* @var $this OperasionalController */
/* @var $model Operasional */

$this->breadcrumbs=array(
	'Operasionals'=>array('index'),
	$model->Operasional_ID,
);

$this->menu=array(
	array('label'=>'List Operasional', 'url'=>array('index')),
	array('label'=>'Create Operasional', 'url'=>array('create')),
	array('label'=>'Update Operasional', 'url'=>array('update', 'id'=>$model->Operasional_ID)),
	array('label'=>'Delete Operasional', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Operasional_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Operasional', 'url'=>array('admin')),
);
?>

<h1>View Operasional #<?php echo $model->Operasional_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Operasional_ID',
		'Tanggal',
	),
)); ?>
