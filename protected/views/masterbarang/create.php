<?php if (Yii::app()->user->hasFlash('error')): ?>
	<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade', "
		setTimeout(function() { $('.flash-error').fadeOut('slow'); }, 4000);	
	");
?>

<h1>Create Masterbarang</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'kategoriValue'=>$kategoriValue)); ?>