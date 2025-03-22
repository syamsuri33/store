<?php
/* @var $this OperasionalController */
/* @var $model Operasional */

$this->breadcrumbs=array(
	'Operasionals'=>array('index'),
	$model->Operasional_ID=>array('view','id'=>$model->Operasional_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Operasional', 'url'=>array('index')),
	array('label'=>'Create Operasional', 'url'=>array('create')),
	array('label'=>'View Operasional', 'url'=>array('view', 'id'=>$model->Operasional_ID)),
	array('label'=>'Manage Operasional', 'url'=>array('admin')),
);
?>

<h1>Update Operasional <?php echo $model->Operasional_ID; ?></h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'mOperasionalDtl'=>$mOperasionalDtl,
)); 
?>