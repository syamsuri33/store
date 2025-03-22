<h1>Satuan</h1>

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
		<?php echo CHtml::form(Yii::app()->createUrl('satuan/index'), 'get') ?>
		<div class="floatright">
			<div class="input-group input-group-sm">
				<?php echo TbHtml::textField('nama', '', array(
					'class' => 'form-control',
					'empty' => '',
					//'value'=>'xx',
					//'style' => 'width: 120px;',
					//'placeholder'=>'search',
					//'size' => TbHtml::INPUT_SIZE_SMALL,
				));
				?>
				<span class="input-group-append">
					<button class="btn btn-primary" type="submit" name="yt0">Search</button>
				</span>
			</div>
		</div>
		<?php echo CHtml::endForm() ?>
	</div>
</div>

<?php echo CHtml::link('add', array('create'), array('class' => 'btn btn-warning  btn-large mb-3')); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'apartemen-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		array(
			'name' => 'Master Barang',
			'value' => '$data->masterbarang->Nama',
			'type' => 'raw',
		),
		array(
			'name' => 'Satuan',
			'value' => '$data->Satuan',
		),
		array(
			'name' => 'Jumlah',
			'value' => '$data->Jumlah',
			'type' => 'raw',
		),
		array(
			'name' => 'HargaOffline',
			'value' => 'Helper::formatRupiah($data->HargaOffline)',
			'type' => 'raw',
		),
		array(
			'name' => 'HargaTokped',
			'value' => 'Helper::formatRupiah($data->HargaTokped)',
			'type' => 'raw',
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
					'url' => 'Yii::app()->createUrl("satuan/view", array("id"=>$data->Satuan_ID))', // Generate the URL

				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i>',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("satuan/update", array("id"=>$data->Satuan_ID))', // Generate the URL

				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i>',
					'options' => array('class' => 'btn btn-danger btn-sm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("satuan/deletes", array("id"=>$data->Satuan_ID))', // Generate the URL

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