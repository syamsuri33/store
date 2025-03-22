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
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/khusus.css">

	<!--bootstrap-->
	<?php Yii::app()->bootstrap->register();  ?> 
	
	<!--qrcode scanner-->
	<!--<script type="text/javascript" src="js/webcodecamjs.js"></script>-->
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/qrcodelib.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/webcodecamjs.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/filereader.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/main.js'); ?>
	
	<!--jsQR.js-->
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jsQR.js'); ?>
	
	<!--datepicker multiple selection date
	<script type="text/javascript" src="js/jquery.plugin.min.js"></script>
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.plugin.min.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.datepick.js'); ?>
	-->
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<!--for page load show first img loading in  1.site/index(javascript) 2.css-->
<div id="load"></div>

<div class="container footerbottom" id="page">
	<!--<?php /*
	<div id="logo">
		<div id="headlogo">
			<div class="g1"><a href="index.php"><img src="images/system/logo.png" width="50px" height="70px"></a></div>
			<div class="t1"><?php echo "SEKSI PAIS KEMENTERIAN AGAMA KOTA BANDUNG";?></div>
			<!--<div id="logo"></div>-->
		</div>
	</div>
	*/ ?>-->
	<?php if (isset($_GET['modul'])) {
		$active = $_GET['modul'];
	}else{
		$active = '';
	}
	?>
	<div id="menutop">
		<div id="mainmenu">
			<?php $this->widget('bootstrap.widgets.TbNavbar', array(
					'color' => TbHtml::NAVBAR_COLOR_INVERSE,
					'brandLabel' =>  Yii::app()->user->getState('Nama'),
					'collapse' => true,
					'items' => array(
						array(
							'class' => 'bootstrap.widgets.TbNav',
							'items' => array(
								//array('label'=>'Course / Coach Subject & Terms', 'url'=>array('/soalkategori/create'),'visible'=>Yii::app()->user->checkAccess('soalkategori.create')),Level
								array('label'=>'HOME', 'url'=>array('/site/index')),
								array('label'=>'PEMBELIAN', 	'url'=>array('/pembelian/index','modul'=>'PEMBELIAN'),'active'=>$active=='PEMBELIAN'?true:false, 		'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG PENERIMAAN'	and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								//array('label'=>'MUTASI PENERIMAAN','url'=>array('/mutasi/index','modul'=>'MutasiPenerimaan'),'active'=>$active=='MutasiPenerimaan'?true:false),
								array('label'=>'MUTASI PENERIMAAN', 	'url'=>array('/pembelian/mutasipenerimaan'),													'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG PENERIMAAN' 	and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								//array('label'=>'GUDANG BESAR', 	'url'=>array('/pembelian/index2','modul'=>'GUDANG BESAR'),'active'=>$active=='GUDANG BESAR'?true:false,	'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG BESAR' 		and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'GUDANG BESAR', 	'url'=>array('/pembelian/index2','modul'=>'GUDANG BESAR'),'active'=>$active=='GUDANG BESAR'?true:false,	'visible'=>(Yii::app()->user->getState('guBe') == 'yes' 					and Yii::app()->user->getState('checkerguBe') == 'yes') or Yii::app()->user->getState('Level') == 'ADMIN'),
								//array('label'=>'GUDANG KECIL', 	'url'=>array('/pembelian/index2','modul'=>'GUDANG KECIL'),'active'=>$active=='GUDANG KECIL'?true:false,	'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG KECIL' 		and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'GUDANG KECIL', 	'url'=>array('/pembelian/index2','modul'=>'GUDANG KECIL'),'active'=>$active=='GUDANG KECIL'?true:false,	'visible'=>(Yii::app()->user->getState('guKe') == 'yes' 					and Yii::app()->user->getState('checkerguKe') == 'yes') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'DIRECT BESAR',	'url'=>array('/pembelian/pindahrak','gudang'=>'GUDANG BESAR'), 'active'=>$active=='DIRECT BESAR'?true:false, 'visible'=>(Yii::app()->user->getState('guBe') == 'yes'				and Yii::app()->user->getState('checkerguBe') == 'yes') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'DIRECT KECIL',	'url'=>array('/pembelian/pindahrak','gudang'=>'GUDANG KECIL'), 'active'=>$active=='DIRECT KECIL'?true:false, 'visible'=>(Yii::app()->user->getState('guKe') == 'yes'				and Yii::app()->user->getState('checkerguKe') == 'yes') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'PINDAH RAK GUDANG BESAR',	'url'=>array('/pembelian/pindah','gudang'=>'GUDANG BESAR'), 'active'=>$active=='PINDAH BESAR'?true:false, 'visible'=>(Yii::app()->user->getState('guBe') == 'yes'		and Yii::app()->user->getState('checkerguBe') == 'yes') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'PINDAH RAK GUDANG KECIL',	'url'=>array('/pembelian/pindah','gudang'=>'GUDANG KECIL'), 'active'=>$active=='PINDAH KECIL'?true:false, 'visible'=>(Yii::app()->user->getState('guKe') == 'yes'		and Yii::app()->user->getState('checkerguKe') == 'yes') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'GUDANG TITIP', 	'url'=>array('/pembelian/index','modul'=>'GUDANG TITIP'),'active'=>$active=='GUDANG TITIP'?true:false,	'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG TITIP' 		and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'GUDANG RETUR', 	'url'=>array('/pembelian/index2','modul'=>'GUDANG RETUR'),'active'=>$active=='GUDANG RETUR'?true:false,	'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG RETUR' 		and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'REFUND BAGUS',	'url'=>array('/pembelian/index2','modul'=>'REFUND BAGUS'),'active'=>$active=='REFUND BAGUS'?true:false,	'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG REFUND' 		and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'REFUND RUSAK',	'url'=>array('/pembelian/index2','modul'=>'REFUND RUSAK'),'active'=>$active=='REFUND RUSAK'?true:false,	'visible'=>(Yii::app()->user->getState('jabatan') == 'GUDANG REFUND' 		and Yii::app()->user->getState('bagian') == 'CHECKER') or Yii::app()->user->getState('Level') == 'ADMIN'),
								array('label'=>'STOK OPNAME',	'url'=>array('/statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>'')),
								array('label'=>'MASALAH PICKING',	'url'=>array('/pembelian/masalahPicking')),
								array('label'=>'LOGIN', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label' =>'LOGIN ('.Yii::app()->user->getState('Nama').')','url'=>array('#'),'visible'=>!Yii::app()->user->isGuest,'items'=>array(
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
	<div class ="content";>
	<?php echo $content; ?>
	</div>
	<div class="clear"></div>
	<br></br>
	<div id="bgfooter">
		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by "O" Solution<br/>
			All Rights Reserved.<br/>
		</div><!-- footer -->
	</div>
</div><!-- page -->

<div id="myLoadingImage">
    <img src="<?php echo Yii::app()->baseUrl; ?>/images/load2.gif" class="imgLoading" alt="" />
</div>

</body>
</html>

<script>
	$(function(){
        // Check the initial Poistion of the Sticky Header
        var stickyHeaderTop = $('#menutop').offset().top;
 
        $(window).scroll(function(){
                if( $(window).scrollTop() > stickyHeaderTop ) {
                        $('#menutop').css({ position: 'fixed', top: '0px', width: '100%'});
						$('#menutop').css('z-index', 99);
                } else {
                        $('#menutop').css({position: 'static', top: '0px', width: '100%'});  
                }
        });
	});
	
	
</script>