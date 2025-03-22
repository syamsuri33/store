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

<?php if (Yii::app()->user->hasFlash('error')): ?>
	<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade', "
		setTimeout(function() { $('.flash-error').fadeOut('slow'); }, 4000);	
	");
?>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'mOperasionalDtl'=>$mOperasionalDtl,
)); 
?>