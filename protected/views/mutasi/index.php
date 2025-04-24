<?php if (isset($_GET['modul'])) {
		if($_GET['modul']=="GUDANG BESAR"){
			$title = "MUTASI ".$_GET['modul'];
			$ModulParam1 = "MUTASI MASUK";
			$ModulParam2 = "1-001";
		}else{
			$title = $_GET['modul'];
			$ModulParam1 = "PEMBELIAN";
			$ModulParam2 = "";
		}
		$MODUL = $_GET['modul'];
	}else{
		$MODUL = "";
		$title = "";
	}
	
	if (isset($_GET['Minoutline']['namaBarang'])) {
		$brg = $_GET['Minoutline']['namaBarang'];
	}else{
		$brg = '';
	}
	
	if (isset($_GET['Minoutline']['namaSupplier'])) {
		$supp = $_GET['Minoutline']['namaSupplier'];
	}else{
		$supp = '';
	}
?>

<style>
#MINOUTLine_ID_all, #MINOUTLine_ID_Retur_all {
    display: none;
}
</style>

<?php $this->widget('bootstrap.widgets.TbBreadcrumb',array('links'=>array(
		$MODUL,
	)));
?>

<p>

<h2><?php echo $title;?></h2>
<p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="floatright">
		<input name="modul" 	id="modul" 		value="<?php echo $modul;?>"		type="hidden">
		Nama Barang
		<?php echo $form->textField($mMinoutline,'namaBarang',array('class'=>'span2')); ?>
	</div>
	<div class="floatright">
		Nama Supplier
		<?php echo $form->textField($mMinoutline,'namaSupplier',array('class'=>'span2')); ?>		
	</div>
	<button class="btn" type="submit" name="yt0">Search</button>
<?php $this->endWidget();?>	

<div class="clear"></div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'penjualan-form',
	'action'=>array('mutasi/save'),
	'enableAjaxValidation'=>false,
)); 
?>

<?php echo CHtml::hiddenField('modul',$modul,array('size'=>10,'maxlength'=>8));?>

<!-- <?php /*
<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'apartemen-grid',
			'dataProvider'=>$mMinoutline->searchByStatus($ModulParam1, $ModulParam2, 1),
			//'filter'=>$mMinoutline,
			'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
			'columns'=>array(
				array(
					'name' => 'MINOUTLine_ID',
					'id' => 'MINOUTLine_ID',
					'header'=>'Pembelian ID',
					'value' => '$data->MINOUTLine_ID',
					'class' => 'CCheckBoxColumn',
					'selectableRows' => '2',
					//'checked' => function($data){ return ($data->MINOUTLine_ID == 1) ? false:true;},
					'checked' => function($data){ return true;},
					//'htmlOptions'=>array('width'=>'8%','style'=>'text-align:center'),
				),
				array(
					'name'=>'Pembelian_ID',
					'header'=>'Pembelian ID',
					'value' => '$data->Pembelian_ID',
					'type' => 'raw',
					//'visible'=>$ModulParam1 == "PEMBELIAN",
				),
				array(
					'name'=>'AlasanSelisih',
					'header'=>'Supplier',
					'value' => '$data->minout->supplier->Nama',
					'type' => 'raw',
				),
				array(
					'name'=>'AlasanSelisih',
					'header'=>'Tanggal',
					'value' => '$data->minout->Tanggal',
					'type' => 'raw',
					//'filter' => true,
					//'visible'=>$ModulParam1 == "REFUND BAGUS" or $ModulParam1 == "REFUND RUSAK",
				),
				array(
					'name'=>'AlasanSelisih',
					'header'=>'Barang',
					'value' => '$data->masterbarang->Nama',
					'type' => 'raw',
				),
				array(
					'name'=>'Movement',
					'header'=>'Jumlah Terima',
					'value' => '$data->Movement',
					'type' => 'raw',
				),
				array(
					'name'=>'Movement',
					'header'=>'Stok Gdg Kecil',
					'value' => 'Minoutline::getStok($data->barang->Nama, "1-002")',
					'type' => 'raw',
				),
				array(
					'name'=>'Movement',
					'header'=>'Stok Gdg Besar',
					'value' => 'Minoutline::getStok($data->barang->Nama , "1-001")',
					'type' => 'raw',
				),
				array(
					'name'=>'Movement',
					'header'=>'Ke Gdg Kecil',
					'value' => 'Minoutline::getConversi($data->barang->Nama, $data->MasterBarang_ID, $data->Movement, "GudangKecil")',
					'type' => 'raw',
				),
				array(
					'name'=>'Movement',
					'header'=>'Ke Gdg Besar',
					'value' => 'Minoutline::getConversi($data->barang->Nama, $data->MasterBarang_ID, $data->Movement, "GudangBesar")',
					'type' => 'raw',
				),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'htmlOptions'=>array('style'=>'text-align:center','width'=>'5%'),
					'buttons'=>array(
						'view'=>array('visible'=>"Yii::app()->user->checkAccess('apartemen.view')"),
						'update'=>array('visible'=>"Yii::app()->user->checkAccess('apartemen.update')"),
						'delete'=>array('visible'=>"Yii::app()->user->checkAccess('apartemen.delete')"),
						)					
				),
			),
		));
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'apartemen-grid',
			'dataProvider'=>$mMinoutline->searchByStatus($ModulParam1, $ModulParam2, 2),
			//'filter'=>$mMinoutline,
			'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
			'selectableRows' => '2',
			'columns'=>array(
				array(
					'name' => 'MINOUTLine_IDs',
					'header'=>'Pembelian ID',
					'id' => 'MINOUTLine_ID_Retur',
					'value' => '$data->MINOUTLine_ID',
					'class' => 'CCheckBoxColumn',
					'selectableRows' => '2',
					//'checked' => function($data){ return ($data->MINOUTLine_ID == 1) ? false:true;},
					'checked' => function($data){ return true;},
					'htmlOptions'=>array('width'=>'8%','style'=>'text-align:center'),
				),
				array(
					'name'=>'Pembelian_ID',
					'header'=>'Pembelian ID',
					'value' => '$data->Pembelian_ID',
					'type' => 'raw',
					//'visible'=>$ModulParam1 == "PEMBELIAN",
				),
				array(
					'name'=>'AlasanSelisih',
					'header'=>'Supplier',
					'value' => '$data->minout->supplier->Nama',
					'type' => 'raw',
				),
				array(
					'name'=>'AlasanSelisih',
					'header'=>'Tanggal',
					'value' => '$data->minout->Tanggal',
					'type' => 'raw',
					//'filter' => true,
					//'visible'=>$ModulParam1 == "REFUND BAGUS" or $ModulParam1 == "REFUND RUSAK",
				),
				array(
					'name'=>'AlasanSelisih',
					'header'=>'Barang',
					'value' => '$data->masterbarang->Nama',
					'type' => 'raw',
				),
				array(
					'name'=>'Selisih',
					'header'=>'Jumlah Retur',
					'value' => '$data->Selisih',
					'type' => 'raw',
				),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'htmlOptions'=>array('style'=>'text-align:center','width'=>'5%'),
					'buttons'=>array(
						'view'=>array('visible'=>"Yii::app()->user->checkAccess('apartemen.view')"),
						'update'=>array('visible'=>"Yii::app()->user->checkAccess('apartemen.update')"),
						'delete'=>array('visible'=>"Yii::app()->user->checkAccess('apartemen.delete')"),
						)					
				),
			),
		));
?>

<div class="titleright">
 <?php echo TbHtml::submitButton('Save',array(
	'name'=>'ButtCreate',
	'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
	'size'=>TbHtml::BUTTON_SIZE_LARGE,
)); ?>
</div>
<?php $this->endWidget(); ?>

<div class="clear"></div>
</br></br>

*/?>-->

<?php 
/*$comman = Yii::app()->db->createCommand("CALL Display_PickingList('1-002','I,II,III,IV,R21','PENJUALAN',2)");
$results = $comman->queryAll();
//echo print_r($results);
$query = $results[0]{'CONCAT(@SQL, " ORDER BY Status, Tanggal")'};

$sk2 = Minout::model()->findAllBySql($query);
foreach($sk2  as $result){
	//if(!empty($result->konsumen->Nama)){echo  $result->konsumen->Nama.'x<p>';}
	echo  $result->Tanggal.'<p>';
}*/
?>


<?php 
$comman = Yii::app()->db->createCommand("CALL Display_MutasiPenerimaan('".$supp."','".$brg."')");
$results = $comman->queryAll();
//echo print_r($results);
$query = $results[0]{'@SQL'};
//echo $query;

echo "<table class='items table'>
		<thead>
		<tr>
		  <th></th>
		  <th>Pembelian ID</th>
		  <th>Supplier</th>
		  <th>Tanggal</th>
		  <th>Barang</th>
		  <th>Jumlah Terima</th>
		  <th>Stok Gdg Kecil</th>
		  <th>Stok Gdg Besar</th>
		  <th>Ke Gdg Kecil</th>
		  <th>Ke Gdg Besar</th>
		</tr>
		</thead>
";

if(empty($query)){
	echo '<tr><td>-</td></tr>';
}else{
	$sk2 = Minoutline::model()->findAllBySql($query);
	foreach($sk2  as $result){
		$mML = Minoutline::model()->findByPk($result->IDD);
		$mMutasitemp = Mutasitemp::model()->findByAttributes(array('MINOUTLine_ID'=>$result->IDD));
		if($mMutasitemp){
			$gk = $mMutasitemp->GudangKecil;
			$gb = $mMutasitemp->GudangBesar;
		}else{
			$gk = $result->PindahKeGudangKecil;
			$gb = $result->PindahKeGudangBesar;
		}
		
		echo '<tr>
				<td><input value="'.$result->IDD.'" checked="checked" type="checkbox" name="MINOUTLine_ID[]"></td>
				<td>'.$mML->Pembelian_ID.'</td>
				<td>'.$mML->minout->supplier->Nama.'</td>
				<td>'.$mML->minout->Tanggal.'</td>
				<td>'.$mML->masterbarang->Nama.'</td>
				<td>'.$mML->Movement.'</td>
				<td>'.$result->GudangKecil.'</td>
				<td>'.$result->GudangBesar.'</td>
				<td>'.CHtml::link($gk,array('mutasi/editmutasi', 'modul'=>$modul, 'MINOUTLine_ID'=>$result->IDD, 'Gudang_ID'=>'1-002')).'</td>
				<td>'.CHtml::link($gb,array('mutasi/editmutasi', 'modul'=>$modul, 'MINOUTLine_ID'=>$result->IDD, 'Gudang_ID'=>'1-001')).'</td>
			 </tr>';
	}
}
echo '</table>';
?>

<?php 
$comman = Yii::app()->db->createCommand("CALL Display_MutasiReturBeli('".$supp."','".$brg."')");
$results = $comman->queryAll();
//echo print_r($results);
$query = $results[0]{'@SQL'};
//echo $query;

echo "<table class='items table'>
		<thead>
		<tr>
		  <th></th>
		  <th>Pembelian ID</th>
		  <th>Supplier</th>
		  <th>Tanggal</th>
		  <th>Barang</th>
		  <th>Jumlah Retur</th>
		</tr>
		</thead>
";

if(empty($query)){
	echo '<tr><td>-</td></tr>';
}else{
	$sk2 = Minoutline::model()->findAllBySql($query);

	foreach($sk2  as $result){
		$mML = Minoutline::model()->findByPk($result->minoutline_id);
		
		echo '<tr>
				<td><input value="'.$result->minoutline_id.'" checked="checked" type="checkbox" name="MINOUTLine_ID_Retur[]"></td>
				<td>'.$mML->Pembelian_ID.'</td>
				<td>'.$mML->minout->supplier->Nama.'</td>
				<td>'.$mML->minout->Tanggal.'</td>
				<td>'.$mML->masterbarang->Nama.'</td>
				<td>'.$result->Retur.'</td>
			 </tr>';
	}
}
echo '</table>';
?>

<div class="titleright">
 <?php echo TbHtml::submitButton('Save',array(
	'name'=>'ButtCreate',
	'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
	'size'=>TbHtml::BUTTON_SIZE_LARGE,
)); ?>
</div>
<?php $this->endWidget(); ?>

<div class="clear"></div>
</br></br>