<?php

class StatusOpnameController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('drsapdf'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('createTemp','modalMasterBarang','editJumlah','updateStokKosong','cekPenerimaan','editJumlah2'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionCreateTemp()
	{
		$mJadwalstokopname = new Jadwalstokopname();
		$mMasterBarang=new Masterbarang();
		$mJadwalstokopname->unsetAttributes();  // clear any default values
		
		$nama = '';
		$rak = '';
		$genuine = '';
		
		if(isset($_GET['Jadwalstokopname'])){
			$mJadwalstokopname->attributes=$_GET['Jadwalstokopname'];
			$nama 	 = $mJadwalstokopname->namaJSDtl;
			$rak 	 = $mJadwalstokopname->rakJSDtl;
			$genuine = $mJadwalstokopname->genuineJSDtl;
		}
		 
		if (isset($_GET['Masterbarang'])) {
			$mMasterBarang->attributes=$_GET['Masterbarang'];
		}	
		
		$this->render('createTemp',array(
			'mJadwalstokopname'=>$mJadwalstokopname,
			'mMasterBarang'=>$mMasterBarang,
			'nama'=>$nama,
			'rak'=>$rak,
			'genuine'=>$genuine,
		));
	}
	
	public function actionModalMasterBarang()
	{
		$mMasterBarang=new Masterbarang('search');
		$mMasterBarang->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Masterbarang'])) {
			$mMasterBarang->attributes=$_GET['Masterbarang'];
		}	

		$this->layout = '//layouts/iframe';
		$this->render('modalMasterBarang',array(
			'mMasterBarang'=>$mMasterBarang,
		));	
	}
	
	//sama actionUpdateStokKosong
	public function actionEditJumlah($Jadwalstokopnamedetail_id)
	{
		$mJadwalstokopnameDTL = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
		$STOK = '';
		$IDbuatSaveLooping = 0;
		
		if (isset($_GET['Jadwalstokopname']['namaJSDtl'])) {
			$namaJSDtl = $_GET['Jadwalstokopname']['namaJSDtl'];
		}else{
			$namaJSDtl = '';
		}
		if (isset($_GET['Jadwalstokopname']['rakJSDtl'])) {
			$rakJSDtl = $_GET['Jadwalstokopname']['rakJSDtl'];
		}else{
			$rakJSDtl = '';
		}
		if (isset($_GET['Jadwalstokopname']['genuineJSDtl'])) {
			$genuineJSDtl = $_GET['Jadwalstokopname']['genuineJSDtl'];
		}else{
			$genuineJSDtl = '';
		}
		
		if(empty($mJadwalstokopnameDTL)){
			Yii::app()->user->setFlash('error','Barang Sudah di Stok Opname');
			$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
			
		}else{
			$STOK = $mJadwalstokopnameDTL->Jumlah;
		}
		
		$jso_id = $mJadwalstokopnameDTL->jadwalstokopname_id; 
		$mJadwalSO			  = Jadwalstokopname::model()->findByPk($jso_id);
		
		if (isset($_GET['Jadwalstokopnamedetail'])) {
			$mJadwalstokopnameDTL->attributes=$_GET['Jadwalstokopnamedetail'];
		}
		
		if (isset($_POST['clearsessionOne'])) {
			unset($_SESSION['jumlahONE']);
			unset($_SESSION['jumlah']);
			unset($_SESSION['modal']);
			unset($_SESSION['selisih']);
		}
		
		if (isset($_POST['clearsession'])) {
			$total	  = count($_POST['Jadwalstokopnamedetail']);
			for ($i = 0; $i < $total; $i++){
				unset($_SESSION['jumlah'][$i]);
			}
			unset($_SESSION['jumlahONE']);
			unset($_SESSION['modal']);
			unset($_SESSION['selisih']);
		}
		
		if (isset($_POST['cancel'])) {
			unset($_SESSION['modal']);
			unset($_SESSION['selisih']);
		}
		
		if (isset($_POST['cekOne'])) {
			
			unset($_SESSION['jumlah']);
			
			$mJadwalstokopnameDTL->attributes=$_POST['Jadwalstokopnamedetail'];
			$cekDtl = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
			if(!empty($cekDtl)){
				//Check comma
				$comma = ',';
				if( strpos($mJadwalstokopnameDTL->Jumlah, $comma) !== false ) {
					Yii::app()->user->setFlash('error','Jumlah Tidak boleh menggunakan koma');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
				
				if($mJadwalstokopnameDTL->Jumlah < 0 or (!is_numeric($mJadwalstokopnameDTL->Jumlah))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}elseif(!empty($mJadwalstokopnameDTL->JumlahBaru) and ($mJadwalstokopnameDTL->JumlahBaru < 0 or (!is_numeric($mJadwalstokopnameDTL->JumlahBaru)))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
			}
			
			$_SESSION['jumlahONE'] = $mJadwalstokopnameDTL->Jumlah;
			$_SESSION['modal'] = 'show';
			$_SESSION['selisih'] = $mJadwalstokopnameDTL->Jumlah - $_POST['jmlAsli'];
		}
		
		if (isset($_POST['cekMultiple'])) {
			
			unset($_SESSION['jumlahONE']);
			
			$total	  = count($_POST['Jadwalstokopnamedetail']);
			$jmlInput = 0;

			for ($i = 0; $i < $total; $i++){
				
				//Check comma
				$comma = ',';
				if( strpos($_POST['Jadwalstokopnamedetail'][$i]['Jumlah'], $comma) !== false ) {
					Yii::app()->user->setFlash('error','Jumlah Tidak boleh menggunakan koma');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
				
				if($_POST['Jadwalstokopnamedetail'][$i]['Jumlah'] < 0 or (!is_numeric($_POST['Jadwalstokopnamedetail'][$i]['Jumlah']))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}else{
					$cekDtl = Jadwalstokopnamedetail::model()->findByPk($_POST['Jadwalstokopnamedetail'][$i]['Jadwalstokopnamedetail_id']);
					if(empty($cekDtl)){
						Yii::app()->user->setFlash('error','Barang Sudah di Stok Opname');
						$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
					}
				}
				
				$_SESSION['jumlah'][$i] = $_POST['Jadwalstokopnamedetail'][$i]['Jumlah'];
				$jmlInput += $_POST['Jadwalstokopnamedetail'][$i]['Jumlah'];
			}
			
			$_SESSION['modal'] = 'show';
			$_SESSION['selisih'] = $jmlInput - $_POST['jmlAsli'] ;
		}
		
		if (isset($_POST['one'])) {
			unset($_SESSION['modal']);
			unset($_SESSION['selisih']);
			
			$mJadwalstokopnameDTL->attributes=$_POST['Jadwalstokopnamedetail'];
			$cekDtl = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
			if(!empty($cekDtl)){
				
				//Check comma
				$comma = ',';
				if( strpos($mJadwalstokopnameDTL->Jumlah, $comma) !== false ) {
					Yii::app()->user->setFlash('error','Jumlah Tidak boleh menggunakan koma');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
				
				if($mJadwalstokopnameDTL->Jumlah < 0 or (!is_numeric($mJadwalstokopnameDTL->Jumlah))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}elseif(!empty($mJadwalstokopnameDTL->JumlahBaru) and ($mJadwalstokopnameDTL->JumlahBaru < 0 or (!is_numeric($mJadwalstokopnameDTL->JumlahBaru)))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
				
				//update 15 Februari 2022
				if((!empty($mJadwalstokopnameDTL->JumlahBaru) or !empty($mJadwalstokopnameDTL->RakBaru))){
					if((!empty($mJadwalstokopnameDTL->JumlahBaru) and !empty($mJadwalstokopnameDTL->RakBaru))){
						
						$ceks = Stokopnametempdetail::model()->findBySql("
							SELECT Barang_ID, MasterBarang_ID FROM Barang
							WHERE Nama = '".$mJadwalstokopnameDTL->Nama."'
							AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
							AND Rak = '".$mJadwalstokopnameDTL->RakBaru."'
							ORDER BY Barang_ID DESC LIMIT 1
						");
						//AND rak = 'R21-7B-DPN'
						if(empty($ceks)){
							$sqlInsert = "
								INSERT INTO Barang 
								SELECT Generate_Barang_ID(), MasterBarang_ID, Kode, KodeGenuine, Nama, Kategori, StatusPPN, '".$mJadwalstokopnameDTL->RakBaru."', Gudang_ID,
								Pembelian_ID, 0,0,0, Unit, Harga, Modal, StatusAktif, StatusRusak, StatusTahan, NOW(), 'SYS', NULL,''
								FROM Barang
								WHERE Nama = '".$mJadwalstokopnameDTL->Nama."'
								AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
								ORDER BY Barang_ID DESC LIMIT 1
							";
							Yii::app()->db->createCommand($sqlInsert)->execute();
					
							//BARANGBD#1 ADA 4
							$mBarangBD = Barangbd::model()->findBySql("
								SELECT Barang_ID, MasterBarang_ID FROM barangbd
								WHERE Kode = '".$mJadwalstokopnameDTL->mb->Kode."'
								AND Nama = '".$mJadwalstokopnameDTL->Nama."'
								AND Rak = '".$mJadwalstokopnameDTL->Rak."'
								AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
								ORDER BY barang_id DESC LIMIT 1
							");
							if(!empty($mBarangBD->Barang_ID)){
								$mDel1 = Barang::model()->findByPk($mBarangBD->Barang_ID);
								if(!empty($mDel1)){
									$mDel1->delete();
								}
								
								$sqlInsert = "insert into barang select * from barangbd where Barang_ID = '".$mBarangBD->Barang_ID."'";
								Yii::app()->db->createCommand($sqlInsert)->execute();
									
								$mDel2 = Barangbd::model()->findByPk($mBarangBD->Barang_ID);
								if(!empty($mDel2)){
									$mDel2->delete();
								}
							}
						}else{
							Yii::app()->user->setFlash('error','Barang tidak ada di rak '.$mJadwalstokopnameDTL->RakBaru);
							$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
						}						
					}else{
						Yii::app()->user->setFlash('error','Jumlah dan Rak baru harus di isi');
						$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
					}
				}
				
				$a1 = Stokopnamedetail::model()->findBySql("
					select sum(ml.movement) as Jumlah from minoutline ml
					left join minout m on m.minout_id=ml.minout_id
					left join masterbarang mb ON ml.masterbarang_id = mb.masterbarang_id
					where kode = '".$mJadwalstokopnameDTL->mb->Kode."'
					and nama = '".$mJadwalstokopnameDTL->Nama."'
					and rak = '".$mJadwalstokopnameDTL->Rak."'
					and Gudang_ID = '".$mJadwalSO->Gudang_id."'
				");
				
				$Stok = $a1->Jumlah;
				$Delta = $mJadwalstokopnameDTL->Jumlah - $a1->Jumlah;
				/*if(	$Delta == 0){
					$mSave 				= new Stokopname();
					$mSave->StokOpname_ID = CustomAll::model()->generateStokOpname_ID();
					$mSave->Tanggal 	= date("Y-m-d H:i:s");
					$mSave->Gudang_ID 	= $mJadwalSO->Gudang_id;
					//$mSave->Pegawai_ID 	= Yii::app()->user->getState('NamaPegawai');
					$mSave->Pegawai_ID 	= Yii::app()->user->getState('Pegawai_ID');
					$mSave->save();
							
					$mSaveDtl					= new Stokopnamedetail();
					$mSaveDtl->Barang_ID 		= $mJadwalstokopnameDTL->Barang_id;
					$mSaveDtl->MasterBarang_ID 	= $mJadwalstokopnameDTL->MasterBarang_id;
					$mSaveDtl->Jumlah 			= $mJadwalstokopnameDTL->Jumlah;
					$mSaveDtl->Beda 			= $Delta;
					$mSaveDtl->StokOpname_ID    = $mSave->StokOpname_ID;
					$mSaveDtl->save();
				*/	
					//$sqlupdate = "UPDATE masterbarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'";
					//Yii::app()->db->createCommand($sqlupdate)->execute();
					
					/*$sqlupdate = "UPDATE MasterBarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'
								AND MasterBarang_ID NOT IN (
									SELECT MasterBarang_ID FROM JadwalStokOpnameDetail WHERE JadwalStokOpnameDetail_ID <> '".$Jadwalstokopnamedetail_id."' GROUP BY MasterBarang_ID
								)";
					Yii::app()->db->createCommand($sqlupdate)->execute();
					$sqlupdate2 = "UPDATE MasterBarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'
								AND MasterBarang_ID NOT IN (
									SELECT MasterBarang_ID FROM StokOpnameTempDetail GROUP BY MasterBarang_ID
								)";
					Yii::app()->db->createCommand($sqlupdate2)->execute();
					*/
					/*$sqlupdateBrg = "UPDATE Barang LEFT JOIN MasterBarang ON Barang.MasterBarang_ID = MasterBarang.MasterBarang_ID
								SET Barang.StatusAktif = MasterBarang.StatusAktif WHERE Barang.MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'";
					Yii::app()->db->createCommand($sqlupdateBrg)->execute();
				}else{*/
				
				//update 03 Oktober 2023 cek lg sebelum save
				$cekLagi = Jadwalstokopname::model()->findByPk($jso_id);
				if($cekLagi ){
					$mSave 				= new Stokopnametemp();
					$mSave->Tanggal 	= date("Y-m-d H:i:s");
					$mSave->Gudang_ID 	= $mJadwalSO->Gudang_id;
					$mSave->Pegawai_ID 	= Yii::app()->user->getState('Pegawai_ID');
					$mSave->save();
					
					$mSaveDtl					= new Stokopnametempdetail();
					$mSaveDtl->Barang_ID 		= $mJadwalstokopnameDTL->Barang_id;
					$mSaveDtl->MasterBarang_ID 	= $mJadwalstokopnameDTL->MasterBarang_id;
					$mSaveDtl->Jumlah 			= $mJadwalstokopnameDTL->Jumlah;
					$mSaveDtl->Beda 			= $Delta;
					$mSaveDtl->StokOpnameTemp_ID = $mSave->StokOpnameTemp_ID;
					$mSaveDtl->save();
				}else{
					Yii::app()->user->setFlash('error','Status Opname sudah di input');
					$this->redirect(array('statusOpname/createTemp'));
				}
				
				//}
				
				$mDelDtl = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
				$mDelDtl->delete();
				$searchCB = Jadwalstokopnamedetail::model()->findAllByAttributes(array('jadwalstokopname_id'=>$jso_id));
				if(empty($searchCB)){
					$mDel = Jadwalstokopname::model()->findByPk($jso_id);
					$mDel->delete();
				}
				
				//BARANGBD#2 ADA 4
				$mBarangBD = Barangbd::model()->findBySql("
					SELECT Barang_ID, MasterBarang_ID FROM barangbd
					WHERE Kode = '".$mJadwalstokopnameDTL->mb->Kode."'
					AND Nama = '".$mJadwalstokopnameDTL->Nama."'
					AND Rak = '".$mJadwalstokopnameDTL->Rak."'
					AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
					ORDER BY barang_id DESC LIMIT 1
				");
				if(!empty($mBarangBD->Barang_ID)){
					$mDel1 = Barang::model()->findByPk($mBarangBD->Barang_ID);
					if(!empty($mDel1)){
						$mDel1->delete();
					}
					
					$sqlInsert = "insert into barang select * from barangbd where Barang_ID = '".$mBarangBD->Barang_ID."'";
					Yii::app()->db->createCommand($sqlInsert)->execute();
						
					$mDel2 = Barangbd::model()->findByPk($mBarangBD->Barang_ID);
					if(!empty($mDel2)){
						$mDel2->delete();
					}
				}
				
				Yii::app()->user->setFlash('success','Suskes data berhasil di simpan');
				$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				
			}else{
				Yii::app()->user->setFlash('error','Barang Sudah di Stok Opname');
				$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
			}
		}
		
		//sama kaya one cuman ini multiple
		if (isset($_POST['multiple'])) {
			
			//update 03 Oktober 2023 cek lg sebelum save
			$cekLagi = Jadwalstokopname::model()->findByPk($jso_id);
			
			if($cekLagi ){
			}else{
				Yii::app()->user->setFlash('error','Status Opname sudah di input');
				$this->redirect(array('statusOpname/createTemp'));
			}		
			unset($_SESSION['modal']);
			unset($_SESSION['selisih']);
			$total	  = count($_POST['Jadwalstokopnamedetail']);

			for ($i = 0; $i < $total; $i++){
				
				//Check comma
				$comma = ',';
				if( strpos($_POST['Jadwalstokopnamedetail'][$i]['Jumlah'], $comma) !== false ) {
					Yii::app()->user->setFlash('error','Jumlah Tidak boleh menggunakan koma');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
				
				if($_POST['Jadwalstokopnamedetail'][$i]['Jumlah'] < 0 or (!is_numeric($_POST['Jadwalstokopnamedetail'][$i]['Jumlah']))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}else{
					$cekDtl = Jadwalstokopnamedetail::model()->findByPk($_POST['Jadwalstokopnamedetail'][$i]['Jadwalstokopnamedetail_id']);
					if(empty($cekDtl)){
						Yii::app()->user->setFlash('error','Barang Sudah di Stok Opname');
						$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
					}
				}
			}
			
			if(!empty($_POST['JumlahBaru'])){
				if(!empty($_POST['JumlahBaru']) and ($_POST['JumlahBaru'] < 0 or (!is_numeric($_POST['JumlahBaru'])))){
					Yii::app()->user->setFlash('error','Jumlah hanya boleh di isi angka');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
			}
			
			//update 15 Februari 2022
			if((!empty($_POST['JumlahBaru']) or !empty($_POST['RakBaru']))){
				if((!empty($_POST['JumlahBaru']) and !empty($_POST['RakBaru']))){
					
					$ceks = Stokopnametempdetail::model()->findBySql("
						SELECT Barang_ID, MasterBarang_ID FROM Barang
						WHERE Nama = '".$mJadwalstokopnameDTL->Nama."'
						AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
						AND Rak = '".$_POST['RakBaru']."'
						ORDER BY Barang_ID DESC LIMIT 1
					");
					//AND rak = 'R21-7B-DPN'
					if(empty($ceks)){
						$sqlInsert = "
							INSERT INTO Barang 
							SELECT Generate_Barang_ID(), MasterBarang_ID, Kode, KodeGenuine, Nama, Kategori, StatusPPN, '".$_POST['RakBaru']."', Gudang_ID,
							Pembelian_ID, 0,0,0, Unit, Harga, Modal, StatusAktif, StatusRusak, StatusTahan, NOW(), 'SYS', NULL,''
							FROM Barang
							WHERE Nama = '".$mJadwalstokopnameDTL->Nama."'
							AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
							ORDER BY Barang_ID DESC LIMIT 1
						";
						Yii::app()->db->createCommand($sqlInsert)->execute();
						
						//BARANGBD#3 ADA 4
						$mBarangBD = Barangbd::model()->findBySql("
							SELECT Barang_ID, MasterBarang_ID FROM barangbd
							WHERE Kode = '".$mJadwalstokopnameDTL->mb->Kode."'
							AND Nama = '".$mJadwalstokopnameDTL->Nama."'
							AND Rak = '".$mJadwalstokopnameDTL->Rak."'
							AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
							ORDER BY barang_id DESC LIMIT 1
						");
						if(!empty($mBarangBD->Barang_ID)){
							$mDel1 = Barang::model()->findByPk($mBarangBD->Barang_ID);
							if(!empty($mDel1)){
								$mDel1->delete();
							}
							
							$sqlInsert = "insert into barang select * from barangbd where Barang_ID = '".$mBarangBD->Barang_ID."'";
							Yii::app()->db->createCommand($sqlInsert)->execute();
								
							$mDel2 = Barangbd::model()->findByPk($mBarangBD->Barang_ID);
							if(!empty($mDel2)){
								$mDel2->delete();
							}
						}
					}else{
						Yii::app()->user->setFlash('error','Barang tidak ada di rak '.$_POST['RakBaru']);
						$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
					}						
				}else{
					Yii::app()->user->setFlash('error','Jumlah dan Rak baru harus di isi');
					$this->redirect(array('statusOpname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id,'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				}
			}
				
			for ($i = 0; $i < $total; $i++){
				if(empty($_POST['Jadwalstokopnamedetail'][$i]['Barang_id'])){
					$BarangIDVal= '';
				}else{
					$BarangIDVal= $_POST['Jadwalstokopnamedetail'][$i]['Barang_id'];
				}
				
				$jsDtl 	= Jadwalstokopnamedetail::model()->findByPk($_POST['Jadwalstokopnamedetail'][$i]['Jadwalstokopnamedetail_id']);
				$js 	= Jadwalstokopname::model()->findByPk($jsDtl->jadwalstokopname_id);
				
				$a1 = Stokopnametempdetail::model()->findBySql("
					select sum(ml.movement) as Jumlah from minoutline ml
					left join minout m on m.minout_id=ml.minout_id
					left join masterbarang mb ON ml.masterbarang_id = mb.masterbarang_id
					where kode = '".$jsDtl->mb->Kode."'
					and nama = '".$jsDtl->Nama."'
					and rak = '".$_POST['Jadwalstokopnamedetail'][$i]['Rak']."'
					and Gudang_ID = '".$js->Gudang_id."'
				");
				
				$Stok = $a1->Jumlah;
				$Delta = $_POST['Jadwalstokopnamedetail'][$i]['Jumlah'] - $a1->Jumlah;
				
				$getBarang_ID = Barangbd::model()->findBySql("
						SELECT Barang_ID, MasterBarang_ID FROM barang
						WHERE MasterBarang_ID = '".$jsDtl->MasterBarang_id."'
						AND Gudang_ID = '".$js->Gudang_id."'
						AND Rak = '".$_POST['Jadwalstokopnamedetail'][$i]['Rak']."'
						ORDER BY Barang_ID DESC LIMIT 1"
				);
				if(empty($getBarang_ID)){
					//BARANGBD#4 ADA 4
					$mBarangBD = Barangbd::model()->findBySql("
						SELECT Barang_ID, MasterBarang_ID FROM barangbd
						WHERE Kode = '".$jsDtl->mb->Kode."'
						AND Nama = '".$jsDtl->Nama."'
						AND Rak = '".$_POST['Jadwalstokopnamedetail'][$i]['Rak']."'
						AND Gudang_ID = '".$js->Gudang_id."'
						ORDER BY barang_id DESC LIMIT 1
					");
					
					if(!empty($mBarangBD->Barang_ID)){
						$BarangIDVal = $mBarangBD->Barang_ID;
						$mDel1 = Barang::model()->findByPk($mBarangBD->Barang_ID);
						if(!empty($mDel1)){
							$mDel1->delete();
						}
						
						$sqlInsert = "insert into barang select * from barangbd where Barang_ID = '".$mBarangBD->Barang_ID."'";
						Yii::app()->db->createCommand($sqlInsert)->execute();
							
						$mDel2 = Barangbd::model()->findByPk($mBarangBD->Barang_ID);
						if(!empty($mDel2)){
							$mDel2->delete();
						}
					}else{
						$mBarangNewSave = Barang::model()->findBySql("
							SELECT * FROM Barang 
							WHERE MasterBarang_ID = '".$jsDtl->MasterBarang_id."'
							AND Gudang_ID = '".$js->Gudang_id."'
							ORDER BY Barang_ID DESC LIMIT 1
						");
						
						$max = Yii::app()->db->createCommand()->select('max(Barang_ID) as Barang_ID')->from('Barang')->queryScalar();
						$newId = ($max + 1);
						
						$mBrgSave 					= NEW Barang();
						$mBrgSave->Barang_ID		= $newId;
						$mBrgSave->MasterBarang_ID 	= $mBarangNewSave->MasterBarang_ID;
						$mBrgSave->Kode 			= $mBarangNewSave->Kode;
						$mBrgSave->KodeGenuine 		= $mBarangNewSave->KodeGenuine;
						$mBrgSave->Nama				= $mBarangNewSave->Nama;
						$mBrgSave->Kategori			= $mBarangNewSave->Kategori;
						$mBrgSave->StatusPPN		= $mBarangNewSave->StatusPPN;
						$mBrgSave->Rak				= $_POST['Jadwalstokopnamedetail'][$i]['Rak'];
						$mBrgSave->Gudang_ID		= $mBarangNewSave->Gudang_ID;
						$mBrgSave->Jumlah			= 0;
						$mBrgSave->JumlahDraft		= 0;
						$mBrgSave->JumlahDatang		= 0;
						$mBrgSave->Unit				= $mBarangNewSave->Unit;
						$mBrgSave->Harga			= $mBarangNewSave->Harga;
						$mBrgSave->Modal			= $mBarangNewSave->Modal;
						$mBrgSave->StatusAktif		= $mBarangNewSave->StatusAktif;
						$mBrgSave->StatusRusak		= $mBarangNewSave->StatusRusak;
						$mBrgSave->StatusTahan		= $mBarangNewSave->StatusTahan;
						$mBrgSave->Created			= DATE("Y-m-d H:i:s");
						$mBrgSave->UserCreated_ID	= Yii::app()->USER->getState('Pegawai_ID');
						$mBrgSave->save();
						
						$BarangIDVal = $mBrgSave->Barang_ID;
					}
				}else{
					$BarangIDVal = $getBarang_ID->Barang_ID;
				}
				
				/*if(	$Delta == 0){
					$mSave 				= new Stokopname();
					$mSave->StokOpname_ID = CustomAll::model()->generateStokOpname_ID();
					$mSave->Tanggal 	= date("Y-m-d H:i:s");
					$mSave->Gudang_ID 	= $js->Gudang_id;
					//$mSave->Pegawai_ID 	= Yii::app()->user->getState('NamaPegawai');
					$mSave->Pegawai_ID 	= Yii::app()->user->getState('Pegawai_ID');
					$mSave->save();
					
					$mSaveDtl					= new Stokopnamedetail();
					$mSaveDtl->Barang_ID 		= $BarangIDVal;
					$mSaveDtl->MasterBarang_ID 	= $jsDtl->MasterBarang_id;
					$mSaveDtl->Jumlah 			= $_POST['Jadwalstokopnamedetail'][$i]['Jumlah'];
					$mSaveDtl->Beda 			= $Delta;
					$mSaveDtl->StokOpname_ID = $mSave->StokOpname_ID;
					$mSaveDtl->save();
					*/
					//$sqlupdate = "UPDATE masterbarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'";
					//Yii::app()->db->createCommand($sqlupdate)->execute();
					/*
					$sqlupdate = "UPDATE MasterBarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'
								AND MasterBarang_ID NOT IN (
									SELECT MasterBarang_ID FROM JadwalStokOpnameDetail WHERE JadwalStokOpnameDetail_ID <> '".$jsDtl->Jadwalstokopnamedetail_ID."' GROUP BY MasterBarang_ID
								)";
					Yii::app()->db->createCommand($sqlupdate)->execute();
					
					$sqlupdate2 = "UPDATE MasterBarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'
								AND MasterBarang_ID NOT IN (
									SELECT MasterBarang_ID FROM StokOpnameTempDetail GROUP BY MasterBarang_ID
								)";
					Yii::app()->db->createCommand($sqlupdate2)->execute();
					*/
					//$sqlupdateBrg = "UPDATE Barang LEFT JOIN MasterBarang ON Barang.MasterBarang_ID = MasterBarang.MasterBarang_ID
					//			SET Barang.StatusAktif = MasterBarang.StatusAktif WHERE Barang.MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'";
					//Yii::app()->db->createCommand($sqlupdateBrg)->execute();
				//}else{
					
					
					if($IDbuatSaveLooping == 0){
						$mSave 				= new Stokopnametemp();
						$mSave->Tanggal 	= date("Y-m-d H:i:s");
						$mSave->Gudang_ID 	= $js->Gudang_id;
						$mSave->Pegawai_ID 	= Yii::app()->user->getState('Pegawai_ID');
						$mSave->save();
						
						$IDbuatSaveLooping = $mSave->StokOpnameTemp_ID;
					}
					
					$mSaveDtl					= new Stokopnametempdetail();
					$mSaveDtl->Barang_ID 		= $BarangIDVal;
					$mSaveDtl->MasterBarang_ID 	= $jsDtl->MasterBarang_id;
					$mSaveDtl->Jumlah 			= $_POST['Jadwalstokopnamedetail'][$i]['Jumlah'];
					$mSaveDtl->Beda 			= $Delta;
					$mSaveDtl->StokOpnameTemp_ID = $IDbuatSaveLooping;
					$mSaveDtl->save();
				//}
			}
			
			for ($i = 0; $i < $total; $i++){
				$jsDtl 	= Jadwalstokopnamedetail::model()->findByPk($_POST['Jadwalstokopnamedetail'][$i]['Jadwalstokopnamedetail_id']);
				if(!empty($jsDtl)){
					$js 	= Jadwalstokopname::model()->findByPk($jsDtl->jadwalstokopname_id);
					$mDelDtl = Jadwalstokopnamedetail::model()->findByPk($jsDtl->Jadwalstokopnamedetail_ID);
					$mDelDtl->delete();
					
					$searchCB = Jadwalstokopnamedetail::model()->findAllByAttributes(array('jadwalstokopname_id'=>$jsDtl->jadwalstokopname_id));
					if(empty($searchCB)){
						$mDel = Jadwalstokopname::model()->findByPk($jsDtl->jadwalstokopname_id);
						$mDel->delete();
					}
				}
			}
			
			unset($_SESSION['jumlahONE']);
			unset($_SESSION['jumlah']);
			unset($_SESSION['modal']);
			unset($_SESSION['selisih']);
			
			Yii::app()->user->setFlash('success','Suskes data berhasil di simpan');
			$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
				
		}
		
		$this->render('editJumlah',array(
			'mJadwalstokopnameDTL'=>$mJadwalstokopnameDTL,
		));	
	}
	
	//sama actionEditJumlah
	public function actionUpdateStokKosong($Jadwalstokopnamedetail_id)
	{
		$mJadwalstokopnameDTL = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
		$STOK = $mJadwalstokopnameDTL->Jumlah;
		
		if (isset($_GET['Jadwalstokopname']['namaJSDtl'])) {
			$namaJSDtl = $_GET['Jadwalstokopname']['namaJSDtl'];
		}else{
			$namaJSDtl = '';
		}
		if (isset($_GET['Jadwalstokopname']['rakJSDtl'])) {
			$rakJSDtl = $_GET['Jadwalstokopname']['rakJSDtl'];
		}else{
			$rakJSDtl = '';
		}
		if (isset($_GET['Jadwalstokopname']['genuineJSDtl'])) {
			$genuineJSDtl = $_GET['Jadwalstokopname']['genuineJSDtl'];
		}else{
			$genuineJSDtl = '';
		}
		
		if(empty($mJadwalstokopnameDTL)){
			Yii::app()->user->setFlash('error','Barang Sudah di Stok Opname');
			$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
		}else{
			$jso_id = $mJadwalstokopnameDTL->jadwalstokopname_id; 
			$mJadwalSO			  = Jadwalstokopname::model()->findByPk($jso_id);
			
			//MasterBarang::model()->updateByPk($mJadwalstokopnameDTL->MasterBarang_id,array("StatusOpname"=>0, "StatusCheckRak"=>0, ));
			
			$a1 = Stokopnametempdetail::model()->findBySql("
				select sum(ml.movement) as Jumlah from minoutline ml 
				left join minout m on m.minout_id=ml.minout_id 
				left join barang b ON b.barang_id=ml.barang_id
				where b.kode = '".$mJadwalstokopnameDTL->mb->Kode."'
				and b.nama = '".$mJadwalstokopnameDTL->Nama."'
				and b.rak = '".$mJadwalstokopnameDTL->Rak."'
				and b.Gudang_ID = '".$mJadwalSO->Gudang_id."'
			");
			
			$Stok = $a1->Jumlah;
			$Delta = $mJadwalstokopnameDTL->Jumlah - $Stok;
			
			/*if(	$Delta == 0){			
				$mSave 				= new Stokopname();
				$mSave->StokOpname_ID = CustomAll::model()->generateStokOpname_ID();
				$mSave->Tanggal 	= date("Y-m-d H:i:s");
				$mSave->Gudang_ID 	= $mJadwalSO->Gudang_id;
				//$mSave->Pegawai_ID 	= Yii::app()->user->getState('NamaPegawai');
				$mSave->Pegawai_ID 	= Yii::app()->user->getState('Pegawai_ID');
				$mSave->save();
				
				$mSaveDtl					= new Stokopnamedetail();
				$mSaveDtl->Barang_ID 		= $mJadwalstokopnameDTL->Barang_id;
				$mSaveDtl->MasterBarang_ID 	= $mJadwalstokopnameDTL->MasterBarang_id;
				$mSaveDtl->Jumlah 			= $mJadwalstokopnameDTL->Jumlah;
				$mSaveDtl->Beda 			= $Delta;
				$mSaveDtl->StokOpname_ID    = $mSave->StokOpname_ID;
				$mSaveDtl->save();
				*/
				//$sqlupdate = "UPDATE masterbarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'";
				/*$sqlupdate = "UPDATE MasterBarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'
								AND MasterBarang_ID NOT IN (
									SELECT MasterBarang_ID FROM JadwalStokOpnameDetail WHERE JadwalStokOpnameDetail_ID <> '".$Jadwalstokopnamedetail_id."' GROUP BY MasterBarang_ID
								)";
				Yii::app()->db->createCommand($sqlupdate)->execute();
				
				$sqlupdate2 = "UPDATE MasterBarang SET StatusOpname = 0, StatusCheckRak = 0 WHERE MasterBarang_ID = '".$mJadwalstokopnameDTL->MasterBarang_id."'
								AND MasterBarang_ID NOT IN (
									SELECT MasterBarang_ID FROM StokOpnameTempDetail GROUP BY MasterBarang_ID
								)";
				Yii::app()->db->createCommand($sqlupdate2)->execute();
				*/
			//}else{
				$mSave 				= new Stokopnametemp();
				$mSave->Tanggal 	= date("Y-m-d H:i:s");
				$mSave->Gudang_ID 	= $mJadwalSO->Gudang_id;
				$mSave->Pegawai_ID 	= Yii::app()->user->getState('Pegawai_ID');
				$mSave->save();
				
				$mSaveDtl					= new Stokopnamedetail();
				$mSaveDtl->Barang_ID 		= $mJadwalstokopnameDTL->Barang_id;
				$mSaveDtl->MasterBarang_ID 	= $mJadwalstokopnameDTL->MasterBarang_id;
				$mSaveDtl->Jumlah 			= $mJadwalstokopnameDTL->Jumlah;
				$mSaveDtl->Beda 			= $Delta;
				$mSaveDtl->StokOpnameTemp_ID = $mSave->StokOpnameTemp_ID;
				$mSaveDtl->save();
			//}
			
			$mDelDtl = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
			$mDelDtl->delete();
			$searchCB = Jadwalstokopnamedetail::model()->findAllByAttributes(array('jadwalstokopname_id'=>$jso_id));
			if(empty($searchCB)){
				$mDel = Jadwalstokopname::model()->findByPk($jso_id);
				$mDel->delete();
			}
			
			//BARANGBD#2 ADA 4
			$mBarangBD = Barangbd::model()->findBySql("
				SELECT Barang_ID, MasterBarang_ID FROM barangbd
				WHERE Kode = '".$mJadwalstokopnameDTL->mb->Kode."'
				AND Nama = '".$mJadwalstokopnameDTL->Nama."'
				AND Rak = '".$mJadwalstokopnameDTL->Rak."'
				AND Gudang_ID = '".$mJadwalSO->Gudang_id."'
				ORDER BY barang_id DESC LIMIT 1
			");
			if(!empty($mBarangBD->Barang_ID)){
				$mDel1 = Barang::model()->findByPk($mBarangBD->Barang_ID);
				if(!empty($mDel1)){
					$mDel1->delete();
				}
				
				$sqlInsert = "insert into barang select * from barangbd where Barang_ID = '".$mBarangBD->Barang_ID."'";
				Yii::app()->db->createCommand($sqlInsert)->execute();
					
				$mDel2 = Barangbd::model()->findByPk($mBarangBD->Barang_ID);
				if(!empty($mDel2)){
					$mDel2->delete();
				}
			}
				
			Yii::app()->user->setFlash('success','Suskes data berhasil di simpan');
			$this->redirect(array('statusopname/createTemp','Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
		}		
	}
	
	public function actionCekPenerimaan($Jadwalstokopnamedetail_id){
		$mJadwalstokopnameDTL = Jadwalstokopnamedetail::model()->findByPk($Jadwalstokopnamedetail_id);
		$nama = $mJadwalstokopnameDTL->Nama;
		//$nama = "BATOK KM JUPITER,Z/NRT";
		$modul = "MUTASI MASUK";
		
		if (isset($_GET['Jadwalstokopname']['namaJSDtl'])) {
			$namaJSDtl = $_GET['Jadwalstokopname']['namaJSDtl'];
		}else{
			$namaJSDtl = '';
		}
		if (isset($_GET['Jadwalstokopname']['rakJSDtl'])) {
			$rakJSDtl = $_GET['Jadwalstokopname']['rakJSDtl'];
		}else{
			$rakJSDtl = '';
		}
		if (isset($_GET['Jadwalstokopname']['genuineJSDtl'])) {
			$genuineJSDtl = $_GET['Jadwalstokopname']['genuineJSDtl'];
		}else{
			$genuineJSDtl = '';
		}
		
		$ceks = Minoutline::model()->findBySql("
			SELECT t.MINOUTLine_ID, t.Rak, masterbarang.Nama
			FROM minoutline t LEFT JOIN minout ON t.MINOUT_ID = minout.MINOUT_ID
			LEFT JOIN konsumen kn ON minout.Konsumen_ID = kn.Konsumen_ID
			LEFT JOIN masterbarang masterbarang ON `t`.`MasterBarang_ID`=`masterbarang`.`MasterBarang_ID`
			LEFT JOIN mutasi ON minout.Modul_ID = mutasi.mutasi_ID
			LEFT JOIN gudang ON mutasi.DariGudang_ID = gudang.gudang_ID
			WHERE MINOUTLine_ID != ' '
			AND minout.Modul = '".$modul."' AND minout.Gudang_ID = '".$mJadwalstokopnameDTL->jso->Gudang_id."' 
			AND t.STATUS = 0 AND Pesan != 0 AND masterbarang.Nama = '".$nama."'
			limit 1
		");
		
		//foreach($ceks as $ceks){
		//	if(!empty($ceks->masterbarang->Nama)){
		//		echo 'xx'.$ceks->masterbarang->Nama.'<p>';	
		//	}
		//}
		
		//kalau ada redirect ke penerimaan gudang besar/kecil
		if($mJadwalstokopnameDTL->jso->Gudang_id == '1-001'){
			$gudang = 'GUDANG BESAR';
		}else{
			$gudang = 'GUDANG KECIL';
		}
		if(!empty($ceks)){
			//'ada';
			$notif = "Harap masukkan penerimaan barang terlebih dahulu !";
			$this->redirect(array('pembelian/validasi','qrcode'=>$ceks->Rak, 'token'=>strtotime(date("Y-m-d H:i:s")), 'MINOUTLine_ID'=>$ceks->MINOUTLine_ID, 'modul'=>$gudang, 'type'=>'showall', 'filteNamaBarang'=>'', 'filteSuratJalan_search'=>'', 'notif'=>$notif, 'Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id));	
		}else{
			$this->redirect(array('statusopname/editJumlah','Jadwalstokopnamedetail_id'=>$Jadwalstokopnamedetail_id, 'Jadwalstokopname[namaJSDtl]'=>$namaJSDtl, 'Jadwalstokopname[rakJSDtl]'=>$rakJSDtl, 'Jadwalstokopname[genuineJSDtl]'=>$genuineJSDtl));
		}
	}
}