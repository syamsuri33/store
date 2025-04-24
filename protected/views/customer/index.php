<h1>Customer</h1>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">Search</h3>
	</div>
	<div class="card-body">
		<?php echo CHtml::form(Yii::app()->createUrl('customer/index'), 'get') ?>
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
			'name' => 'Nama',
			'value' => '$data->Nama',
		),
		array(
			'name' => 'Alamat',
			'value' => '$data->Alamat',
			'type' => 'raw',
		),
		array(
			'name' => 'Telepon',
			'value' => '$data->Telepon',
			'type' => 'raw',
		),
		array(
			'name' => 'type.Type',
			'value' => '$data->type->Type',
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
					'url' => 'Yii::app()->createUrl("customer/view", array("id"=>$data->Customer_ID))', // Generate the URL

				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i>',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("customer/update", array("id"=>$data->Customer_ID))', // Generate the URL

				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i>',
					'options' => array('class' => 'btn btn-danger btn-sm delete-confirm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("customer/deletes", array("id"=>$data->Customer_ID))', // Generate the URL

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