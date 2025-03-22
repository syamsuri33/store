<style>
.spanEdit {
  width: 150px !important;
  float: left !important;
}

</style>
<?php 
	$find = Userlokasi::model()->findByAttributes(array('User_ID'=>Yii::app()->user->id));
	$cekLevel = User::model()->findByAttributes(array('User_ID'=>Yii::app()->user->id));
	$result = '';

	/*if($cekLevel->Level != "ADMIN"){
	//if($cekLevel->Level == "ADMIN"){
		if(!empty($find)){
			$temp1   = explode(',',$find->Lokasi);
			$i = 0;	
			$result = '(';
			foreach($temp1 as $temp1){
				if($i > 0){$a = "or";}else{$a = " ";}
				//$result .= $a." INSTR(RAK, '".$temp1."') > 0 ";
				$result .= $a."( rak = '".$temp1."' OR INSTR(RAK, '".$temp1."-') = 1 ) ";
				$i++;
			}
			$result = $result.' or rak = " ") AND ';
			//$criteria->addCondition($result);
		}else{
			$result = '';
		}
	}*/
	
	
	/*$count = Jadwalstokopnamedetail::model()->findAllBySql("
			select * from jadwalstokopnamedetail ml
			where ".$result." Nama = '".$mJadwalstokopnameDTL->Nama."'
		");*/
	/*$count = Jadwalstokopnamedetail::model()->findAllByAttributes(array(
		'Nama'=>$mJadwalstokopnameDTL->Nama,
		'Rak'=>$mJadwalstokopnameDTL->Rak
		)
	);*/
	//echo $result.'xxx<p>'.var_dump($count);
	
	
	$count = Jadwalstokopnamedetail::model()->findAllBySql("
			SELECT Barang_id, SUM(Jumlah) Jumlah, SUM(Future) Future, Rak FROM ((
				SELECT Barang_ID, SUM(ml.Movement) jumlah, SUM(ml.Pesan) Future,  ml.Rak 
				FROM minoutline ml LEFT JOIN masterbarang ON ml.MasterBarang_ID = masterbarang.MasterBarang_ID 
				LEFT JOIN minout m ON ml.minout_id = m.minout_id 
				WHERE ml.MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."' 
				AND m.Gudang_ID = '".$mJadwalstokopnameDTL->jso->Gudang_id."'
				GROUP BY ml.Rak 
				HAVING SUM(ml.Movement) <> 0 
			)UNION(
				SELECT b.Barang_ID, SUM(ml.Movement) jumlah, SUM(ml.Pesan) Future,  ml.Rak
				FROM minoutline ml LEFT JOIN masterbarang ON ml.MasterBarang_ID = masterbarang.MasterBarang_ID 
				LEFT JOIN minout m ON ml.minout_id = m.minout_id 
				LEFT JOIN barang b ON ml.barang_id = b.barang_id AND b.barang_id != '' 
				WHERE ml.MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."' 
				AND m.Gudang_ID = '".$mJadwalstokopnameDTL->jso->Gudang_id."'
				GROUP BY ml.Rak 
				HAVING SUM(ml.Movement) = 0 LIMIT 2 
			)UNION(
				SELECT Barang_ID, 0 Jumlah, 0 Future, b.Rak  
				FROM barang b 
				LEFT JOIN masterbarang ON b.MasterBarang_ID = masterbarang.MasterBarang_ID 
				WHERE b.MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."' 
				AND b.Gudang_ID = '".$mJadwalstokopnameDTL->jso->Gudang_id."'
				GROUP BY b.Rak 
				HAVING SUM(jumlah) <> 0 
			)) 
			AS temp GROUP BY Rak ORDER BY jumlah DESC
			");
	//foreach($count as $count){		
		//echo $new->Jumlah.'<p>';
	//}
	
	if(empty($count)){
		$count = Jadwalstokopnamedetail::model()->findAllBySql("
			SELECT SUM(Jumlah) Jumlah, SUM(JumlahDraft + JumlahDatang) Future, Rak
			FROM barang
			WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."' 
			AND Gudang_ID = '".$mJadwalstokopnameDTL->jso->Gudang_id."'
			GROUP BY Rak
			ORDER BY Barang_ID DESC LIMIT 1 ;
		");
		
		//foreach($new2 as $new2){		
			//echo $new2->Jumlah.'<p>';
			//echo var_dump($new2).'<p>';
		//}
	}
?>

<?php $this->widget('bootstrap.widgets.TbBreadcrumb',array('links'=>array(
		'STOK OPNAME'=>array('statusopname/createTemp'),
		'EDIT',
	)));
?>
<p></p>

<?php if(Yii::app()->user->hasFlash('success')):?>
		<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade',"
		setTimeout(function() { $('.flash-success').fadeOut('slow'); }, 8000);	
	");
?>

<?php if(Yii::app()->user->hasFlash('error')):?>
		<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScript('fade',"
		setTimeout(function() { $('.flash-error').fadeOut('slow'); }, 8000);	
	");
?>

<div class="form">
	<div class='row-fluid'>
		<div class='span1'><?php echo 'Nama'; ?></div>
		<div class="span4"><?php echo $mJadwalstokopnameDTL->Nama; ?></div>
	</div>
	
	<?php if(count($count) == 1){ ?>
	<div class='row-fluid'>
		<div class='span1'><?php echo 'Rak'; ?></div>
		<div class="span4"><?php echo $mJadwalstokopnameDTL->Rak; ?></div>
	</div>
	<?php } ?>
	
<div class="well">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'audit-kebersihan-tangan-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	<?php 
	if(count($count) == 1){ ?>
		<?php echo $form->errorSummary($mJadwalstokopnameDTL); ?>
		
		<?php
			if(!empty( $_SESSION["jumlahONE"] )){
				$jml = $_SESSION["jumlahONE"];
			}else{
				$jml = $mJadwalstokopnameDTL->Jumlah;
			}
		?>
		
		<?php echo $form->labelEx($mJadwalstokopnameDTL,'Jumlah'); ?>
		<?php echo $form->textField($mJadwalstokopnameDTL,'Jumlah',array('class'=>'input-small', 'value'=>$jml)); ?>
		<?php echo $form->error($mJadwalstokopnameDTL,'Jumlah'); ?>
		
		<input type='hidden' name='jmlAsli' value ='<?php echo $mJadwalstokopnameDTL->Jumlah; ?>'>
		
		<!-- <?php /* DII HIDE DULU
		<div class='row-fluid'>
		<div class='span2 spanEdit'>
			<?php echo $form->labelEx($mJadwalstokopnameDTL,'JumlahBaru'); ?>
			<?php echo $form->textField($mJadwalstokopnameDTL,'JumlahBaru',array('class'=>'input-small')); ?>
			<?php echo $form->error($mJadwalstokopnameDTL,'JumlahBaru'); ?>
		</div>
		<div class='span2 spanEdit'>
			<?php echo $form->labelEx($mJadwalstokopnameDTL,'RakBaru'); ?>
			<?php echo $form->textField($mJadwalstokopnameDTL,'RakBaru',array('class'=>'input-small')); ?>
			<?php echo $form->error($mJadwalstokopnameDTL,'RakBaru'); ?>
		</div>
		</div>
		*/ ?> -->
		
		<div class="row buttons">
			<?php echo TbHtml::submitButton('cek', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'size'=>TbHtml::BUTTON_SIZE_LARGE,
				'name'=> 'cekOne',
				'id'=> 'cekOne'
				));
			?>
			
			<?php echo TbHtml::submitButton('reset', array(
				'color' => TbHtml::BUTTON_COLOR_WARNING,
				'size'=>TbHtml::BUTTON_SIZE_LARGE,
				'name'=> 'clearsessionOne',
				'id'=> 'clearsessionOne'
				));
			?>
		</div>
	<?php }else{ ?>
		<?php 
			
			$n = 0;
			$jml = 0;
			$jmlAsli = 0 ;
			foreach($count as $result){ ?>
			
			<?php 
				//${"variable$n"} = "foo";
				if(isset( $_SESSION["jumlah"][$n] )){
					$jml = $_SESSION["jumlah"][$n];
				}else{
					$jml = $result->Jumlah;
				}
				$jmlAsli += $result->Jumlah;
			?>
			
			<?php echo $form->hiddenField($mJadwalstokopnameDTL,'['.$n.']Jadwalstokopnamedetail_id',array('value'=>$mJadwalstokopnameDTL->Jadwalstokopnamedetail_ID)); ?>
			<?php echo $form->hiddenField($mJadwalstokopnameDTL,'['.$n.']Barang_id',array('value'=>$result->Barang_id)); ?>
			<div class='row-fluid'>
				<div class='span2 spanEdit'>
					<?php echo $form->labelEx($mJadwalstokopnameDTL,'['.$n.']Jumlah'); ?>
					<?php echo $form->textField($mJadwalstokopnameDTL,'['.$n.']Jumlah',array('value'=>$jml, 'class'=>'input-small')); ?>
					<?php echo $form->error($mJadwalstokopnameDTL,'Jumlah'); ?>
				</div>
				<div class='span2 spanEdit'>
					<?php echo $form->labelEx($mJadwalstokopnameDTL,'['.$n.']Rak'); ?>
					<?php echo $form->textField($mJadwalstokopnameDTL,'['.$n.']Rak',array('value'=>$result->Rak, 'class'=>'input-small', 'readonly'=>true)); ?>
					<?php echo $form->error($mJadwalstokopnameDTL,'Rak'); ?>
				</div>
			</div>
			<?php $n++; ?>
		<?php } ?>
			
			<input type='hidden' name='jmlAsli' value ='<?php echo $jmlAsli; ?>'>
			<!-- <?php /* DII HIDE DULU
			<div class='row-fluid'>
			<div class='span2 spanEdit'>
				<?php echo $form->labelEx($mJadwalstokopnameDTL,'JumlahBaru'); ?>
				<input class="input-small" name="JumlahBaru" id="JumlahBaru" type="text" maxlength="255">
			</div>
			<div class='span2 spanEdit'>
				<?php echo $form->labelEx($mJadwalstokopnameDTL,'RakBaru'); ?>
				<input class="input-small" name="RakBaru" id="RakBaru" type="text" maxlength="255">
				<?php echo $form->error($mJadwalstokopnameDTL,'RakBaru'); ?>
			</div>
			</div>
			*/ ?> -->
			
			<div class="row buttons">
				
				
				<?php echo TbHtml::submitButton('cek', array(
					'color' => TbHtml::BUTTON_COLOR_PRIMARY,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'name'=> 'cekMultiple',
					'id'=> 'cekMultiple'
					));
				?>
				
				<?php echo TbHtml::submitButton('reset', array(
					'color' => TbHtml::BUTTON_COLOR_WARNING,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'name'=> 'clearsession',
					'id'=> 'clearsession'
					));
				?>
			</div>
	<?php } ?>
	
	

	
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body">
	  <?php if(!empty( $_SESSION["selisih"] )){ 
	  $selisih = $_SESSION["selisih"];
	  }else{
		  $selisih = 0;
	  }?>
        Jumlah Selisih  = <?php echo $selisih ;?>
		<p>
		Lanjut ?
      </div>
	  
      <div class="modal-footer">
		<div class="row-fluid">
			<?php echo TbHtml::submitButton('cancel', array(
				'color' => TbHtml::BUTTON_COLOR_WARNING,
				'size'=>TbHtml::BUTTON_SIZE_LARGE,
				'name'=> 'cancel',
				'id'=> 'cancel',
			));
			?>
			
			<?php //ONE
			if(count($count) == 1){
				echo TbHtml::submitButton('Save', array(
					'color' => TbHtml::BUTTON_COLOR_PRIMARY,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'name'=> 'one'
				));
			}else{
				echo TbHtml::submitButton('Save', array(
					'color' => TbHtml::BUTTON_COLOR_PRIMARY,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'name'=> 'multiple',
					'id'=> 'multiple'
				));
			}
			?>
		</div>
      </div>
    </div>
  </div>
</div>

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('myScript', "
		$('#butSave').click(function(){
			$('#action').val('save');
		});
		
		$('#audit-kebersihan-tangan-form').submit(function() {
			$('#apartemen-form button[type=submit]').prop('disabled', true).val('Submitting...');
		}
		
		
	");
?>
<?php if(!empty( $_SESSION["modal"] )){ ?>
		<script>
			$(document).ready(function(){
				$("#exampleModal").modal('show');
			});
		</script>
<?php  } ?>