<?php
/* @var $this ReturController */
/* @var $model Retur */

$this->breadcrumbs=array(
	'Returs'=>array('index'),
	$model->Retur_ID=>array('view','id'=>$model->Retur_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Retur', 'url'=>array('index')),
	array('label'=>'Create Retur', 'url'=>array('create')),
	array('label'=>'View Retur', 'url'=>array('view', 'id'=>$model->Retur_ID)),
	array('label'=>'Manage Retur', 'url'=>array('admin')),
);
?>

<h1>Update Retur <?php echo $model->Retur_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>