<style>
#myModal{
	display:none;
}
.modal-content{
	width:100%;
}
</style>

<?php $this->widget('bootstrap.widgets.TbBreadcrumb',array('links'=>array(
		'STOK OPNAME',
	)));
?>

<h2><?php echo 'LIST JADWAL';?></h2>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'customer-grid',
	'dataProvider'=>$mJadwalstokopname->searchByGudangID(),
	'filter'=>$mJadwalstokopname,
	'columns'=>array(		
		array(
			'name'=>'jumlahJSDtl',
			//'value'=>'CHtml::link($data->jumlahJSDtl,Yii::app()->createUrl("statusOpname/editJumlah",array("Jadwalstokopnamedetail_id"=>$data->getJadwalstokopnamedetail_ID, "Jadwalstokopname[namaJSDtl]"=>"'.$nama.'", "Jadwalstokopname[rakJSDtl]"=>"'.$rak.'", "Jadwalstokopname[genuineJSDtl]"=>"'.$genuine.'")))',
			'value'=>'CHtml::link($data->jumlahJSDtl,Yii::app()->createUrl("statusOpname/cekPenerimaan",array("Jadwalstokopnamedetail_id"=>$data->getJadwalstokopnamedetail_ID, "Jadwalstokopname[namaJSDtl]"=>"'.$nama.'", "Jadwalstokopname[rakJSDtl]"=>"'.$rak.'", "Jadwalstokopname[genuineJSDtl]"=>"'.$genuine.'")))',
			'type' => "raw",
			//'visible' => (Yii::app()->user->level=="Admin"),
			//'htmlOptions'=>array('style' => 'text-align: right;'),
		),
		/*array(
			'name'=>'Gudang_id',
			'value'=>'$data->gudang->Nama',
			'visible' => Yii::app()->user->Level=="ADMIN",
			'htmlOptions'=>array('style' => 'text-align: right;'),
		),*/
		array(
			'name'=>'rakJSDtl',
			'value'=>'$data->rakJSDtl',
			//'visible' => (Yii::app()->user->level=="Admin"),
			//'htmlOptions'=>array('style' => 'text-align: right;'),
		),
		array(
			'name'=>'genuineJSDtl',
			'value'=>'$data->genuineJSDtl',
			//'visible' => (Yii::app()->user->level=="Admin"),
			//'htmlOptions'=>array('style' => 'text-align: right;'),
		),
		array(
			'name'=>'namaJSDtl',
			'value'=>'$data->namaJSDtl',
			//'visible' => (Yii::app()->user->level=="Admin"),
			//'htmlOptions'=>array('style' => 'text-align: right;'),
		),
		/*array(
			'class'=>'CButtonColumn',
			'header'=>'Actions',
			'template'=>'{action}',
			
			'buttons'=>array(                
				'action'=>array(
					'label'=>'<p class=\'marginbtn btn btn-danger\'>Stok 0</p>',
					'url'=>'Yii::app()->createAbsoluteUrl("statusopname/updateStokKosong",array("Jadwalstokopnamedetail_id"=>$data->getJadwalstokopnamedetail_ID, "Jadwalstokopname[namaJSDtl]"=>"'.$nama.'", "Jadwalstokopname[rakJSDtl]"=>"'.$rak.'", "Jadwalstokopname[genuineJSDtl]"=>"'.$genuine.'"))',
					'visible' => '$data->jumlahJSDtl == 0', 
				),
			),
		),*/
		
		/*array(
    		  'header'=>'',
	    	  'type'=>'raw',
	          'value'=>'CHtml::Button("+",array(
        		"name" => "get_link",
		        "id" => "get_link",
		        "onClick" => "window.parent.$(\"#cru-dialog\").dialog(\"close\");
					window.parent.$(\"#Transaksidetail_Barang_ID\").val(\'".$data->Barang_ID."\');
					window.parent.$(\"#Transaksidetail_'.$noUrut.'_namaBarang\").val(\'".$data->Barang."\');
					window.parent.$(\"#Transaksidetail_'.$noUrut.'_Harga\").val(\'".number_format($data->Harga,0,"",".")."\');
					window.parent.$(\"#Transaksidetail_'.$noUrut.'_Jumlah\").val(\'1\');
					window.parent.$(\"#Transaksidetail_'.$noUrut.'_TotalPerBarang\").val(\'".number_format($data->Harga,0,"",".")."\');
				"))',
    			),*/
		),
    ));
?>
