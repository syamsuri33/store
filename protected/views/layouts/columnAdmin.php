<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>



<div style="width: 15%; float: left; padding-left:10px;">
	<div id="sidebar">	
	 <?php $this->widget('AdminWidget'); ?> 
	</div><!-- sidebar -->
</div>
<div style="width: 80%;float: left;">
	<div id="content"><?php echo $content; ?></div><!-- content -->
</div>

<?php $this->endContent(); ?>

