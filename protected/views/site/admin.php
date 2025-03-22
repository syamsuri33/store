<?php 
	$iconShool 		= CHtml::image(Yii::app()->baseUrl.'/images/system/iconschool.png','',array('style'=>'width:50px; height:50px'));
	$iconTeacher 	= CHtml::image(Yii::app()->baseUrl.'/images/system/iconteacher.png','',array('style'=>'width:50px; height:50px'));
	$iconPengumuman = CHtml::image(Yii::app()->baseUrl.'/images/system/iconpengumuman.png','',array('style'=>'width:50px; height:50px'));
?>

<?php $this->widget('bootstrap.widgets.TbBreadcrumb',array('links'=>array(
		'Admin',
	//	'Home'=>array('/apartemen'),
	)));
?>

<h2 class="fontcolor1">Welcome, Admin</h2>

<style>
	.col-md-3 {
		width: 30%;
		float: left;
		position: relative;
		min-height: 1px;
		padding-right: 1%;
	}

	.info-box {
		display: block;
		min-height: 90px;
		background:
		#fff;
		width: 100%;
		box-shadow: 0 1px 1px
		rgba(0,0,0,0.1);
		border-radius: 2px;
		margin-bottom: 15px;
	}

	.bg-aqua{ background-color: #00c0ef !important; }
	.bg-red{ background-color: #dd4b39 !important; }
	.bg-green{ background-color: #00a65a !important; }
	.bg-yellow{ background-color: #f39c12 !important; }

	.info-box-icon {
		border-top-left-radius: 2px;
		border-top-right-radius: 0;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 2px;
		display: block;
		float: left;
		height: 90px;
		width: 90px;
		text-align: center;
		font-size: 45px;
		line-height: 90px;
		background: 
		rgba(0,0,0,0.2);
			background-color: rgba(0, 0, 0, 0.2);
	}
	.info-box-content {
		padding: 5px 10px;
		margin-left: 90px;
	}
	.info-box-text {
		text-transform: uppercase;
		display: block;
	font-size: 14px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	}
	.info-box-number {
		display: block;
		font-weight: bold;
		font-size: 18px;
	}
</style>
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"><?php echo $iconShool;?></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Sekolah</span>
				<span class="info-box-number"><?php echo count($mSekolah);?></span>
			</div>
		</div>
	</div> 
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="fa fa-google-plus"><?php echo $iconTeacher;?></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Guru</span>
				<span class="info-box-number"><?php echo count($mGuru);?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"><?php echo $iconPengumuman;?></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Pengumuman</span>
				<span class="info-box-number"><?php echo count($mPengumuman);?></span>
			</div>
		</div>
	</div>