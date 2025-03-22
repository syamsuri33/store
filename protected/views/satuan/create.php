<?php
/* @var $this SatuanController */
/* @var $model Satuan */

$this->breadcrumbs=array(
	'Satuans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Satuan', 'url'=>array('index')),
	array('label'=>'Manage Satuan', 'url'=>array('admin')),
);
?>

<h1>Create Satuan</h1>

<?php if (Yii::app()->user->hasFlash('error')): ?>
	<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade', "
		setTimeout(function() { $('.flash-error').fadeOut('slow'); }, 4000);	
	");
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>