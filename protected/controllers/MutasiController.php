<?php

class MutasiController extends Controller
{
	public function actionIndex($modul)
	{
		$mMinoutline=new Minoutline();
		$mMinoutline->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Minoutline'])){
			$mMinoutline->attributes=$_GET['Minoutline'];
		}
		
		$this->render('index',array(
			'mMinoutline'=>$mMinoutline,
			'modul'=>$modul,
		));
	}
	
	public function actionSave(){
		$modul			= '';
		$valid 			= true;
		$sumMovement 	= 0;
		$gdKecil 		= 0;
		$gdBesar 		= 0;
		
		$MinOutGudangBesarId = '';
		$MinOutGudangKecilId = '';
		$MinOutGudangReturId = '';
		
		//GUDANG Besar&Kecil
		if(isset($_POST['MINOUTLine_ID'])){
			$modul = $_POST['modul'];
			$total = count($_POST['MINOUTLine_ID']);
			for( $i= 0 ; $i < $total ; $i++ ){
				$mMinoutline = Minoutline::model()->findByPk($_POST['MINOUTLine_ID'][$i]);
				$sumMovement += $mMinoutline->Movement;
				$gdKecil 	 += Minoutline::getConversi($mMinoutline->barang->Nama, $mMinoutline->MasterBarang_ID, $mMinoutline->Movement, "GudangKecil");
				$gdBesar 	 += Minoutline::getConversi($mMinoutline->barang->Nama, $mMinoutline->MasterBarang_ID, $mMinoutline->Movement, "GudangBesar");
			}
			
			//GUDANG RETUR
			if(isset($_POST['MINOUTLine_ID_Retur'])){
				$totalRetur = count($_POST['MINOUTLine_ID_Retur']);
				for( $i= 0 ; $i < $totalRetur ; $i++ ){
					$mMinoutline = Minoutline::model()->findByPk($_POST['MINOUTLine_ID_Retur'][$i]);
					$sumMovement += $mMinoutline->Movement;
					$gdKecil 	 += Minoutline::getConversi($mMinoutline->barang->Nama, $mMinoutline->MasterBarang_ID, $mMinoutline->Movement, "GudangKecil");
					$gdBesar 	 += Minoutline::getConversi($mMinoutline->barang->Nama, $mMinoutline->MasterBarang_ID, $mMinoutline->Movement, "GudangBesar");
				}
			}
			
			If(($gdKecil + $gdBesar) <> 0){
				If($sumMovement <> ($gdKecil + $gdBesar)){
					Yii::app()->user->setFlash('error','Jumlah  mutasi ke gudang besar dan ke gudang kecil harus sama dengan jumlah penerimaan');
					$this->redirect(array('index', 'modul'=>$modul));
				}else{			
					$comman = Yii::app()->db->createCommand('CALL MIONOUT_Header( "MUTASI KELUAR", "", "'.date("Y-m-d H:i:s").'", "1-003", "", "", "'.Yii::app()->user->getState('NamaPegawai').'")');
					$results = $comman->queryAll();
					$MinOutId = $results[0]{'@ID'};
					
					//Jika ada ke gudang Besar
					if($gdBesar > 0){
						$comman2 = Yii::app()->db->createCommand('CALL MIONOUT_Header( "MUTASI MASUK", "", "'.date("Y-m-d H:i:s").'", "1-001", "", "", "'.Yii::app()->user->getState('NamaPegawai').'" )');
						$results2 = $comman2->queryAll();
						$MinOutGudangBesarId = $results2[0]{'@ID'};
					}
					
					//Jika ada ke gudang Kecil
					if($gdKecil > 0){
						$comman3 = Yii::app()->db->createCommand('CALL MIONOUT_Header( "MUTASI MASUK", "", "'.date("Y-m-d H:i:s").'", "1-002", "", "", "'.Yii::app()->user->getState('NamaPegawai').'" )');
						$results3 = $comman3->queryAll();
						$MinOutGudangKecilId = $results3[0]{'@ID'};
					}
            
				}
			}else{
			
			
			}
		}
	}
	
	public function actionEditmutasi($modul, $MINOUTLine_ID){
		$mMinoutline = Minoutline::model()->findByPk($MINOUTLine_ID);
		$mMutasitemp = Mutasitemp::model()->findByAttributes(array('MINOUTLine_ID'=>$MINOUTLine_ID));
		
		if(!$mMutasitemp){
			$mMutasitemp=new Mutasitemp();
		}
		
		if(isset($_GET['Minoutline'])){
			$mMinoutline->attributes=$_GET['Minoutline'];
		}
		
		if(isset($_POST['Mutasitemp'])){
			$mMutasitemp->attributes=$_POST['Mutasitemp'];
			if($_POST['gudang_id']== '1-001'){
				$mMutasitemp->GudangKecil = $mMinoutline->Movement - $mMutasitemp->GudangBesar;
			}else if($_POST['gudang_id']== '1-002'){
				$mMutasitemp->GudangBesar = $mMinoutline->Movement - $mMutasitemp->GudangKecil;
			}
			$mMutasitemp->MINOUTLine_ID = $MINOUTLine_ID;
			
			if ($mMutasitemp->save()) {
				Yii::app()->user->setFlash('success','Success, Data has been Updated');
				$this->redirect(array('index','modul'=>$modul));
			}
		}
		
		$this->render('editmutasi',array(
			'mMinoutline'=>$mMinoutline,
			'modul'=>$modul,
			'mMutasitemp'=>$mMutasitemp,
		));
	}
		
	public function loadModel($id, $modelClass) {
		$model = CActiveRecord::model($modelClass)->findByPk($id);
		if ($model === null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}
}