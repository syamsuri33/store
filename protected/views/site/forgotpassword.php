<?php $this->pageTitle=Yii::app()->name . ' - Forgot Password';?>

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
			<h2 class="fontcolor1">Forgot Password</h2>
			<?php if(Yii::app()->user->hasFlash('success')):?>
				<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
			<?php endif; ?>
			
			<?php if(Yii::app()->user->hasFlash('error')):?>
				<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
			<?php endif; ?>
			
			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('class'=>'forminputblock')); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
			
			<div class="row buttons">
				<?php echo TbHtml::submitButton('Send Email',array(
					'color'=>TbHtml::BUTTON_COLOR_INFO,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'block'=>true,
				)); ?>
			</div>
			<?php $this->endWidget(); ?>
		</div><!-- panel-heading -->
	</div><!-- form -->
</div><!-- pagelogin -->
