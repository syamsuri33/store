<?php
/* @var $this PenjualanController */
/* @var $model Penjualan */

$this->breadcrumbs=array(
	'Penjualans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Penjualan', 'url'=>array('index')),
	array('label'=>'Manage Penjualan', 'url'=>array('admin')),
);
?>

<h1>Create Penjualan</h1>

<?php if (Yii::app()->user->hasFlash('error')): ?>
	<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade', "
		setTimeout(function() { $('.flash-error').fadeOut('slow'); }, 4000);	
	");
?>

<?php $id = null;?>
<?php $this->renderPartial('_form', array(
	'model' => $model,
	'penjualanDetail' => $penjualanDetail,
	'id' => $id,
	//'details' => $details,
	'barangList' => $barangList,
	//'satuanList' => $satuanList
)); ?>