<?php $this->pageTitle=Yii::app()->name . ' - Login';?>
<div class="pagelogin">
	<div class="form">
		<div class="panel-heading">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>
			<h1 class="fontcolor1">LOGIN</h1>
			<hr></hr>
			
			<div class="row">
				<?php //echo $form->labelEx($model,'username'); ?>
				<?php //echo $form->textField($model,'username',array('class'=>'forminputblock', 'autocomplete'=>"off")); ?>
				<?php //echo $form->error($model,'username'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model,'password',array('class'=>'forminputblock')); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>
			
			<div class="row buttons">
				<?php echo TbHtml::submitButton('LOGIN',array(
					'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'block'=>true,
					'class'=>'buttonblock'
				)); ?>
			</div>
			
			<div class="textsmallsignup">
				<?php //echo "<b>Lupa Password? ".CHtml::link("Kirim Email",array("site/forgotpassword"))."</b><p>";?>
				<?php //echo "<b>Daftar baru? ".CHtml::link("Daftar",array("site/register"))."</b>";?>
			</div>
			<?php $this->endWidget(); ?>
		</div><!-- panel-heading -->
	</div><!-- form -->
</div><!-- pagelogin -->
