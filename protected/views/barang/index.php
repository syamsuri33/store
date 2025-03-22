<h1>Barang</h1>
<?php
$this->breadcrumbs = array(
	'Barangs',
);

$this->menu = array(
	array('label' => 'Create Barang', 'url' => array('create')),
	array('label' => 'Manage Barang', 'url' => array('admin')),
);

echo CHtml::link('add', array('create'), array('class' => 'btn btn-warning  btn-large'));

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'apartemen-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		array(
			'name' => 'Jumlah',
			'value' => '$data->Jumlah',
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' => 'text-align:center'),
			'buttons' => array(
				'viewCustom' => array(
					'label' => '<i class="fas fa-eye"></i> view',
					'options' => array('class' => 'btn btn-info btn-sm', 'title' => 'View'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("masterbarang/view", array("id"=>$data->MasterBarang_ID))', // Generate the URL

				),
				'updateCustom' => array(
					'label' => '<i class="fas fa-edit"></i> update',
					'options' => array('class' => 'btn btn-warning btn-sm', 'title' => 'Update'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("masterbarang/update", array("id"=>$data->MasterBarang_ID))', // Generate the URL

				),
				'deleteCustom' => array(
					'label' => '<i class="fas fa-trash-alt"></i> delete',
					'options' => array('class' => 'btn btn-danger btn-sm', 'title' => 'Delete'),
					'imageUrl' => false, // Disable default image
					'encodeLabel' => false, // Ensure HTML is rendered correctly
					'url' => 'Yii::app()->createUrl("masterbarang/delete", array("id"=>$data->MasterBarang_ID))', // Generate the URL

				),
			),
			'template' => '{viewCustom} {updateCustom} {deleteCustom}',

		),
	),
));
?>