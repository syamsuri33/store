<h1>Operasionals</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade', "
		setTimeout(function() { $('.flash-success').fadeOut('slow'); }, 4000);	
	");
?>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">Search</h3>
	</div>
	<div class="card-body">
		<?php echo CHtml::form(Yii::app()->createUrl('operasional/index'), 'get') ?>
		<div class="row">
			<div class="col-sm-6">
				<?php echo TbHtml::hiddenField('pageOperasional', $pageOperasional); ?>

				<?php echo TbHtml::dateField('Operasional[startDate]', $model->startDate, array('class' => 'form-control')); ?>
			</div>
			<div class="col-sm-6">
				<?php echo TbHtml::dateField('Operasional[endDate]', $model->endDate, array('class' => 'form-control')); ?>
			</div>
		</div>

		<div class="mt-3">
			<button class="btn btn-primary btn-large" type="submit" name="yt0">Search</button>
		</div>
		<?php echo CHtml::endForm() ?>
	</div>
</div>

<?php if ($pageOperasional == "operasional") {
		echo CHtml::link('add', array('create'), array('class' => 'btn btn-warning  btn-large mb-3'));
	}else{
		echo CHtml::link('export', array('exportToExcel'), array('class' => 'btn btn-warning  btn-large mb-3'));
	}
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'apartemen-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		array(
			'name' => 'Tanggal',
			'value' => '$data->Tanggal',
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' => 'text-align:center', 'width' => '200px'),
			'buttons' => array(
				'viewCustom' => array(
					'label' => '<i class="fas fa-eye"></i> view',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'View'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("operasional/view", array("id"=>$data->Operasional_ID))', // Generate the URL

				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i>',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("operasional/update", array("id"=>$data->Operasional_ID))', // Generate the URL

				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i>',
					'options' => array('class' => 'btn btn-danger btn-sm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("operasional/deletes", array("id"=>$data->Operasional_ID))', // Generate the URL

				),
			),
			'template' => '{updateCustom} {deleteCustom}',

		),
	),
	'pager' => array(
		'class' => 'bootstrap.widgets.TbPager',
		'htmlOptions' => array('class' => 'pagination'), // Add custom class
	),
));
?>