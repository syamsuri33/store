<style>
	.modal{
		left: auto !important;
		right: auto !important;
		margin-left: auto !important;
		margin: auto !important;
		display: flex !important;
		-ms-flex-align: center !important;
		align-items: center !important;
	}
</style>

<h1>Operasionals</h1>

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
					'label' => '<i class="fas fa-eye"></i>',
					'options' => array(
						'class' => 'btn btn-warning btn-sm', 
						'title' => 'View',
						'onclick' => 'openModal(this); return false;',
					),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("operasional/getData", array("id"=>$data->Operasional_ID))', // Generate the URL

				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i>',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("operasional/update", array("id"=>$data->Operasional_ID))', // Generate the URL
					'visible' => '!isset($_GET["pageOperasional"]) || $_GET["pageOperasional"] != "report"',
				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i>',
					'options' => array('class' => 'btn btn-danger btn-sm delete-confirm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("operasional/deletes", array("id"=>$data->Operasional_ID))', // Generate the URL
					'visible' => '!isset($_GET["pageOperasional"]) || $_GET["pageOperasional"] != "report"',
				),
			),
			'template' => '{viewCustom} {updateCustom} {deleteCustom}',

		),
	),
	'pager' => array(
		'class' => 'bootstrap.widgets.TbPager',
		'htmlOptions' => array('class' => 'pagination'), // Add custom class
	),
));
?>

<!-- Modal -->
<div class="modal fade" id="dataModal" style="display: none; width:70% !important;" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="dataModalLabel">Detail</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body" id="dataContent">
		</div>
	</div>
</div>

<script>
	function openModal(button) {
		var url = $(button).attr('href');
		$('#dataContent').html('');

		$.ajax({
			url: url,
			type: 'GET',
			success: function(data) {
				$('#dataContent').html(data);
				$('#dataModal').modal('show');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.error("Error loading data: " + textStatus, errorThrown);
				$('#dataContent').html('<p>Error loading data.</p>');
			}
		});
	}
</script>