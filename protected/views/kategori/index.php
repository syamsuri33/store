<h1>Kategori</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade', "
		setTimeout(function() { $('.flash-success').fadeOut('slow'); }, 4000);	
	");
?>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">TREE</h3>
	</div>
	<div class="card-body">
		<?php
		function displayTree($categories)
		{
			echo '<ul>';
			foreach ($categories as $category) {
				echo '<li>';
				if(empty($category->Parent)){
					$level = "level1";
					echo CHtml::link($category->Kategori, '#', array(
						'onclick' => 'selectCategory("' . $category->Kategori_ID . '", "' . CHtml::encode($category->Kategori) . '")'
					));
				}else{
					$level = "level2";
					echo $category->Kategori;
				}
				

				if (!empty($category->children)) {
					echo '<span class="toggle-btn" onclick="toggleChildren(this)">[+]</span>';
					echo '<div class="children" style="display:none;">';
					displayTree($category->children);
					echo '</div>';
				}

				echo '</li>';
			}
			echo '</ul>';
		}
		displayTree($categoriesTree);
		?>
	</div>
</div>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">Import</h3>
	</div>
	<div class="card-body">
		<?php
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'upload-form',
			'enableAjaxValidation' => false,
			'action' => array('kategori/upload'),
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
		?>
		<label for="file">Upload Excel File:</label>
		<input type="file" name="file" id="file" class="form-control mb-2" />
		<?php echo TbHtml::submitButton('Upload', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			)); ?>
		
		<?php $this->endWidget(); ?>
	</div>
</div>

<h3>Tambah Kategori</h3>

<div class="form">
	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'customer-form',
		// Specify the action attribute to point to a different controller/action
		//'action' => Yii::app()->createUrl('kategori/create'),
		'enableAjaxValidation' => false,
	));
	?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Parent'); ?>
			<input type="text" id="parent_category" name="parent_category" class="form-control" readonly />
			<?php echo $form->hiddenField($model, 'Parent', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Parent'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Kode'); ?>
			<?php echo $form->textField($model, 'Kode', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Kode'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Kategori'); ?>
			<?php echo $form->textField($model, 'Kategori', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Kategori'); ?>
		</div>
		<div class="row buttons">
			<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			));
			?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div><!-- form -->

<script>
	// Fungsi untuk toggle expand/collapse anak kategori
	function toggleChildren(button) {
		var childrenDiv = button.nextElementSibling;
		if (childrenDiv.style.display === "none") {
			childrenDiv.style.display = "block";
			button.textContent = "[-]"; // Ubah tombol menjadi minus
		} else {
			childrenDiv.style.display = "none";
			button.textContent = "[+]"; // Ubah tombol menjadi plus
		}
	}

	// Fungsi untuk memilih kategori dan mengisi field parent
	function selectCategory(categoryId, categoryName) {
		document.getElementById('parent_category').value = categoryName;
		document.getElementById('Kategori_Parent').value = categoryId;
	}
</script>

<style>
	/* Styling untuk tombol expand/collapse */
	.toggle-btn {
		cursor: pointer;
		color: #0066cc;
		font-weight: bold;
		margin-left: 10px;
	}

	.toggle-btn:hover {
		text-decoration: underline;
	}

	.card-body ul {
		list-style-type: none;
	}

	.card-body ul li {
		margin: 5px 0;
	}

	.form-group {
		margin-bottom: 1rem;
	}
</style>