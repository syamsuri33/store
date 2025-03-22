<?php 
	if(!empty(Yii::app()->user->role)){
		$role = Yii::app()->user->role;
	}else{
		$role = '';
	}
?>
<!DOCTYPE html>
<html>
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
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/important.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/edited.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mediascreen.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.datepick.css">

	<!--bootstrap-->
	<?php Yii::app()->bootstrap->register();  ?> 
	
	<!--qrcode scanner-->
	<script type="text/javascript" src="js/webcodecamjs.js"></script>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/qrcodelib.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/webcodecamjs.js'); ?>
	
	<!--datepicker multiple selection date-->
	<script type="text/javascript" src="js/jquery.plugin.min.js"></script>
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.plugin.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.datepick.js'); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<!--for page load show first img loading in  1.site/index(javascript) 2.css-->
<div id="load"></div>
<div id = "wallpaperindex">
	<div id="menuindex">
		<div id="logo">
			<div id="headlogo">
				<div class="g1"><a href="index.php"><img src="images/system/logo.png" width="50px" height="70px"></a></div>			
				<div class="t1"><?php echo "SEKSI PAIS KEMENTERIAN AGAMA KOTA BANDUNG";?></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="menutop">
			<div id="mainmenu">
				<?php $this->widget('bootstrap.widgets.TbNavbar', array(
						'color' => TbHtml::NAVBAR_COLOR_INVERSE,
						'brandLabel' =>  '',
						'collapse' => true,
						'items' => array(
							array(
								'class' => 'bootstrap.widgets.TbNav',
								'items' => array(
									//array('label'=>'Course / Coach Subject & Terms', 'url'=>array('/soalkategori/create'),'visible'=>Yii::app()->user->checkAccess('soalkategori.create')),
									array('label'=>'HOME', 'url'=>array('/site/index')),
									array('label'=>'DATA GURU', 'url'=>array('/guru/index')),
									array('label'=>'PENGUMUMAN', 'url'=>array('/pengumuman/index')),
									array('label'=>'STUKTUR ORGANISASI', 'url'=>array('/site/strukturOrganisasi')),
									array('label'=>'KUNJUNGAN', 'url'=>array('/kunjungan/createUser')),
									array('label'=>'KEGIATAN', 'url'=>array('/kegiatan/index')),
									array('label'=>'ADMIN', 'url'=>array('/site/admin'), 'visible'=> $role =='admin' or $role =='superuser'),
									//array('label'=>'POIN', 'url'=>array('/poin/index'), 'visible'=>!Yii::app()->user->isGuest),
									//array('label'=>'SOAL', 'url'=>array('/soal/index'), 'visible'=>!Yii::app()->user->isGuest and Yii::app()->user->table == 'user'),
									//array('label'=>'KETIDAKHADIRAN', 'url'=>array('/ketidakhadiran/index'), 'visible'=>!Yii::app()->user->isGuest and Yii::app()->user->table == 'lokasi'),
									//array('label'=>'LEMBUR', 'url'=>array('/ketidakhadiran/lembur'), 'visible'=>!Yii::app()->user->isGuest and Yii::app()->user->table == 'lokasi'),
									//array('label'=>'KEHADIRAN', 'url'=>array('/totalhadir/index'), 'visible'=>!Yii::app()->user->isGuest and Yii::app()->user->table == 'lokasi'),
									array('label'=>'LOGIN', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
									array('label' =>'LOGIN ('.Yii::app()->user->name.')','url'=>array('#'),'visible'=>!Yii::app()->user->isGuest,'items'=>array(
										array('label'=>'LOGOUT', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
									)),
								)
							),
						)
					));
				?>
			</div><!-- mainmenu -->
		</div><!-- menutop -->
	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	</div>
		
		<div class="boxtujuan">
		<div class="boxtujuanchild">
			<div id="textintrowallpaper">
				<?php echo "“Be the change that you wish to see in the world.” <p>";?>
				<?php echo "― Mahatma Gandhi ";?>
			</div>
		</div>
	</div>
</div>

<div class="container footerbottom" id="page">
	<?php echo $content; ?>

	<div class="clear"></div>
	<br></br>
	<div id="bgfooter">
		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by 7thCore.<br/>	
			All Rights Reserved.<br/>
		</div><!-- footer -->
	</div>

</div><!-- page -->

</body>
</html>