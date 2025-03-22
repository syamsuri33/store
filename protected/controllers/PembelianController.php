<?php

class PembelianController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/mainAdminLTE';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'updateSessionPembelianDetails', 'exportToExcel', 'getData'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'users' => array('admin'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	public function actionExportToExcel()
	{
		$startDate = isset($_GET['startdate']) ? $_GET['startdate'] : null;
		$endDate = isset($_GET['enddate']) ? $_GET['enddate'] : null;

		Yii::import('ext.phpexcel.Classes.PHPExcel');
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Data Export")
			->setSubject("Data Export")
			->setDescription("Exported data to Excel.")
			->setKeywords("excel php yii")
			->setCategory("Export");

		// Set header row
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'Kategori 1')
			->setCellValue('C1', 'Kategori 2')
			->setCellValue('D1', 'Item Product')
			->setCellValue('E1', 'Tanggal Pembelian')
			->setCellValue('F1', 'Vendor')
			->setCellValue('G1', 'PRODUCT NAME - NOTA')
			->setCellValue('H1', 'Pcs / Carton')
			->setCellValue('I1', 'Pembelian (Pcs)')
			->setCellValue('J1', 'Purchasing')
			->setCellValue('J2', 'HARGA')
			->setCellValue('K2', 'Disc / Ongkos Kirim')
			->setCellValue('L2', 'GRAND TOTAL')
			->setCellValue('M1', 'HARGA BELI NORMAL')
			->setCellValue('N1', 'HARGA BELI REAL')
			->setCellValue('O1', 'PRICE LIST')
			->setCellValue('O2', 'OFFLINE')
			->setCellValue('P2', 'TOPED');

		$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
		$objPHPExcel->getActiveSheet()->mergeCells('D1:D2');
		$objPHPExcel->getActiveSheet()->mergeCells('E1:E2');
		$objPHPExcel->getActiveSheet()->mergeCells('F1:F2');
		$objPHPExcel->getActiveSheet()->mergeCells('G1:G2');
		$objPHPExcel->getActiveSheet()->mergeCells('H1:H2');
		$objPHPExcel->getActiveSheet()->mergeCells('I1:I2');
		$objPHPExcel->getActiveSheet()->mergeCells('J1:L1');
		$objPHPExcel->getActiveSheet()->mergeCells('M1:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('N1:N2');
		$objPHPExcel->getActiveSheet()->mergeCells('O1:P1');

		$headerStyleArray = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'D3D3D3')
			),
			'borders' => array(
				'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true
			)
		);

		$footerStyleArray = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'D3D3D3')
			),
			'borders' => array(
				'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			),
			'alignment' => array(
				'wrap' => true
			),
			'font' => array(
				'bold' => true
			)
		);

		$objPHPExcel->getActiveSheet()->getStyle('A1:P2')->applyFromArray($headerStyleArray);
		
		//start
		$row = 3;

		$command = Yii::app()->db->createCommand();
		$sql = 'select k2.Kategori as Kategori1, k.Kategori as Kategori2, mb.Nama, p.Tanggal, 
		v.Vendor, mb.Keterangan, s.Satuan, s.Jumlah * pd.Jumlah as Jumlah, pd.Harga, pd.Diskon, pd.HargaOffline, pd.HargaTokped 
		from pembeliandetail pd 
		left join pembelian p on p.Pembelian_ID  = pd.Pembelian_ID 
		left join barang b on b.Barang_ID  = pd.Barang_ID
		left join masterbarang mb on mb.MasterBarang_ID  = b.MasterBarang_ID 
		left join kategori k on k.Kategori_ID = mb.Kategori_ID 
		left join kategori k2 on k2.Kategori_ID  = k.Parent
		left join vendor v on v.Vendor_ID = mb.Vendor_ID 
		left join satuan s on s.Satuan_ID = pd.Satuan_ID
		where p.Pembelian_ID is not null ';
		$params = array();

		if ($startDate && $endDate) {
			$sql .= ' AND `Tanggal` >= :startDate AND `Tanggal` <= :endDate';
			$params[':startDate'] = date('Y-m-d', strtotime($startDate));
			$params[':endDate'] = date('Y-m-d', strtotime($endDate));
		} elseif ($startDate) {
			$sql .= ' AND `Tanggal` >= :startDate';
			$params[':startDate'] = date('Y-m-d', strtotime($startDate));
		} elseif ($endDate) {
			$sql .= ' AND `Tanggal` <= :endDate';
			$params[':endDate'] = date('Y-m-d', strtotime($endDate));
		}

		$sql .= ' ORDER BY `Tanggal` ASC';
		$command->text = $sql;
		$command->params = $params;
		$dataParent = $command->queryAll();
		$no = 1;

		/*SUM TOTAL*/
		$jumlahBarang = 0;
		$jumlahDiskon = 0;
		$jumlahGrandTotal = 0;

		foreach ($dataParent as $item) {
			// Format as price
			$priceColumns = array('I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
			foreach ($priceColumns as $col) {
				$objPHPExcel->getActiveSheet()->getStyle($col . $row)->getNumberFormat()->setFormatCode('#,##0');
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item['Kategori1']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item['Kategori2']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item['Nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item['Tanggal']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $item['Vendor']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $item['Keterangan']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $item['Satuan']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $item['Jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $item['Harga']);
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $item['Diskon']);
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $item['Harga'] + $item['Diskon']);
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $item['Harga'] / $item['Jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $row, ($item['Harga'] + $item['Diskon']) / $item['Jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $item['HargaOffline']);
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $item['HargaTokped']);

			$jumlahBarang = $jumlahBarang + $item['Jumlah'];
			$jumlahDiskon = $jumlahDiskon + $item['Diskon'];
			$jumlahGrandTotal = $jumlahGrandTotal + ($item['Harga'] + $item['Diskon']);

			$no++;
			$row++;
		}

		/*FOOTER */
		$objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':P' . $row)->applyFromArray($footerStyleArray);
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $row . ':H' . $row);
		// Format as price
		$priceColumns = array('I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
		foreach ($priceColumns as $col) {
			$objPHPExcel->getActiveSheet()->getStyle($col . $row)->getNumberFormat()->setFormatCode('#,##0');
		}

		$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $jumlahBarang);
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $jumlahDiskon);
		$objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $jumlahGrandTotal);


		//autosize width
		foreach (range('B', 'G') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		foreach (range('J', 'P') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		//static width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('List Pembelian-Stok');

		// Set active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="report_pembelian.xlsx"');
		//header('Cache-Control: max-age=0');

		// Save Excel file to output
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		Yii::app()->end();
	}

	public function actionGetData($Pembelian_ID)
	{
		$model = Pembelian::model()->findByPk($Pembelian_ID);

		$criteria = new CDbCriteria();
		$criteria->condition = 'Pembelian_ID=:Pembelian_ID';
		$criteria->params = array(':Pembelian_ID' => $Pembelian_ID);
		$mPembelianDetail = Pembeliandetail::model()->findAll($criteria);

		if ($model !== null) {
			$this->renderPartial('_dataTable', array(
				'model' => $model,
				'mPembelianDetail' => $mPembelianDetail,
			), false, true);
		} else {
			echo '<p>Data not found.</p>';
		}
	}

	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionUpdateSessionPembelianDetails()
	{
		if (isset($_POST['pembelianDetails'])) {
			Yii::app()->session['pembelianDetails'] = json_decode($_POST['pembelianDetails'], true);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No data provided']);
		}
	}

	public function actionCreate()
	{
		$model = new Pembelian;
		$pembelianDetail = new PembelianDetail;

		$model->Tanggal = date('Y-m-d');
		$model->Created = (new DateTime())->format('Y-m-d H:i:s');
		$model->UserCreated_ID = Yii::app()->user->id;

		$formattedDate = date('Ymd');

		$lastId = Pembelian::model()->find(array(
			'condition' => 'Pembelian_ID LIKE :id',
			'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-b-' . $formattedDate . '-%'),
			'order' => 'Pembelian_ID DESC'
		));

		if ($lastId) {
			$firstDashPos = strpos($lastId->Pembelian_ID, '-'); // Position of the first dash
			$secondDashPos = strpos($lastId->Pembelian_ID, '-', $firstDashPos + 1); // Position of the second dash
			$thirdDashPos = strpos($lastId->Pembelian_ID, '-', $secondDashPos + 1); // Position of the third dash

			// Extract components
			$prefix = substr($lastId->Pembelian_ID, 0, $firstDashPos); // '1'
			$formattedDate = substr($lastId->Pembelian_ID, $firstDashPos + 1, $secondDashPos - $firstDashPos - 1); // 'b'
			$date = substr($lastId->Pembelian_ID, $secondDashPos + 1, $thirdDashPos - $secondDashPos - 1); // '20241006'
			$number = substr($lastId->Pembelian_ID, $thirdDashPos + 1); // '00001'

			$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);

			$id = $prefix . '-' . $formattedDate . '-' . $date . '-' . $incrementedNumber;
		} else {
			$id = Yii::app()->user->getState('Kode_Cabang') . "-b-" . $formattedDate . "-00001";
		}

		$barangList = CHtml::listData(
			MasterBarang::model()->findAll(
				array('condition' => 'StatusAktif=:status', 'params' => array(':status' => 1))
			),
			'MasterBarang_ID',
			'Nama'
		);

		if (!isset(Yii::app()->session['pembelianDetails'])) {
			Yii::app()->session['pembelianDetails'] = [];
		}

		if (isset($_POST['Pembelian'])) {
			$model->attributes = $_POST['Pembelian'];

			$model->Pembelian_ID = $id;

			if (empty(Yii::app()->session['pembelianDetails'])) {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DETAIL_EMPTY']);
				$this->redirect(array('create'));
			}

			$transaction = Yii::app()->db->beginTransaction();

			try {
				if ($model->save()) {

					$minout = new Minout;
					$minout->Tanggal = $model->Tanggal;
					$minout->Modul_ID = $model->Pembelian_ID;
					$minout->Modul	= "PEMBELIAN";
					$minout->save();

					if (isset(Yii::app()->session['pembelianDetails'])) {
						foreach (Yii::app()->session['pembelianDetails'] as $detail) {
							$jumlah = str_replace('.', '', $detail['jumlah']);
							$harga = str_replace('.', '', $detail['harga']);

							//$mSatuan = Satuan::model()->findByPk($pembelianDetail->Satuan_ID);
							$mSatuan = Satuan::model()->findByPk($detail['satuanID']);
							$total = $mSatuan->Jumlah * $jumlah;

							$mBarang = new Barang;
							$mBarang->MasterBarang_ID = $detail['barangID'];
							$mBarang->Jumlah = $total;
							$mBarang->StatusAktif = 1;
							$mBarang->Created = date('Y-m-d H:i:s');
							$mBarang->UserCreated_ID = Yii::app()->user->id;

							if (!$mBarang->save()) {
								throw new Exception('Error saving pembelian detail.');
							}

							$pembelianDetailModel = new PembelianDetail;
							$pembelianDetailModel->Pembelian_ID = $id;
							$pembelianDetailModel->Barang_ID = $mBarang->Barang_ID;
							$pembelianDetailModel->Satuan_ID = $detail['satuanID'];
							$pembelianDetailModel->Jumlah = $jumlah;
							$pembelianDetailModel->Harga = $harga;
							$pembelianDetailModel->Diskon = $detail['diskon'];
							$pembelianDetailModel->Expired = $detail['expired'];
							$pembelianDetailModel->HargaOffline = $mSatuan->HargaOffline;
							$pembelianDetailModel->HargaTokped = $mSatuan->HargaTokped;

							if (!$pembelianDetailModel->save()) {
								throw new Exception('Error saving pembelian detail.');
							}

							$minoutline = new Minoutline();
							$minoutline->Barang_ID = $detail['barangID'];
							$minoutline->Minout_ID = $minout->Minout_ID;
							$minoutline->Jumlah = $jumlah;
							$minoutline->Satuan_ID = $detail['satuanID'];
							$minoutline->Harga = $harga;
							$minoutline->Diskon = $detail['diskon'];
							$minoutline->Expired = $detail['expired'];

							if (!$minoutline->save()) {
								throw new Exception('Error saving minoutline.');
							}
						}

						Yii::app()->session['pembelianDetails'] = null;
					}

					$transaction->commit();

					Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
					$this->redirect(array('pembelian/index', 'pagePembelian' => 'pembelian'));
				} else {
					throw new Exception('Error saving pembelian.');
				}
			} catch (Exception $e) {
				$transaction->rollback();
				echo "Failed to complete the transaction: " . $e->getMessage();
				Yii::app()->user->setFlash('error', 'Error occurred while saving.');
			}
		}

		$this->render('create', array(
			'model' => $model,
			'pembelianDetail' => $pembelianDetail,
			'barangList' => $barangList,
		));
	}


	// public function actionCreateBACKUP()
	// {
	// 	//unset($_SESSION['pembelianDetails']);
	// 	$model = new Pembelian;
	// 	$model->Tanggal = date('Y-m-d');
	// 	$model->Created = (new DateTime())->format('Y-m-d H:i:s');
	// 	$model->UserCreated_ID = date('Y-m-d');

	// 	$modelPembelianDetail = new PembelianDetail;

	// 	$formattedDate = date('Ymd');

	// 	$lastId = Pembelian::model()->find(array(
	// 		'condition' => 'Pembelian_ID LIKE :id',
	// 		'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-b-' . $formattedDate . '-%'),
	// 		'order' => 'Pembelian_ID DESC'
	// 	));

	// 	if ($lastId) {
	// 		$firstDashPos = strpos($lastId->Pembelian_ID, '-'); // Position of the first dash
	// 		$secondDashPos = strpos($lastId->Pembelian_ID, '-', $firstDashPos + 1); // Position of the second dash
	// 		$thirdDashPos = strpos($lastId->Pembelian_ID, '-', $secondDashPos + 1); // Position of the third dash

	// 		// Extract components
	// 		$prefix = substr($lastId->Pembelian_ID, 0, $firstDashPos); // '1'
	// 		$formattedDate = substr($lastId->Pembelian_ID, $firstDashPos + 1, $secondDashPos - $firstDashPos - 1); // 'b'
	// 		$date = substr($lastId->Pembelian_ID, $secondDashPos + 1, $thirdDashPos - $secondDashPos - 1); // '20241006'
	// 		$number = substr($lastId->Pembelian_ID, $thirdDashPos + 1); // '00001'

	// 		$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);

	// 		$id = $prefix . '-' . $formattedDate . '-' . $date . '-' . $incrementedNumber;
	// 	} else {
	// 		$id = Yii::app()->user->getState('Kode_Cabang') . "-b-" . $formattedDate . "-00001";
	// 	}


	// 	if (!isset($_SESSION['pembelianDetails'])) {
	// 		$_SESSION['pembelianDetails'] = [];
	// 	}

	// 	$barangList = CHtml::listData(MasterBarang::model()->findAll(), 'MasterBarang_ID', 'Nama');

	// 	if (isset($_POST['Pembelian'])) {
	// 		$model->attributes = $_POST['Pembelian'];

	// 		if (isset($_POST['PembelianDetail'])) {
	// 			$_SESSION['pembelianDetails'] = $_POST['PembelianDetail'];

	// 			// Validasi detail
	// 			$valid = true;
	// 			foreach ($_SESSION['pembelianDetails'] as $detail) {
	// 				$pembelianDetail = new PembelianDetail();
	// 				$pembelianDetail->attributes = $detail;

	// 				if (!$pembelianDetail->validate()) {
	// 					$valid = false;
	// 					$model->addErrors($pembelianDetail->getErrors());
	// 				}
	// 			}

	// 			if ($valid && $model->save()) {

	// 				foreach ($_SESSION['pembelianDetails'] as $detail) {
	// 					$pembelianDetail = new PembelianDetail();
	// 					$pembelianDetail->attributes = $detail;

	// 					//cari satuan untuk total barang
	// 					$mSatuan = Satuan::model()->findByPk($pembelianDetail->Satuan_ID);
	// 					$total = $mSatuan->Jumlah * $pembelianDetail->Jumlah;

	// 					$barang = new Barang();
	// 					$barang->MasterBarang_ID = $pembelianDetail->Barang_ID;
	// 					$barang->Jumlah = $total;
	// 					$barang->StatusAktif = 1;
	// 					$barang->Created = date('Y-m-d H:i:s');
	// 					$barang->UserCreated_ID = Yii::app()->user->id;
	// 					$barang->save();

	// 					$pembelianDetail->Barang_ID = $barang->Barang_ID;
	// 					$pembelianDetail->Pembelian_ID = $model->Pembelian_ID;
	// 					$pembelianDetail->save();	
	// 				}

	// 				unset($_SESSION['pembelianDetails']);

	// 				Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
	// 				$this->redirect(array('index'));
	// 			}
	// 		}
	// 	}

	// 	$details = isset($_SESSION['pembelianDetails']) ? $_SESSION['pembelianDetails'] : [];

	// 	$this->render('create', array(
	// 		'model' => $model,
	// 		'modelPembelianDetail' => $modelPembelianDetail,
	// 		'id' => $id,
	// 		'details' => $details,
	// 		'barangList' => $barangList,
	// 	));
	// }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Pembelian'])) {
			$model->attributes = $_POST['Pembelian'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->Pembelian_ID));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($pagePembelian)
	{
		unset($_SESSION['pembelianDetails']);

		$model = new Pembelian('search');

		if (isset($_GET['Pembelian'])) {
			$model->attributes = $_GET['Pembelian'];
		}

		$dataProvider = $model->search();

		$this->render('index', array(
			'model' => $model,
			'dataProvider' => $dataProvider,
			'pagePembelian' => $pagePembelian
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Pembelian('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Pembelian']))
			$model->attributes = $_GET['Pembelian'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pembelian the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Pembelian::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pembelian $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'pembelian-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
