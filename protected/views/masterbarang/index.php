<h1>Master Barang</h1>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">Search</h3>
	</div>
	<div class="card-body">
		<?php echo CHtml::form(Yii::app()->createUrl('masterbarang/index'), 'get') ?>
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

<?php

echo CHtml::link('add', array('create'), array('class' => 'btn btn-warning  btn-large mb-3'));

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'apartemen-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		array(
			'name' => 'Kode',
			'value' => '$data->Kode',
		),
		array(
			'name' => 'Nama',
			'value' => '$data->Nama',
			'type' => 'raw',
		),
		array(
			'name' => 'kategori.Kategori',
			'value' => '$data->kategori->Kategori',
			'type' => 'raw',
		),
		array(
			'name' => 'vendor.Vendor',
			'value' => 'isset($data->vendor->Vendor) ? $data->vendor->Vendor : "-"',
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
					'url' => 'Yii::app()->createUrl("masterbarang/view", array("id"=>$data->MasterBarang_ID))', // Generate the URL

				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i>',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("masterbarang/update", array("id"=>$data->MasterBarang_ID))', // Generate the URL

				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i>',
					'options' => array('class' => 'btn btn-danger btn-sm delete-confirm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("masterbarang/deletes", array("id"=>$data->MasterBarang_ID))', // Generate the URL

				),
			),
			'template' => '{updateCustom} {deleteCustom}',

		),
	),
	'pager' => array(
		'class' => 'bootstrap.widgets.TbPager',
		'htmlOptions' => array('class' => 'pagination'),
	),
));
?>