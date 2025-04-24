<?php
/* @var $this OperasionalController */
/* @var $model Operasional */

$this->breadcrumbs=array(
	'Operasionals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Operasional', 'url'=>array('index')),
	array('label'=>'Manage Operasional', 'url'=>array('admin')),
);
?>

<h1>Create Operasional</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'mOperasionalDtl'=>$mOperasionalDtl,
)); 
?>