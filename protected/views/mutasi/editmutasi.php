<?php 
	$gudang_id = '';
	
	if (isset($_GET['modul'])) {
		if($_GET['Gudang_ID']=="1-001"){
			$gudang_id = '1-001';
			$title = "Ke Gdg Besar";
		}else if($_GET['Gudang_ID']=="1-002"){
			$gudang_id = '1-002';
			$title = "Ke Gdg Kecil";
		}
	}
?>

<style>
.txtkcl{
	font-size:10px;
	color:red;
	text-align:right;
}
</style>

<div class="form">
	<?php if(Yii::app()->user->hasFlash('error')):?>
		<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
	<?php endif; ?>
	<?php Yii::app()->clientScript->registerScript('fade',"
			setTimeout(function() { $('.flash-error').fadeOut('slow'); }, 8000);	
		");
	?>
	
	<?php 
		$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'apartemen-form',
		'enableAjaxValidation'=>false,	
	));
	?>
	
	<div class ="well">
	<?php echo CHtml::hiddenField('modul',$modul,array('size'=>10,'maxlength'=>8));?>	
	<?php echo CHtml::hiddenField('gudang_id',$gudang_id,array('size'=>10,'maxlength'=>8));?>
	
	<?php if($gudang_id == '1-001'){ ?>
		<?php echo ' <b>Ke Gudang Besar</b><hr></hr>'; ?>
		<div class='row-fluid'>
			<div class='span2'><?php echo 'Jumlah'; ?></div>
			<div class='span2'><?php echo $form->textField($mMutasitemp,'GudangBesar',array('class'=>'input-large','maxlength'=>64, 'autocomplete'=>"off")); ?></div>
		</div>
	<?php }else{ ?>
		<?php echo ' <b>Ke Gudang Kecil</b><hr></hr>'; ?>
		<div class='row-fluid'>
			<div class='span2'><?php echo 'Jumlah'; ?></div>
			<div class='span2'><?php echo $form->textField($mMutasitemp,'GudangKecil',array('class'=>'input-large','maxlength'=>64, 'autocomplete'=>"off")); ?></div>
		</div>
	<?php } ?>
	
		<div class='row-fluid'>
			<div class='span2'></div>
			<div class='span2 txtkcl'>Jumlah Terima: <?php echo $mMinoutline->Movement;?></div>
		</div>
		
		<div class='row-fluid'>
			<div class='span2'></div>
			<div class='span4'>
				<?php echo TbHtml::submitButton('Save',array(
					'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'name'=> 'save'
				)); ?>
			</div>
		</div>
	</div>
	
	<?php $this->endWidget(); ?>

</div><!-- form -->