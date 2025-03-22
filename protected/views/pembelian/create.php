<?php
/* @var $this PembelianController */
/* @var $model Pembelian */

$this->breadcrumbs = array(
	'Pembelians' => array('index'),
	'Create',
);

$this->menu = array(
	array('label' => 'List Pembelian', 'url' => array('index')),
	array('label' => 'Manage Pembelian', 'url' => array('admin')),
);
?>

<h1>Create Pembelian</h1>

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
	'pembelianDetail' => $pembelianDetail,
	'id' => $id,
	//'details' => $details,
	'barangList' => $barangList,
	//'satuanList' => $satuanList
)); ?>