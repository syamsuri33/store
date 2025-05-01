<?php

class PenjualanController extends Controller
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
				'actions' => array('create', 'update', 'updateSessionPenjualanDetails', 'exportToExcel', 'getData'),
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
			->setCellValue('E1', 'PRODUCT NAME - NOTA')
			->setCellValue('F1', 'Satuan')
			->setCellValue('G1', 'PRICELIST')
			->setCellValue('G2', 'OFFLINE')
			->setCellValue('H2', 'TOPED')
			->setCellValue('I1', 'ITEM SOLD')
			->setCellValue('I2', 'OFFLINE')
			->setCellValue('J2', 'TOPED')
			->setCellValue('K1', 'TOTAL PENJUALAN')
			->setCellValue('K2', 'OFFLINE')
			->setCellValue('L2', 'TOPED');

		$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
		$objPHPExcel->getActiveSheet()->mergeCells('D1:D2');
		$objPHPExcel->getActiveSheet()->mergeCells('E1:E2');
		$objPHPExcel->getActiveSheet()->mergeCells('F1:F2');
		$objPHPExcel->getActiveSheet()->mergeCells('G1:H1');
		$objPHPExcel->getActiveSheet()->mergeCells('I1:J1');
		$objPHPExcel->getActiveSheet()->mergeCells('K1:L1');

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

		$objPHPExcel->getActiveSheet()->getStyle('A1:L2')->applyFromArray($headerStyleArray);

		//start
		$row = 3;

		$command = Yii::app()->db->createCommand();
		// $sql = "select k2.Kategori as Kategori1, k.Kategori as Kategori2, mb.Nama, p.Tanggal, 
		// 		v.Vendor, mb.Keterangan, s.Satuan, s.Jumlah * pd.Jumlah as Jumlah, pd.Harga, mb.HargaOffline, mb.HargaTokped, pd.Penjualan_Dari,
		// 		SUM(CASE WHEN pd.Penjualan_Dari = 'OFFLINE' THEN s.Jumlah * pd.Jumlah ELSE 0 END) AS OFFLINE, 
		// 		SUM(CASE WHEN pd.Penjualan_Dari = 'TOKOPEDIA' THEN s.Jumlah * pd.Jumlah ELSE 0 END) AS TOKOPEDIA 
		// 		from penjualandetail pd
		// 		left join penjualan p on p.Penjualan_ID = pd.Penjualan_ID
		// 		left join barang b on b.Barang_ID = pd.Barang_ID
		// 		left join masterbarang mb on mb.MasterBarang_ID = b.MasterBarang_ID
		// 		left join kategori k on k.Kategori_ID = mb.Kategori_ID
		// 		left join kategori k2 on k2.Kategori_ID = k.Parent
		// 		left join vendor v on v.Vendor_ID = mb.Vendor_ID
		// 		left join satuan s on s.Satuan_ID = pd.Satuan_ID
		// 		where p.Penjualan_ID is not null and p.StatusAktif = 1 
		// 		";
		$sql = "select k2.Kategori as Kategori1, k.Kategori as Kategori2, mb.Nama, p.Tanggal, 
				v.Vendor, mb.Keterangan, s.Satuan, s.Jumlah * pd.Jumlah as Jumlah, pd.Harga, 
				pd.HargaOffline as HargaOffline,
				pd.HargaTokped as HargaTokped, 
				pd.Penjualan_Dari,
				SUM(CASE WHEN pd.Penjualan_Dari = 'OFFLINE' THEN pd.Jumlah ELSE 0 END) AS OFFLINE, 
				SUM(CASE WHEN pd.Penjualan_Dari = 'TOKOPEDIA' THEN s.Jumlah * pd.Jumlah ELSE 0 END) AS TOKOPEDIA 
				from penjualandetail pd
				left join penjualan p on p.Penjualan_ID = pd.Penjualan_ID
				left join masterbarang mb on mb.MasterBarang_ID = pd.MasterBarang_ID
				left join kategori k on k.Kategori_ID = mb.Kategori_ID
				left join kategori k2 on k2.Kategori_ID = k.Parent
				left join vendor v on v.Vendor_ID = mb.Vendor_ID
				left join satuan s on s.Satuan_ID = pd.Satuan_ID
				where p.Penjualan_ID is not null and p.StatusAktif = 1 
				";
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

		$sql .= ' GROUP BY mb.Nama, pd.HargaOffline, pd.HargaTokped ORDER BY `Tanggal` ASC';
		$command->text = $sql;
		$command->params = $params;
		$dataParent = $command->queryAll();
		$no = 1;

		/*SUM TOTAL*/
		$penjualanBarangOffline = 0;
		$penjualanBarangToped = 0;
		$penjualanTotalOffline = 0;
		$penjualanTotalToped = 0;

		foreach ($dataParent as $item) {
			// Format as price
			$priceColumns = array('G', 'H', 'I', 'J', 'K', 'L');
			foreach ($priceColumns as $col) {
				$objPHPExcel->getActiveSheet()->getStyle($col . $row)->getNumberFormat()->setFormatCode('#,##0');
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item['Kategori1']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item['Kategori2']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item['Nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item['Keterangan']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $item['Satuan']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $item['HargaOffline']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $item['HargaTokped']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $item['OFFLINE']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $item['TOKOPEDIA']);
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $item['HargaOffline'] * $item['OFFLINE']);
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $item['HargaTokped'] * $item['TOKOPEDIA']);

			$penjualanBarangOffline	= $penjualanBarangOffline + $item['OFFLINE'];
			$penjualanBarangToped 	= $penjualanBarangToped + $item['TOKOPEDIA'];
			$penjualanTotalOffline 	= $penjualanTotalOffline + ($item['HargaOffline'] * $item['OFFLINE']);
			$penjualanTotalToped 	= $penjualanTotalToped + ($item['HargaTokped'] * $item['TOKOPEDIA']);

			$no++;
			$row++;
		}

		/*FOOTER */
		$objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':L' . $row)->applyFromArray($footerStyleArray);
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $row . ':H' . $row);
		// Format as price
		$priceColumns = array('G', 'H', 'I', 'J', 'K', 'L');
		foreach ($priceColumns as $col) {
			$objPHPExcel->getActiveSheet()->getStyle($col . $row)->getNumberFormat()->setFormatCode('#,##0');
		}

		$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $penjualanBarangOffline);
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $penjualanBarangToped);
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $penjualanTotalOffline);
		$objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $penjualanTotalToped);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('List Pembelian-Stok');

		// Set active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="report_penjualan.xlsx"');
		//header('Cache-Control: max-age=0');

		// Save Excel file to output
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		Yii::app()->end();
	}

	public function actionGetData($Penjualan_ID)
	{
		$model = Penjualan::model()->findByPk($Penjualan_ID);

		$criteria = new CDbCriteria();
		$criteria->condition = 'Penjualan_ID=:Penjualan_ID';
		$criteria->params = array(':Penjualan_ID' => $Penjualan_ID);
		$mPenjualanDetail = Penjualandetail::model()->findAll($criteria);

		if ($model !== null) {
			$this->renderPartial('_dataTable', array(
				'model' => $model,
				'mPenjualanDetail' => $mPenjualanDetail,
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

	public function actionUpdateSessionPenjualanDetails()
	{
		if (isset($_POST['penjualanDetails'])) {
			$penjualanDetails = json_decode($_POST['penjualanDetails'], true);
			$condition = false;
			$indexToRemove = 0;
			$stok = 0;
			$totalSatuan = 0;
			$previousBarangID = null;


			if (is_array($penjualanDetails)) {
				// Sort penjualanDetails by barangID in ascending order
				usort($penjualanDetails, function ($a, $b) {
					return strcmp($a['barangID'], $b['barangID']);
				});

				foreach ($penjualanDetails as $detail) {
					// Reset totalSatuan if barangID changes
					if ($detail['barangID'] !== $previousBarangID) {
						$totalSatuan = 0;
						$previousBarangID = $detail['barangID'];
					}


					$mSatuan = Satuan::model()->findByPk($detail['satuanID']);
					$totalSatuan += $mSatuan->Jumlah * $detail['jumlah'];
					$totalbarang = Totalbarang::model()->findByAttributes(array('MasterBarang_ID' => $detail['barangID']));

					if ($totalbarang && $totalSatuan > $totalbarang->TotalJumlah) {
						$condition = true;
						$stok = $totalbarang->TotalJumlah;
						break;
					}
					$indexToRemove++;
				}
			}

			if ($condition) {
				//remove array penjualanDetails ada 2(splice). yg satunya di _form
				Yii::app()->session['penjualanDetails'] = array_splice($penjualanDetails, $indexToRemove, 1);
				Yii::app()->user->setFlash('error', "Jumlah Stok hanya: " . $stok);
				echo json_encode(['status' => 'error', 'message' => "Jumlah Stok hanya: " . $stok]);
			} else {
				Yii::app()->session['penjualanDetails'] = $penjualanDetails;
				echo json_encode(['status' => 'success']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No data provided']);
		}
		Yii::app()->end();
	}

	public function actionCreate()
	{
		$model = new Penjualan;
		$penjualanDetail = new PenjualanDetail;

		$model->Tanggal = date('Y-m-d');
		$model->Created = (new DateTime())->format('Y-m-d H:i:s');
		$model->UserCreated_ID = Yii::app()->user->id;
		$model->StatusAktif = 1;

		$formattedDate = date('Ymd');

		$lastId = Penjualan::model()->find(array(
			'condition' => 'Penjualan_ID LIKE :id',
			'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-j-' . $formattedDate . '-%'),
			'order' => 'Penjualan_ID DESC'
		));

		if ($lastId) {
			$firstDashPos = strpos($lastId->Penjualan_ID, '-');
			$secondDashPos = strpos($lastId->Penjualan_ID, '-', $firstDashPos + 1);
			$thirdDashPos = strpos($lastId->Penjualan_ID, '-', $secondDashPos + 1);

			$prefix = substr($lastId->Penjualan_ID, 0, $firstDashPos); // '1'
			$formattedDate = substr($lastId->Penjualan_ID, $firstDashPos + 1, $secondDashPos - $firstDashPos - 1); // 'b'
			$date = substr($lastId->Penjualan_ID, $secondDashPos + 1, $thirdDashPos - $secondDashPos - 1); // '20241006'
			$number = substr($lastId->Penjualan_ID, $thirdDashPos + 1); // '00001'

			$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);

			$id = $prefix . '-' . $formattedDate . '-' . $date . '-' . $incrementedNumber;
		} else {
			$id = Yii::app()->user->getState('Kode_Cabang') . "-j-" . $formattedDate . "-00001";
		}

		$barangList = CHtml::listData(
			MasterBarang::model()->findAll(
				array(
					'condition' => 'StatusAktif=:status',
					'params' => array(':status' => 1),
					'order' => 'Nama ASC'
				)
			),
			'MasterBarang_ID',
			'Nama'
		);

		$customerList = CHtml::listData(
			Customer::model()->findAll(
				array(
					'condition' => 'Status=:status',
					'params' => array(':status' => 1),
					'order' => 'Nama ASC'
				)
			),
			'Customer_ID',
			'Nama'
		);

		if (!isset(Yii::app()->session['penjualanDetails'])) {
			Yii::app()->session['penjualanDetails'] = [];
		}

		if (isset($_POST['Penjualan'])) {
			$model->attributes = $_POST['Penjualan'];

			$model->Penjualan_ID = $id;
			$model->Customer_ID = $model->Customer_ID;

			if (empty(Yii::app()->session['penjualanDetails'])) {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DETAIL_EMPTY']);
				$this->redirect(array('create'));
			}

			$transaction = Yii::app()->db->beginTransaction();

			try {
				if ($model->save()) {

					$minout = new Minout;
					$minout->Tanggal = $model->Tanggal;
					$minout->Modul_ID = $model->Penjualan_ID;
					$minout->Modul	= "PENJUALAN";
					$minout->Keterangan	= "CREATE";
					$minout->save();

					if (isset(Yii::app()->session['penjualanDetails'])) {
						//check session penjualanDetails
						// echo "<pre>";
						// print_r(Yii::app()->session['penjualanDetails']);
						// echo "</pre>";
						// exit;

						foreach (Yii::app()->session['penjualanDetails'] as $detail) {
							$mSatuan = Satuan::model()->findByPk($detail['satuanID']);
							$total = $mSatuan->Jumlah * $detail['jumlah'];

							$penjualanDetailModel = new PenjualanDetail;
							$penjualanDetailModel->Penjualan_ID = $id;
							$penjualanDetailModel->MasterBarang_ID = $detail['barangID'];
							$penjualanDetailModel->Satuan_ID = $detail['satuanID'];
							$penjualanDetailModel->Jumlah = $detail['jumlah'];
							$penjualanDetailModel->Harga = $detail['harga'];
							$penjualanDetailModel->Penjualan_Dari = $detail['penjualanDari'];
							$penjualanDetailModel->HargaOffline = $mSatuan->HargaOffline;
							$penjualanDetailModel->HargaTokped = $mSatuan->HargaTokped;

							if (!$penjualanDetailModel->save()) {
								throw new Exception('Error saving penjualan detail.');
							}

							$criteria = new CDbCriteria();
							$criteria->alias = 'barang';
							$criteria->join = 'LEFT JOIN pembeliandetail pd ON pd.Barang_ID = barang.Barang_ID';
							$criteria->addCondition('barang.MasterBarang_ID = :barangID');
							$criteria->addCondition('barang.StatusAktif = 1');
							$criteria->params = array(':barangID' => $detail['barangID']);
							$criteria->order = 'pd.Expired ASC';

							$barangList = Barang::model()->findAll($criteria);

							foreach ($barangList as $mBarang) {
								if ($mBarang->Jumlah == 0) {
									continue;
								}

								if ($mBarang->Jumlah >= $total) {
									$log = new Penjualandetaillog;
									$log->Barang_ID = $mBarang->Barang_ID;
									$log->PenjualanDetail_ID = $penjualanDetailModel->PenjualanDetail_ID;
									$log->Jumlah = $total;
									$log->Jumlah_Awal = $mBarang->Jumlah;
									$log->save();

									$mBarang->Jumlah -= $total;
									$mBarang->save();

									break;
								} else {
									$log = new Penjualandetaillog;
									$log->Barang_ID = $mBarang->Barang_ID;
									$log->PenjualanDetail_ID = $penjualanDetailModel->PenjualanDetail_ID;
									$log->Jumlah = $mBarang->Jumlah;
									$log->Jumlah_Awal = $mBarang->Jumlah;
									$log->save();

									$total -= $mBarang->Jumlah;
									$mBarang->Jumlah = 0;
									$mBarang->save();
								}
							}

							$minoutline = new Minoutline();
							$minoutline->Barang_ID = $detail['barangID'];
							$minoutline->Minout_ID = $minout->Minout_ID;
							$minoutline->Jumlah = $detail['jumlah'];
							$minoutline->Satuan_ID = $detail['satuanID'];
							$minoutline->Harga = $detail['jumlah'];
							$minoutline->HargaOffline = $mSatuan->HargaOffline;
							$minoutline->HargaGrosir = $mSatuan->HargaGrosir;
							$minoutline->HargaTokped = $mSatuan->HargaTokped;

							if (!$minoutline->save()) {
								throw new Exception('Error saving minoutline.');
							}
						}

						Yii::app()->session['penjualanDetails'] = null;
					}

					$transaction->commit();

					Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
					$this->redirect(array('penjualan/index', 'pagePenjualan' => 'penjualan'));
				} else {
					throw new Exception('Error saving penjualan.');
				}
			} catch (Exception $e) {
				$transaction->rollback();
				echo "Failed to complete the transaction: " . $e->getMessage();
				Yii::app()->user->setFlash('error', 'Error occurred while saving.');
			}
		}

		$this->render('create', array(
			'model' => $model,
			'penjualanDetail' => $penjualanDetail,
			'barangList' => $barangList,
			'customerList' => $customerList,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		//echo '<script>console.log("1");</script>';
		$model = $this->loadModel($id);
		$penjualanDetail = new PenjualanDetail;
		$model->Updated = (new DateTime())->format('Y-m-d H:i:s');
		$model->UserUpdated_ID = Yii::app()->user->id;

		$barangList = CHtml::listData(
			MasterBarang::model()->findAll(
				array(
					'condition' => 'StatusAktif=:status',
					'params' => array(':status' => 1),
					'order' => 'Nama ASC'
				)
			),
			'MasterBarang_ID',
			'Nama'
		);

		$customerList = CHtml::listData(
			Customer::model()->findAll(
				array(
					'condition' => 'Status=:status',
					'params' => array(':status' => 1),
					'order' => 'Nama ASC'
				)
			),
			'Customer_ID',
			'Nama'
		);
		//echo '<script>console.log("11");</script>';
		if (!isset(Yii::app()->session['Penjualan_ID']) || Yii::app()->session['Penjualan_ID'] != $id) {
			Yii::app()->session['Penjualan_ID'] = $id;
			Yii::app()->session['penjualanDetails'] = null;
		}

		if (Yii::app()->session['penjualanDetails'] === null) {
			$penjualanDetails = Penjualandetail::model()->findAll(array(
				'condition' => 'Penjualan_ID = :id',
				'params' => array(':id' => $id)
			));
			$details = array();
			foreach ($penjualanDetails as $detail) {
				$details[] = array(
					'id' => $detail->PenjualanDetail_ID,
					'barangID' => $detail->MasterBarang_ID,
					'barangName' => $detail->masterBarang->Nama,
					'satuanID' => $detail->Satuan_ID,
					'satuanName' => $detail->satuan->Satuan,
					'jumlah' => $detail->Jumlah,
					'harga' => (int)$detail->Harga,
					'penjualanDari' => $detail->Penjualan_Dari,
				);
			}
			Yii::app()->session['penjualanDetails'] = $details;
		}
		//echo '<script>console.log("1");</script>';
		if (isset($_POST['Penjualan'])) {
			//$transaction = Yii::app()->db->beginTransaction();

			//try {
			$model->attributes = $_POST['Penjualan'];

			if (!$model->validate()) {
				throw new Exception('Validation failed for Penjualan model.');
			}

			if (empty(Yii::app()->session['penjualanDetails'])) {
				Yii::app()->session['penjualanDetails'] = null;

				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DETAIL_EMPTY']);
				$this->redirect(array('update', 'id' => $id));
			}

			// Get all existing detail IDs from database
			$existingDetails = Penjualandetail::model()->findAllByAttributes(array('Penjualan_ID' => $model->Penjualan_ID));
			$existingIds = array();
			foreach ($existingDetails as $detail) {
				$existingIds[] = $detail->PenjualanDetail_ID;
			}

			// Get IDs from request
			$requestIds = array();
			foreach (Yii::app()->session['penjualanDetails'] as $detail) {
				if (isset($detail['id'])) {
					$requestIds[] = $detail['id'];
				}
			}

			// Find IDs to delete (present in DB but not in request)
			$idsToDelete = array_diff($existingIds, $requestIds);
			// Delete records not in request
			if (!empty($idsToDelete)) {

				foreach ($idsToDelete as $id) {
					$penjualanDetailLog = Penjualandetaillog::model()->findAllByAttributes(array(
						'PenjualanDetail_ID' => $id
					));

					foreach ($penjualanDetailLog as $log) {
						$barang = Barang::model()->findByPk($log->Barang_ID);
						if ($barang) {
							$barang->Jumlah += $log->Jumlah;
							$barang->save();
						}
					}
				}

				//Delete All Penjualandetaillog
				Penjualandetaillog::model()->deleteAll('PenjualanDetail_ID IN (' . implode(',', $idsToDelete) . ')');
				// Delete All PenjualanDetail
				Penjualandetail::model()->deleteAll('PenjualanDetail_ID IN (' . implode(',', $idsToDelete) . ')');
			}

			if ($model->save()) {
				$minout = new Minout;
				$minout->Tanggal = date('Y-m-d H:i:s');
				$minout->Modul_ID = $model->Penjualan_ID;
				$minout->Modul	= "PENJUALAN";
				$minout->Keterangan	= "UPDATE";
				$minout->save();

				if (isset(Yii::app()->session['penjualanDetails'])) {
					foreach (Yii::app()->session['penjualanDetails'] as $detail) {
						$mSatuan = Satuan::model()->findByPk($detail['satuanID']);
						$total = $mSatuan->Jumlah * $detail['jumlah'];

						$penjualanDetailModel = isset($detail['id']) ? PenjualanDetail::model()->findByPk($detail['id']) : null;
						//detail new
						if ($penjualanDetailModel === null) {
							echo '<script>console.log("5");</script>';

							$penjualanDetailModel = new PenjualanDetail;
							$penjualanDetailModel->Penjualan_ID = $id;
							$penjualanDetailModel->MasterBarang_ID = $detail['barangID'];
							$penjualanDetailModel->Satuan_ID = $detail['satuanID'];
							$penjualanDetailModel->Jumlah = $detail['jumlah'];
							$penjualanDetailModel->Harga = $detail['harga'];
							$penjualanDetailModel->Penjualan_Dari = $detail['penjualanDari'];
							$penjualanDetailModel->HargaOffline = $mSatuan->HargaOffline;
							$penjualanDetailModel->HargaTokped = $mSatuan->HargaTokped;

							if (!$penjualanDetailModel->save()) {
								throw new Exception('Error saving penjualan detail.');
							}

							$criteria = new CDbCriteria();
							$criteria->alias = 'barang';
							$criteria->join = 'LEFT JOIN pembeliandetail pd ON pd.Barang_ID = barang.Barang_ID';
							$criteria->addCondition('barang.MasterBarang_ID = :barangID');
							$criteria->addCondition('barang.StatusAktif = 1');
							$criteria->params = array(':barangID' => $detail['barangID']);
							$criteria->order = 'pd.Expired ASC';

							$barangLists = Barang::model()->findAll($criteria);

							foreach ($barangLists as $mBarang) {
								echo '<script>console.log("6");</script>';
								if ($mBarang->Jumlah == 0) {
									continue;
								}

								if ($mBarang->Jumlah >= $total) {
									$log = new Penjualandetaillog;
									$log->Barang_ID = $mBarang->Barang_ID;
									$log->PenjualanDetail_ID = $penjualanDetailModel->PenjualanDetail_ID;
									$log->Jumlah = $total;
									$log->Jumlah_Awal = $mBarang->Jumlah;
									$log->save();

									$mBarang->Jumlah -= $total;
									$mBarang->save();
									break;
								} else {
									$log = new Penjualandetaillog;
									$log->Barang_ID = $mBarang->Barang_ID;
									$log->PenjualanDetail_ID = $penjualanDetailModel->PenjualanDetail_ID;
									$log->Jumlah = $mBarang->Jumlah;
									$log->Jumlah_Awal = $mBarang->Jumlah;
									$log->save();

									$total -= $mBarang->Jumlah;
									$mBarang->Jumlah = 0;
									$mBarang->save();
								}
							}

							

							$minoutline = new Minoutline();
							$minoutline->Barang_ID = $detail['barangID'];
							$minoutline->Minout_ID = $minout->Minout_ID;
							$minoutline->Jumlah = $detail['jumlah'];
							$minoutline->Satuan_ID = $detail['satuanID'];
							$minoutline->Harga = $detail['jumlah'];
							$minoutline->HargaOffline = $mSatuan->HargaOffline;
							$minoutline->HargaGrosir = $mSatuan->HargaGrosir;
							$minoutline->HargaTokped = $mSatuan->HargaTokped;

							if (!$minoutline->save()) {
								throw new Exception('Error saving minoutline.');
							}
						} else {
							//detail update

						}
					}
				}

				//$transaction->commit();

				// Yii::app()->session['penjualanDetails'] = null;
				// Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
				// $this->redirect(array('index', 'pagePenjualan' => 'penjualan'));
			}
			// } catch (Exception $e) {
			// 	$transaction->rollback();
			// 	echo "Failed to complete the transaction: " . $e->getMessage();
			// 	Yii::app()->user->setFlash('error', 'Error occurred while saving.');
			// }
		}

		$this->render('update', array(
			'model' => $model,
			'penjualanDetail' => $penjualanDetail,
			'barangList' => $barangList,
			'customerList' => $customerList,
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
	public function actionIndex($pagePenjualan)
	{
		unset($_SESSION['penjualanDetails']);

		$model = new Penjualan('search');

		if (isset($_GET['Penjualan'])) {
			$model->attributes = $_GET['Penjualan'];
		}

		$dataProvider = $model->search();

		$this->render('index', array(
			'model' => $model,
			'dataProvider' => $dataProvider,
			'pagePenjualan' => $pagePenjualan
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Penjualan('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Penjualan']))
			$model->attributes = $_GET['Penjualan'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Penjualan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Penjualan::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Penjualan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'penjualan-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
