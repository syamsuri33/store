<style>
#myModal{
	display:none;
}
.modal-content{
	width:100%;
}
</style>

<?php
$resultNama0 = '';
$resultKode0 = '';
$resultKodeGenuine0 = '';
$MasterBarang_ID0 = '';
$error = '';
if (isset($_GET['Masterbarang']['MasterBarang_ID'])) {
	$MasterBarang_IDFromUrl = $_GET['Masterbarang']['MasterBarang_ID'];
}else{
	$MasterBarang_IDFromUrl = '';
}

if (isset($_GET['Stokopnametemp']['Gudang_ID'])) {
	$gdng_ID = $_GET['Stokopnametemp']['Gudang_ID'];
}else{
	$gdng_ID = '';
}

if (isset($_GET['Masterbarang']['MasterBarang_ID'])) {
	if(empty($gdng_ID)){
		$error = '<div class="flash-error">Gudang tidak boleh kosong</div>';
	}else{
		$aa= '10000AJJ,2C10000004';
		//$pecahMB_ID = explode(',', $_GET['Masterbarang']['MasterBarang_ID']);
		$pecahMB_ID = explode(',', $aa);
		$i = 0;
		foreach($pecahMB_ID as $pecahMB_ID){
			$find=Masterbarang::model()->findByPk($pecahMB_ID);
			${"resultNama".$i} 			= $find->Nama;
			${"resultKode".$i} 			= $find->Kode;
			${"resultKodeGenuine".$i} 	= $find->KodeGenuine;
			${"MasterBarang_ID".$i} 	= $find->MasterBarang_ID.',';
			
			
			$i++;
		}
		
		//echo 'xxx'.$resultNama0.'xxx';
		$find=Masterbarang::model()->findByPk($_GET['Masterbarang']['MasterBarang_ID']);
		$resultNama0 = $find->Nama;
		$resultKode0 = $find->Kode;
		$resultKodeGenuine0 = $find->KodeGenuine;
		$MasterBarang_ID0 = $find->MasterBarang_ID.',';
		
		//model = Barang::model()->find('userid=1 AND status="A"');

		$findBrg = Barang::model()->findByAttributes(array(
				'Nama'=>	$find->Nama,
				'Kode'=>	$find->Kode,
				'Gudang_ID'=>$gdng_ID,
				'StatusRusak'=>0,
			),'(Jumlah <> JumlahDraft OR JumlahDatang <> 0)'
		);
		if($findBrg){
			$error = '<div class="flash-error">Barang masih ada yang di proses.</div>';
			$resultNama = '';
			$resultKode = '';
			$resultKodeGenuine = '';
			$MasterBarang_ID = '';
		}else{
			
		}
	}
}	
	$inputBrg = Barang::model()->findAllBySql("
		select sum(barang.jumlah) Jumlah, Rak
		from barang left join masterbarang on barang.masterbarang_id = masterbarang.masterbarang_id 
		where barang.nama = '".$find->Nama."'
		and barang.kode = '".$find->Kode."'
		and barang.kodegenuine = '".$find->KodeGenuine."'
		and barang.gudang_id = '".$gdng_ID."'
		group by rak
		order by sum(barang.jumlah) DESC LIMIT 10
	");

?>
<?php $this->widget('bootstrap.widgets.TbBreadcrumb',array('links'=>array(
		'STATUS OPNAME',
	)));
?>

<h2><?php echo 'STATUS OPNAME';?></h2>
<?php echo $error; ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'uc-audit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<?php echo CHtml::beginForm(array('statusopname/createTemp'), 'get'); ?>
<div class='well'>
<div class='row-fluid'>
	<div class='span2'>
		<?php echo $form->labelEx($mStokopnametemp,'Tanggal'); ?>
	</div>
	<div class='span4'>
		<?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker',array(
				'model'=>$mStokopnametemp,
				'id'=>'Stokopnametemp_Tanggal',
				'name' => 'Stokopnametemp[Tanggal]',
				'format' => 'yyyy-MM-dd hh:mm:ss',
				'value'=>$mStokopnametemp->Tanggal,
				'htmlOptions' => array(
					'class' => 'input-large',
					'readonly'=>true,
				),
			));
		?>
		<?php echo $form->error($mStokopnametemp,'Tanggal'); ?>
	</div>
</div>

<div class='row-fluid'>
	<div class='span2'>
		<?php echo $form->labelEx($mStokopnametemp,'Gudang_ID'); ?>
	</div>
	<div class='span4'>
		<?php echo $form->dropDownList($mStokopnametemp,'Gudang_ID',
				CustomAll::model()->getGudangValue(),array(
				'class' => 'input-large',
				'empty' => '',
				'options' => array($mStokopnametemp->Gudang_ID=>array('selected'=>true)),
				//'style' => 'width: 120px;',
				//'placeholder'=>'search',
				//'size' => TbHtml::INPUT_SIZE_SMALL,
			));
		//$form->dropDownList($model, attribute, array(), array('onChange'=>'window.location=http://www.google.com'))	
		?>
	</div>
</div>
<button formmethod='GET' name='foo' type='submit'>set</button>
</div>

<div class='well'>
<div class='row-fluid'>
	<div class='span2'>
		<?php echo $form->labelEx($mMasterBarang,'Nama'); ?>
	</div>
	<div class='span4'>
		<div class="input-append">
			<?php echo $form->hiddenField($mMasterBarang,'MasterBarang_ID',array('value'=>$mMasterBarang->MasterBarang_ID)); ?>
			<?php echo $form->textField($mMasterBarang,'Nama',array('value'=>$resultNama0, 'readonly'=>true)); ?>
			<?php echo CHtml::link('...','',array(
								'data-toggle'=>'modal',
								'data-target'=>'#myModal',
								'class'=>'btn',
							));
						?>
			<?php echo $form->error($mMasterBarang,'MasterBarang_ID'); ?>
		</div>
	</div>
</div>

<div class='row-fluid'>
	<div class='span2'>
		<?php echo $form->labelEx($mMasterBarang,'Kode'); ?>
	</div>
	<div class='span4'>
		<?php echo $form->textField($mMasterBarang,'Kode',array('value'=>$resultKode0, 'readonly'=>true)); ?>
	</div>	
</div>

<div class='row-fluid'>
	<div class='span2'>
		<?php echo $form->labelEx($mMasterBarang,'KodeGenuine'); ?>
	</div>
	<div class='span4'>
		<?php echo $form->textField($mMasterBarang,'KodeGenuine',array('value'=>$resultKodeGenuine0, 'readonly'=>true)); ?>
	</div>		
</div>
<?php 
	echo '<table><tr><th>Rak</th><th>Jumlah</th></tr>';
	foreach ($inputBrg as $result){
		echo '<tr><td>'.$result->Rak.'</td>';
		echo '<td>'.$result->Jumlah.'</td></tr>';
	}
	echo '</table';
?>

<div class="row buttons">
	<?php echo CHtml::link('+','',array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
			'class'=>'btn',
		));
	?>
	
	<?php echo TbHtml::submitButton($mStokopnametemp->isNewRecord ? 'Create' : 'Save', array(
		'color' => TbHtml::BUTTON_COLOR_PRIMARY
		));
	?>
</div>

<?php $this->endWidget(); ?>

<!-----MODAL--->
<?php // add the (closed) dialog for the iframe
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'cru-dialog',
		'options'=>array(
			'title'=>'List',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>'80%',
			'height'=>300,
			'z-index'=>9999,
			'show'=>array(
				'effect'=>'blind',
			),			
		),
    ));
?>

<iframe id="cru-frame" width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<div id="myModal" class="modal fade bs-example-modal-sm">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">   
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Click Capture and Save</h4>
			</div>
			<div class="modal-body"> 
				<div class="form-group">
					<div class="col-md-12">
					<h4></h4>
					<?php $this->renderPartial('modalMasterBarang',array('mMasterBarang'=>$mMasterBarang, 'Tanggal'=>$mStokopnametemp->Tanggal, 'Gudang_ID'=>$mStokopnametemp->Gudang_ID, 'MasterBarang_ID'=>$MasterBarang_IDFromUrl));?>
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<div class="footerleft">
				</div>
				<?php echo TbHtml::submitButton('CLOSE',array(
						'color'=>TbHtml::BUTTON_COLOR_DEFAULT,
						'size'=>TbHtml::BUTTON_SIZE_LARGE,
						'data-dismiss'=>'modal',
					));
				?>
			</div>
		</div>
	</div>
</div>