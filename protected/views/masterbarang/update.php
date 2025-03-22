<?php
/* @var $this MasterbarangController */
/* @var $model Masterbarang */

$this->breadcrumbs=array(
	'Masterbarangs'=>array('index'),
	$model->MasterBarang_ID=>array('view','id'=>$model->MasterBarang_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Masterbarang', 'url'=>array('index')),
	array('label'=>'Create Masterbarang', 'url'=>array('create')),
	array('label'=>'View Masterbarang', 'url'=>array('view', 'id'=>$model->MasterBarang_ID)),
	array('label'=>'Manage Masterbarang', 'url'=>array('admin')),
);
?>

<h1>Update Masterbarang <?php echo $model->MasterBarang_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'kategoriValue'=>$kategoriValue)); ?>