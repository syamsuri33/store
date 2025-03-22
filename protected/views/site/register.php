<?php $this->pageTitle=Yii::app()->name . ' - Register';?>

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
			
			<h1 class="fontcolor1">REGISTER</h1>
			<?php //echo $form->errorSummary(array($mUser, $mGuru)); ?>
			
			<?php if(Yii::app()->user->hasFlash('error')):?>
				<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
			<?php endif; ?>
			
			<?php if(Yii::app()->user->hasFlash('success')):?>
				<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
			<?php endif; ?>
			
			<div class="row">
				<?php echo $form->labelEx($mUser,'email'); ?>
				<?php echo $form->textField($mUser,'email',array('class'=>'forminputblock')); ?>
				<?php echo $form->error($mUser,'email'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($mGuru,'nik'); ?>
				<?php echo $form->textField($mGuru,'nik',array('class'=>'forminputblock')); ?>
				<?php echo $form->error($mGuru,'nik'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($mGuru,'nama'); ?>
				<?php echo $form->textField($mGuru,'nama',array('class'=>'forminputblock')); ?>
				<?php //echo $form->error($mGuru,'nama'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($mUser,'password'); ?>
				<?php echo $form->passwordField($mUser,'password',array('class'=>'forminputblock')); ?>
				<?php echo $form->error($mUser,'password'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($mUser,'repassword'); ?>
				<?php echo $form->passwordField($mUser,'repassword',array('class'=>'forminputblock')); ?>
				<?php echo $form->error($mUser,'repassword'); ?>
			</div>
			
			<div class="row buttons">
				<?php echo TbHtml::submitButton('REGISTER',array(
					'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'block'=>true,
				)); ?>
			</div>
			
			<?php $this->endWidget(); ?>
		</div><!-- panel-heading -->
	</div><!-- form -->
</div><!-- pagelogin -->
