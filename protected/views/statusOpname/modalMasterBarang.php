<?php 
echo $MasterBarang_ID;

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'customer-grid',
	'dataProvider'=>$mMasterBarang->searchModalMasterBarang(),
	'filter'=>$mMasterBarang,
	'columns'=>array(
		array(
			'name'=>'KodeGenuine',
			'value'=>'$data->KodeGenuine',
			//'visible' => (Yii::app()->user->level=="Admin"),
		),
		array(
			'name'=>'Kode',
			'value'=>'$data->Kode',
			//'visible' => (Yii::app()->user->level=="Admin"),
			//'htmlOptions'=>array('style' => 'text-align: right;'),
		),
		array(
			'name'=>'Nama',
			'value'=>'$data->Nama',
			//'visible' => (Yii::app()->user->level=="Admin"),
			//'htmlOptions'=>array('style' => 'text-align: right;'),
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'Actions',
			'template'=>'{add}',
			'buttons'=>array(                
				'add'=>array(
					'label'=>'<p class=\'marginbtn btn btn-primary\'>+</p>',
					'url'=>'Yii::app()->createAbsoluteUrl("statusopname/createTemp",array("Masterbarang[MasterBarang_ID]"=>\''.$MasterBarang_ID.'\'.$data->MasterBarang_ID, "Stokopnametemp[Tanggal]"=>\''.$Tanggal.'\', "Stokopnametemp[Gudang_ID]"=>\''.$Gudang_ID.'\' ))',
					//'url'=>'$this->grid->controller->createUrl("site/transaksiNote", array("Transaksi_ID"=>$data->Transaksi_ID,"asDialog"=>1,"gridId"=>$this->grid->id))',    
					//'visible' => 'Transaksinote::notifUnreadUser1($data->Transaksi_ID, "useradmin")',
					//'visible'=>'$data->Status < 4',
				),
		)),
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