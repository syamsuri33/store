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

<h1>Retur</h1>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">Search</h3>
	</div>
	<div class="card-body">
		<?php echo CHtml::form(Yii::app()->createUrl('retur/index'), 'get') ?>
		<div class="row">
			<div class="col-sm-6">
				<?php echo TbHtml::hiddenField('pageRetur', $pageRetur); ?>

				<?php echo TbHtml::dateField('Retur[startDate]', $model->startDate, array('class' => 'form-control'));?>
			</div>
			<div class="col-sm-6">
				<?php echo TbHtml::dateField('Retur[endDate]', $model->endDate, array('class' => 'form-control'));?>
			</div>
		</div>
		<button class="btn btn-primary btn-large" type="submit" name="yt0">Search</button>
		<?php echo CHtml::endForm() ?>
	</div>
</div>

<?php if ($pageRetur == "retur") {
	echo CHtml::link('add', array('create'), array('class' => 'btn btn-warning  btn-large mb-3'));
} else {
	echo CHtml::link('export', array('exportToExcel', 
		'startdate' => $model->startDate, 
		'enddate' => $model->endDate
	), array('class' => 'btn btn-warning  btn-large mb-3'));
}
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'apartemen-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		array(
			'name' => 'Retur_ID',
			'value' => '$data->Retur_ID',
		),
		array(
			'name' => 'Tanggal',
			'value' => 'Yii::app()->formatter->formatDate($data->Tanggal)',
		),
    array(
			'name' => 'TipeRetur',
			'value' => '$data->TipeRetur',
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
					'url' => 'Yii::app()->createUrl("retur/view", array("Retur_ID"=>$data->Retur_ID))', // Generate the URL
				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i>',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("penjualan/update", array("id"=>$data->Retur_ID))', // Generate the URL

				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i>',
					'options' => array('class' => 'btn btn-danger btn-sm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("penjualan/deletes", array("id"=>$data->Retur_ID))', // Generate the URL

				),
			),
			//'template' => '{updateCustom} {deleteCustom}',
			'template' => '{viewCustom}',

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
