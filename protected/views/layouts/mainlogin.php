<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html class="htmllogin">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/system/logo.png">
	
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mediascreen.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/important.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/edited.css">

	<!--bootstrap-->
	<?php 
		Yii::app()->bootstrap->register();  
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false; 
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['yiistrap.css'] = false;
	?> 
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="center">
		<?php echo $content; ?>
	</div>
	
	<div id="bgfooterlogin">
		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by seven<br/>	
			All Rights Reserved.<br/>
		</div><!-- footer -->
	</div>

</body>
</html>

