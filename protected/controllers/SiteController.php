<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

		$this->layout = '//layouts/mainAdminLTE';

		$mBarang = Totalbarang::model()->findAllByAttributes(array());
		$count = count($mBarang);

		$mMasterbarang = Masterbarang::model()->findAllByAttributes(array('StatusAktif' => 1));
		$totalMinStok = 0;
		foreach ($mMasterbarang as $mMasterbarang) {

			$model = Barang::model();
			$criteria = new CDbCriteria;
			$criteria->select = 'SUM(Jumlah) as Jumlah';
			$criteria->condition = 'StatusAktif = :StatusAktif and MasterBarang_ID = :MasterBarang_ID';
			$criteria->params = array(':StatusAktif' => 1, ':MasterBarang_ID' => $mMasterbarang->MasterBarang_ID);

			$total = $model->getCommandBuilder()->createFindCommand($model->getTableSchema(), $criteria)->queryScalar();
?>
			<script type="text/javascript">
				// JavaScript code to display a message in the browser console
				console.log('<?php echo $mMasterbarang->Nama . " stok " . $mMasterbarang->MinStok; ?>');
			</script>
<?php
			if ($mMasterbarang->MinStok > $total) {
				$totalMinStok = $totalMinStok + 1;
			}
		}


		$criteria = new CDbCriteria();
		//$criteria->select = 'SUM(Total) as Total';
		$criteria->select = 'count(Penjualan_ID) as Penjualan_ID';
		$criteria->condition = 'MONTH(Tanggal) = MONTH(CURDATE()) AND YEAR(Tanggal) = YEAR(CURDATE()) AND StatusAKtif = 1';
		$totalTransaksiPenjualan = Penjualan::model()->find($criteria)->Penjualan_ID;


		// SELECT m.Nama, MIN(p.Expired) AS Expired  
		// FROM pembeliandetail p 
		// LEFT JOIN barang b ON p.Barang_ID = b.Barang_ID
		// LEFT JOIN masterbarang m ON m.MasterBarang_ID = b.MasterBarang_ID 
		// WHERE b.Jumlah > 0 
		// AND p.Expired <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
		// GROUP BY b.MasterBarang_ID 
		// ORDER BY MIN(p.Expired) DESC;

		$criteria = new CDbCriteria();
		$criteria->select = "m.Nama, MIN(t.Expired) AS Expired";
		$criteria->join = "LEFT JOIN barang b ON t.Barang_ID = b.Barang_ID LEFT JOIN masterbarang m ON m.MasterBarang_ID = b.MasterBarang_ID";
		$criteria->condition = "b.Jumlah > 0 AND t.Expired <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)";
		$criteria->group = "b.MasterBarang_ID";
		$criteria->order = "MIN(t.Expired) DESC";

		$mainResults = PembelianDetail::model()->findAll($criteria);

		$totalData = 0;
		foreach ($mainResults as $result) {
			$totalData++;
		}

		$this->render('index', array(
			'count' => $count,
			'totalMinStok' => $totalMinStok,
			'totalTransaksiPenjualan' => $totalTransaksiPenjualan,
			'totalData' => $totalData,
		));
	}

	public function actionGetData($dashboard)
	{
		if ($dashboard == "totalBarang") {
			$criteria = new CDbCriteria();
			$criteria->order = 't.Nama ASC';
			$model = Totalbarang::model()->findAll($criteria);
		} elseif ($dashboard == "stokLimit") {
			$criteria = new CDbCriteria();
			$criteria->select = 't.Nama, t.MinStok, SUM(b.TotalJumlah) AS Keterangan';
			$criteria->join = 'JOIN (SELECT MasterBarang_ID, SUM(Jumlah) AS TotalJumlah FROM Barang GROUP BY MasterBarang_ID) b ON t.MasterBarang_ID = b.MasterBarang_ID';
			$criteria->condition = 't.MinStok > b.TotalJumlah and t.StatusAktif = 1';
			$criteria->group = 't.Nama';
			$model = Masterbarang::model()->findAll($criteria);
		} elseif ($dashboard == "totalPenjualan") {
		} else {
			$criteria = new CDbCriteria();
			$criteria->select = "t.Barang_ID, m.Nama, MIN(t.Expired) AS Expired";
			$criteria->join = "LEFT JOIN barang b ON t.Barang_ID = b.Barang_ID LEFT JOIN masterbarang m ON m.MasterBarang_ID = b.MasterBarang_ID";
			$criteria->condition = "b.Jumlah > 0 AND t.Expired <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)";
			$criteria->group = "b.MasterBarang_ID";
			$criteria->order = "MIN(t.Expired) ASC";

			$model = PembelianDetail::model()->findAll($criteria);

			$totalData = 0;
			foreach ($model as $result) {
				$totalData++;
			}
		}

		if ($model !== null) {
			$this->renderPartial('_dataTable', array(
				'model' => $model,
				'dashboard' => $dashboard,
			), false, true);
		} else {
			echo '<p>Data not found.</p>';
		}
	}

	public function actionUpdatestatus()
	{
		Yii::import('ext.yiiwheels.widgets.editable.WhEditableSaver');
		$es = new WhEditableSaver('Input');
		$es->update();
	}

	public function actionUpdatestatusDtl()
	{
		Yii::import('ext.yiiwheels.widgets.editable.WhEditableSaver');
		$es = new WhEditableSaver('Barang');
		$es->update();
	}

	public function actionCreate()
	{
		$mInput	= new Input();
		$mBarang = new Barang();

		if (isset($_POST['Input'])) {
			$mInput->attributes = $_POST['Input'];
			if ($mInput->save()) {

				//SAVE BARANG
				$total = count($_POST['Barang']);
				for ($i = 0; $i < $total; $i++) {
					if (!empty($_POST['Barang'][$i]['jenis']) or !empty($_POST['Barang'][$i]['qty'])) {
						$mBarangSave = new Barang();
						$mBarangSave->jenis 	= $_POST['Barang'][$i]['jenis'];
						$mBarangSave->qty 		= $_POST['Barang'][$i]['qty'];
						$mBarangSave->uom 		= $_POST['Barang'][$i]['uom'];
						$mBarangSave->ket 		= $_POST['Barang'][$i]['ket'];
						$mBarangSave->input_id 	= $mInput->id;
						$mBarangSave->save();
					}
				}

				$this->redirect(array('index'));
			}
		}

		$this->layout = '//layouts/main';
		$this->render('create', array(
			'mInput' => $mInput,
			'mBarang' => $mBarang,
		));
	}

	public function actionUpdate($id)
	{
		$mInput = $this->loadModel($id, 'Input');
		$mBarang = new Barang();

		if (isset($_POST['Input'])) {
			$mInput->attributes = $_POST['Input'];
			if ($mInput->save()) {
				//SAVE BARANG
				$total = count($_POST['Barang']);
				for ($i = 0; $i < $total; $i++) {
					if (empty($_POST['Barang'][$i]['id'])) {
						//CREATE NEW BARANG
						$mBarangSave = new Barang();
						$mBarangSave->jenis 	= $_POST['Barang'][$i]['jenis'];
						$mBarangSave->qty 		= $_POST['Barang'][$i]['qty'];
						$mBarangSave->uom 		= $_POST['Barang'][$i]['uom'];
						$mBarangSave->ket 		= $_POST['Barang'][$i]['ket'];
						$mBarangSave->input_id 	= $mInput->id;
						$mBarangSave->save();
					} else {
						//UPDATE BARANG
						Barang::model()->updateByPk($_POST['Barang'][$i]['id'], array(
							"jenis" => $_POST['Barang'][$i]['jenis'],
							"qty" => $_POST['Barang'][$i]['qty'],
							"uom" => $_POST['Barang'][$i]['uom'],
							"ket" => $_POST['Barang'][$i]['ket'],
						));
					}
				}
				$this->redirect(array('index'));
			}
		}

		$this->layout = '//layouts/main';
		$this->render('update', array(
			'mInput' => $mInput,
			'mBarang' => $mBarang,
		));
	}

	public function actionCreateExcel($tglTerimaBrg, $supplier, $noSJ)
	{

		if (!empty($tglTerimaBrg)) {
			$a = 'tglTerimaBrg = "' . $tglTerimaBrg . '"';
		} else {
			$a = 'tglTerimaBrg!= "' . $tglTerimaBrg . '"';
		}
		if (!empty($supplier)) {
			$b = 'and supplier like "%' . $supplier . '%"';
		} else {
			$b = ' ';
		}
		if (!empty($noSJ)) {
			$c = 'and noSJ like "%' . $noSJ . '%"';
		} else {
			$c = ' ';
		}

		$mInput = Input::model()->findAllBySql("select * from input WHERE " . $a . ' ' . $b . ' ' . $c);

		Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel = XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator("OSolution")
			->setLastModifiedBy("OSolution")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");

		$sheet	= 0;
		$no		= 1;
		$baris 	= 3;

		//STYLE
		$styleHeader = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'b9b9b9')
			),
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '000000'),
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
			)
		);

		$styleBody = array(
			//'fill' => array(
			//	'type' => PHPExcel_Style_Fill::FILL_SOLID,
			//	'color' => array('rgb' => 'b9b9b9')
			//),
			'font' => array(
				//'bold' => true,
				'color' => array('rgb' => '000000'),
				'size' => 11,
			),
			//'alignment' => array(
			//	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			//),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
			)
		);


		$objPHPExcel->getActiveSheet()->getStyle('A1:W2')->applyFromArray($styleHeader);
		//auto widthsize
		foreach (range('A', 'W') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		//wrapText
		$objPHPExcel->getActiveSheet()->getStyle('B1:W1')->getAlignment()->setWrapText(true);

		$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A1:A2')->setCellValue('A1', 'No');
		$objPHPExcel->setActiveSheetIndex($sheet)
			->mergeCells('A1:A2')->setCellValue('A1', 'NO')
			->mergeCells('B1:B2')->setCellValue('B1', 'TGL SURAT JALAN')
			->mergeCells('C1:C2')->setCellValue('C1', 'TGL TERIMA BARANG')
			->mergeCells('D1:D2')->setCellValue('D1', 'SUPPLIER')
			->mergeCells('E1:E2')->setCellValue('E1', 'JENIS SUPPLIER')
			->mergeCells('F1:F2')->setCellValue('F1', 'NOMOR SJ')
			->mergeCells('G1:I1')->setCellValue('G1', 'DOK PABEAN')
			->setCellValue('G2', 'TGL')
			->setCellValue('H2', 'NO PENDAFTARAN')
			->setCellValue('I2', 'JENIS DOK')
			->mergeCells('J1:J2')->setCellValue('J1', 'TGL BUAT BPB SB')
			->mergeCells('K1:K2')->setCellValue('K1', 'NO BPB SB')
			->mergeCells('L1:L2')->setCellValue('L1', 'TGL BUAT BPB IT INV')
			->mergeCells('M1:M2')->setCellValue('M1', 'NO BPB IT INV')
			->mergeCells('N1:N2')->setCellValue('N1', 'TGL PENYERAHAN BPB IT INV')
			->mergeCells('O1:O2')->setCellValue('O1', 'TGL TERIMA BPB SB')
			->mergeCells('P1:P2')->setCellValue('P1', 'NO PO SB')
			->mergeCells('Q1:Q2')->setCellValue('Q1', 'KETERANGAN')
			->mergeCells('R1:R2')->setCellValue('R1', 'TANGGAL TERIMA')
			->mergeCells('S1:S2')->setCellValue('S1', 'CHECKLIST')

			->mergeCells('T1:T2')->setCellValue('T1', 'JENIS BARANG')
			->mergeCells('U1:U2')->setCellValue('U1', 'QTY')
			->mergeCells('V1:V2')->setCellValue('V1', 'UOM')
			->mergeCells('W1:W2')->setCellValue('W1', 'CATATAN');

		foreach ($mInput as $result) {
			$objPHPExcel->getActiveSheet()->getStyle('A' . $baris . ':S' . $baris . '')->applyFromArray($styleBody);

			if (!empty($result->tglSJ)) {
				$tgl1 = date("d-m-Y", strtotime($result->tglSJ));
			} else {
				$tgl1 = ' ';
			}
			if (!empty($result->tglTerimaBrg)) {
				$tgl2 = date("d-m-Y", strtotime($result->tglTerimaBrg));
			} else {
				$tgl2 = ' ';
			}
			if (!empty($result->tglPabean)) {
				$tgl3 = date("d-m-Y", strtotime($result->tglPabean));
			} else {
				$tgl3 = ' ';
			}
			if (!empty($result->tglBuatBPB)) {
				$tgl4 = date("d-m-Y", strtotime($result->tglBuatBPB));
			} else {
				$tgl4 = ' ';
			}
			if (!empty($result->tglBuatBPBIT)) {
				$tgl5 = date("d-m-Y", strtotime($result->tglBuatBPBIT));
			} else {
				$tgl5 = ' ';
			}
			if (!empty($result->tglTerimaBPBIT)) {
				$tgl6 = date("d-m-Y", strtotime($result->tglTerimaBPBIT));
			} else {
				$tgl6 = ' ';
			}
			if (!empty($result->tglTerimaBPB)) {
				$tgl7 = date("d-m-Y", strtotime($result->tglTerimaBPB));
			} else {
				$tgl7 = ' ';
			}
			if (!empty($result->tglTerima)) {
				$tgl8 = date("d-m-Y", strtotime($result->tglTerima));
			} else {
				$tgl8 = ' ';
			}

			$objPHPExcel->setActiveSheetIndex($sheet)
				->setCellValue('A' . $baris, $no)
				->setCellValue('B' . $baris, $tgl1)
				->setCellValue('C' . $baris, $tgl2)
				->setCellValue('D' . $baris, $result->supplier)
				->setCellValue('E' . $baris, $result->jenisSupplier)
				->setCellValue('F' . $baris, $result->noSJ)
				->setCellValue('G' . $baris, $tgl3)
				->setCellValue('H' . $baris, $result->noPend)
				->setCellValue('I' . $baris, $result->jenisDok)
				->setCellValue('J' . $baris, $tgl4)
				->setCellValue('K' . $baris, $result->noBPB)
				->setCellValue('L' . $baris, $tgl5)
				->setCellValue('M' . $baris, $result->noBPBIT)
				->setCellValue('N' . $baris, $tgl6)
				->setCellValue('O' . $baris, $tgl7)
				->setCellValue('P' . $baris, $result->noPOSB)
				->setCellValue('Q' . $baris, $result->keterangan)
				->setCellValue('R' . $baris, $tgl8)
				->setCellValue('S' . $baris, $result->checklist);

			$mBarang = Barang::model()->findAllByAttributes(array('input_id' => $result->id));
			$lastBarang = end(array_keys($mBarang));
			foreach ($mBarang as $key => $resultBrg) {
				$objPHPExcel->getActiveSheet()->getStyle('A' . $baris . ':W' . $baris . '')->applyFromArray($styleBody);
				$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('T' . $baris, $resultBrg->jenis)
					->setCellValue('U' . $baris, $resultBrg->qty)
					->setCellValue('V' . $baris, $resultBrg->uom)
					->setCellValue('W' . $baris, $resultBrg->ket);

				if ($key != $lastBarang) {
					$baris++;
				}
			}
			$no++;
			$baris++;
		}
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . strtotime("now") . '.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		Yii::app()->end();

		/*$this->render('delet',array(
			'mInput'=>$mInput,
		));
		*/
	}


	public function actionForgotpassword()
	{
		$mUser = new User('forgotpassword');

		if (isset($_POST['User'])) {
			$mUser->attributes = $_POST['User'];
			$findEmail 	= User::model()->findByAttributes(array('email' => $mUser->email));

			if (!empty($findEmail)) {
				$token = strtotime(date('Y-m-d H:i:s'));
				User::model()->updateByPk($findEmail->id, array("token" => $token));
				$activation_url = $this->createAbsoluteUrl("site/changepasswordform", array("token" => $token, "email" => $mUser->email));
				$spasi			= "<tr><td height='20px'></td></tr>";

				$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
				$mailer->IsSMTP();
				$mailer->IsHTML(true);
				$mailer->SMTPAuth = true;
				$mailer->SMTPSecure = "ssl";
				$mailer->Host = Yii::app()->params['adminHost'];
				$mailer->Port = 465;
				$mailer->Username = Yii::app()->params['adminEmail'];
				$mailer->Password = Yii::app()->params['adminPass'];
				$mailer->From = Yii::app()->params['adminEmail']; //<<harus sama kalau online di cpanel
				$mailer->FromName = Yii::app()->params['webName'];
				$mailer->AddAddress($mUser->email);
				//$mailer->AddAddress('syamsuri_core@yahoo.com');
				//$mailer->AddCC($superUser_db1->email);//tembusan ke super user
				$mailer->Subject = "Reset Password From " . Yii::app()->params['webName'];
				$mailer->Body = "
					<table border='0' cellpadding='0' cellspacing='0' width='100%'>
						<tr><td width='260' valign='top'>Dear, " . $findEmail->email . "</td></tr>
					</table>
					<br><p><p>This email has been sent from " . Yii::app()->params['webUrl'] . "
					<p>----------------------------------------------------------------------------
					<br><p><p>You have received this email because a user account password recovery was instigated by you on " . Yii::app()->params['webUrl'] . "<p>
					<br><p><p><p>Your Email : " . $findEmail->email . "
					<br><p><p>If you did not request this password change, please IGNORE and DELETE this email immediately. 
					<p><p>If you wish your password to be reset. Please Click this <a href=" . $activation_url . "> Link </a>
				";
				if ($mailer->Send()) {
					Yii::app()->user->setFlash('success', "Please check your email. An instructions was sent to your email address.");
					$this->redirect(array('login'));
				}

				//echo "<a href=".$activation_url."> Link </a>";
			} else {
				Yii::app()->user->setFlash('error', "Email Account is Incorrect, Please Contact Our Admin ");
			}
		}

		$this->layout = 'application.views.layouts.mainlogin';
		$this->render('forgotpassword', array('model' => $mUser));
	}

	public function actionChangepasswordform($token, $email)
	{
		$datenow 	= strtotime(date("Y-m-d H:i:s"));
		$expired 	= strtotime(date('Y-m-d H:i:s', $token) . ' +1 day');
		$mSiswalogin = Siswalogin::model()->findByAttributes(array('Email' => $email, 'Token' => $token));
		$model 		= new Siswalogin('forgotpasswordform');

		if ($mSiswalogin) {
			if ($datenow >= $expired) {
				Yii::app()->user->setFlash('error', "Your link has been expired.");
				$this->redirect(array('login'));
			} else {
				if (isset($_POST['Siswalogin'])) {
					$model->attributes = $_POST['Siswalogin'];
					$save = Siswalogin::model()->updateByPk($mSiswalogin->Siswalogin_ID, array("Password" => $model->Password, "Token" => $datenow));
					if ($save) {
						Yii::app()->user->setFlash('success', "Your password has been change. Please Login.");
						$this->redirect(array('login'));
					}
				}
			}
		} else {
			Yii::app()->user->setFlash('error', "Your link has is not valid.");
			$this->redirect(array('login'));
		}

		$this->layout = 'application.views.layouts.mainlogin';
		$this->render('changepasswordform', array('model' => $model));
	}

	public function actionStrukturOrganisasi()
	{
		$this->render('strukturOrganisasi');
	}

	public function actionAdmin()
	{
		$mGuru		 = Guru::model()->findAll();
		$mSekolah	 = Sekolah::model()->findAll();
		$mPengumuman = Pengumuman::model()->findAll();

		$this->layout = 'application.views.layouts.columnAdmin';
		$this->render('admin', array(
			'mGuru' => $mGuru,
			'mSekolah' => $mSekolah,
			'mPengumuman' => $mPengumuman,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		/*$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
		*/
		$this->render('contact');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model = new LoginForm;

			// if it is ajax validation request
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			// collect user input data
			if (isset($_POST['LoginForm'])) {
				$model->attributes = $_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if ($model->validate() && $model->login()) {
					Yii::app()->user->setFlash('success', "You Have Successfully Login");
					$this->redirect(array('site/index'));
				} else {
					Yii::app()->user->setFlash('error', "PIN anda salah"); //JUST 2 controller and (site/login)
					$this->redirect(array('site/login'));
				}
			}

			$this->layout = 'application.views.layouts.mainlogin';
			$this->render('login', array('model' => $model));
		} else {
			$this->redirect(array('site/index'));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->homeUrl);
		$this->redirect(array('site/login'));
	}

	public function actionRegister()
	{
		$mUser = new User('register');
		$mGuru = new Guru('register');

		if (isset($_POST['User'], $_POST['Guru'])) {
			$mUser->attributes = $_POST['User'];
			$mGuru->attributes = $_POST['Guru'];

			// validasi model
			$valid = $mUser->validate();
			$valid = $mGuru->validate() && $valid;

			if ($valid) {
				$mUser->last_login	= date('Y-m-d H:i:s');
				$mUser->token 		= strtotime(date('Y-m-d H:i:s'));
				$mUser->role_id		= 3;
				$mUser->status		= 1;

				$mGuru->save(false);
				$mUser->guru_id		= $mGuru->id;
				$mUser->save(false);

				//if($mUser->save()){
				//send email
				$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
				$mailer->IsSMTP();
				$mailer->IsHTML(true);
				$mailer->SMTPAuth = true;
				$mailer->SMTPSecure = "ssl";
				$mailer->Host = Yii::app()->params['adminHost'];
				$mailer->Port = 465;
				$mailer->Username = Yii::app()->params['adminEmail'];
				$mailer->Password = Yii::app()->params['adminPass'];
				$mailer->From = Yii::app()->params['adminEmail']; //<<harus sama kalau online di cpanel
				$mailer->FromName = Yii::app()->params['webName'];
				$mailer->AddAddress($mUser->email);
				//$mailer->AddAddress('syamsuri_core@yahoo.com');
				//$mailer->AddCC($superUser_db1->email);//tembusan ke super user
				$mailer->Subject = "Welcome to " . Yii::app()->params['webName'];

				$message = file_get_contents(Yii::app()->request->hostInfo . Yii::app()->baseUrl . '/emailtemplate/template-register.html');
				$message = str_replace("##webname##", $mUser->username, $message);
				$message = str_replace("##USERNAME##", $mUser->username, $message);
				$mailer->MsgHTML($message);
				$mailer->Send();

				Yii::app()->user->setFlash('success', "Selamat anda berhasil mendaftar, Silahkan LOGIN");
				$this->redirect(array('site/login'));
				//}
			}
		}
		$this->layout = 'application.views.layouts.mainlogin';
		$this->render('register', array('mUser' => $mUser, 'mGuru' => $mGuru));
	}

	public function actionListLokasi()
	{
		$mKelurahan = new Kelurahan('search');
		$mKelurahan->unsetAttributes();  // clear any default values

		if (isset($_GET['Kelurahan'])) {
			$mKelurahan->attributes = $_GET['Kelurahan'];
		}

		$this->layout = '//layouts/iframe';
		$this->render('listLokasi', array(
			'mKelurahan' => $mKelurahan,
		));
	}

	public function loadModel($id, $modelClass)
	{
		$model = CActiveRecord::model($modelClass)->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}
}
