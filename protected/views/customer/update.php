<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->Customer_ID=>array('view','id'=>$model->Customer_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Create Customer', 'url'=>array('create')),
	array('label'=>'View Customer', 'url'=>array('view', 'id'=>$model->Customer_ID)),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);
?>

<h1>Update Customer <?php echo $model->Customer_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'id'=>$id)); ?>