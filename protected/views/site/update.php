<p>
<?php $this->widget('bootstrap.widgets.TbBreadcrumb',array('links'=>array(
		'Home'=>array('/site/index'),
		'Update ',
	)));
?>

<?php $this->renderPartial('_form', array('mInput'=>$mInput, 'mBarang'=>$mBarang, )); ?>