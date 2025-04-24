<?php

class OperasionalController extends Controller
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
				'actions' => array('create', 'update', 'deletes', 'updateSessionOperasionalDetails', 'exportToExcel', 'getData'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin'),
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
			->setCellValue('A1', 'Tanggal')
			->setCellValue('B1', 'Jumlah Item')
			->setCellValue('C1', 'Item Name')
			->setCellValue('D1', 'Harga Satuan')
			->setCellValue('E1', 'Total');

		//start
		$row = 2;

		$criteria = new CDbCriteria();

		if ($startDate && $endDate) {
			$criteria->addCondition('Tanggal >= :startDate');
			$criteria->addCondition('Tanggal <= :endDate');
			$criteria->params[':startDate'] = date('Y-m-d', strtotime($startDate));
			$criteria->params[':endDate'] = date('Y-m-d', strtotime($endDate));
		} elseif ($startDate) {
			$criteria->addCondition('Tanggal >= :startDate');
			$criteria->params[':startDate'] = date('Y-m-d', strtotime($startDate));
		} elseif ($endDate) {
			$criteria->addCondition('Tanggal <= :endDate');
			$criteria->params[':endDate'] = date('Y-m-d', strtotime($endDate));
		}

		$criteria->addCondition('StatusAktif = 1');
		$criteria->order = 'Tanggal ASC';
		$dataParent = Operasional::model()->findAll($criteria);


		foreach ($dataParent as $itemParent) {
			$criteria = new CDbCriteria();
			$criteria->condition = 't.Operasional_ID = "' . $itemParent->Operasional_ID . '"';
			//$criteria->order = 'Tanggal ASC';
			$criteria->with = array(
				'operasional' => array(
					'joinType' => 'LEFT JOIN',
					'condition' => 'operasional.Operasional_ID = t.Operasional_ID',
				),
			);
			$data = Operasionaldetail::model()->findAll($criteria);

			//Populate data

			$compareDate = "";
			$subtotalJumlah = 0;
			$subtotalTotal = 0;

			foreach ($data as $item) {
				$date = new DateTime($item->operasional->Tanggal);
				$formattedDate = $date->format('d-M-y');
				if ($compareDate === $formattedDate) {
					$compareDate = $formattedDate;
					$showDate = "";
				} else {
					$compareDate = $formattedDate;
					$showDate = $formattedDate;
				}

				// Format as price 
				$objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getNumberFormat()->setFormatCode('#,##0');
				$objPHPExcel->getActiveSheet()->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
				$objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');

				// Auto-fit column width 
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

				//DATA
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $showDate);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item->Jumlah);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item->Nama);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item->Total / $item->Jumlah);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item->Total);
				$row++;

				// Add to subtotal 
				//$subtotalJumlah += $item->Jumlah;
				//$subtotalTotal += $item->Jumlah * $item->HargaSatuan;
				$subtotalJumlah += $item->Jumlah;
				$subtotalTotal += $item->Total;
			}

			// Format as price 
			$objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Subtotal');
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $subtotalJumlah);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $subtotalTotal);
			$row++;
			$row++;
		}

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('BIAYA OPS');

		// Set active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="data_export.xlsx"');
		//header('Cache-Control: max-age=0');


		// Save Excel file to output
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		Yii::app()->end();
	}

	public function actionGetData($id)
	{
		$model = Operasional::model()->findByPk($id);

		$criteria = new CDbCriteria();
		$criteria->condition = 'Operasional_ID=:Operasional_ID';
		$criteria->params = array(':Operasional_ID' => $id);
		$mOperasionaldetail = Operasionaldetail::model()->findAll($criteria);

		if ($model !== null) {
			$this->renderPartial('_dataTable', array(
				'model' => $model,
				'mOperasionaldetail' => $mOperasionaldetail,
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdateSessionOperasionalDetails()
	{
		if (isset($_POST['operasionalDetails'])) {
			Yii::app()->session['operasionalDetails'] = json_decode($_POST['operasionalDetails'], true);
			echo json_encode(['status' => 'success', 'data' => Yii::app()->session['operasionalDetails']]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No data provided']);
		}
	}

	public function actionCreate()
	{
		if (Yii::app()->session['action'] != "create") {
			Yii::app()->session['action'] = "create";
			Yii::app()->session['operasionalDetails'] = null;
		}
		//Ga bisa pake ini
		//

		$model = new Operasional;
		$mOperasionalDtl = new Operasionaldetail;

		if (isset($_POST['Operasional'])) {
			$lastId = Operasional::model()->find(array(
				'condition' => 'Operasional_ID LIKE :id',
				'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-%'),
				'order' => 'Operasional_ID DESC'
			));

			if ($lastId) {
				list($prefix, $number) = explode('-', $lastId->Operasional_ID);
				$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);
				$id = $prefix . '-' . $incrementedNumber;
			} else {
				$id = Yii::app()->user->getState('Kode_Cabang') . "-00001";
			}

			$model->attributes = $_POST['Operasional'];
			$model->Operasional_ID = $id;
			$model->StatusAktif = 1;

			if (empty($model->Tanggal)) {
				Yii::app()->user->setFlash('error', "Tanggal Tidak boleh kosong");
				$this->redirect(array('create'));
			}

			if (empty(Yii::app()->session['operasionalDetails'])) {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DETAIL_EMPTY']);
				$this->redirect(array('create'));
			}

			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($model->save()) {
					if (isset(Yii::app()->session['operasionalDetails'])) {
						foreach (Yii::app()->session['operasionalDetails'] as $detail) {
							$mOperasionalDtl = new Operasionaldetail;
							$mOperasionalDtl->Operasional_ID = $model->Operasional_ID;
							$mOperasionalDtl->Nama = $detail['nama'];
							$mOperasionalDtl->Jumlah = $detail['jumlah'];
							$mOperasionalDtl->Total = $detail['total'];

							if (!$mOperasionalDtl->save()) {
								throw new Exception('Error saving operasional detail.');
							}
						}

						Yii::app()->session['operasionalDetails'] = null;
					}

					$transaction->commit();

					Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
					$this->redirect(array('index', 'pageOperasional' => 'operasional'));
				} else {
					throw new Exception('Error saving Operasional.');
				}
			} catch (Exception $e) {
				$transaction->rollback();
				echo "Failed to complete the transaction: " . $e->getMessage();
				Yii::app()->user->setFlash('error', 'Error occurred while saving.');
			}
		}

		$this->render('create', array(
			'model' => $model,
			'mOperasionalDtl' => $mOperasionalDtl,
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

		if (!isset(Yii::app()->session['action'])) {
			Yii::app()->session['action'] = "update";
		}
		if (!isset(Yii::app()->session['Opersional_ID']) || Yii::app()->session['Opersional_ID'] != $id) {
			Yii::app()->session['Opersional_ID'] = $id;
			Yii::app()->session['operasionalDetails'] = null;
		}

		$model = $this->loadModel($id); // Load the Operasional model
		$mOperasionalDtl = new Operasionaldetail;

		if (Yii::app()->session['operasionalDetails'] === null) {
			$operasionalDetails = Operasionaldetail::model()->findAllByAttributes(array('Operasional_ID' => $model->Operasional_ID));
			$detailsArray = array();
			foreach ($operasionalDetails as $detail) {
				$detailsArray[] = array(
					'id' => $detail->OperasionalDetail_ID, // Include the ID if needed 
					'nama' => $detail->Nama,
					'jumlah' => $detail->Jumlah,
					'hargaSatuan' => $detail->Total / $detail->Jumlah,
					'total' => $detail->Total,
				);
			}
			Yii::app()->session['operasionalDetails'] = $detailsArray;
		}

		if (isset($_POST['Operasional'])) {
			echo '<script>console.log(4' . json_encode(Yii::app()->session['operasionalDetails']) . ');</script>';

			if (empty(Yii::app()->session['operasionalDetails'])) {
				//echo '<script>console.log("kosong");</script>';
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DETAIL_EMPTY']);
				$this->redirect(array('update', 'id' => $id));
			}

			// Get all existing detail IDs from database
			$existingDetails = Operasionaldetail::model()->findAllByAttributes(array('Operasional_ID' => $model->Operasional_ID));
			$existingIds = array();
			foreach ($existingDetails as $detail) {
				$existingIds[] = $detail->OperasionalDetail_ID;
			}

			// Get IDs from request
			$requestIds = array();
			foreach (Yii::app()->session['operasionalDetails'] as $detail) {
				if (isset($detail['id'])) {
					$requestIds[] = $detail['id'];
				}
			}

			// Find IDs to delete (present in DB but not in request)
			$idsToDelete = array_diff($existingIds, $requestIds);
			// Delete records not in request
			if (!empty($idsToDelete)) {
				$criteria = new CDbCriteria;
				$criteria->addInCondition('OperasionalDetail_ID', $idsToDelete);
				Operasionaldetail::model()->deleteAll($criteria);
			}

			foreach (Yii::app()->session['operasionalDetails'] as $detail) {
				if (isset($detail['id'])) {
					// Update existing detail
					$mOperasionalDtlSave = Operasionaldetail::model()->findByPk($detail['id']);
					if ($mOperasionalDtlSave) {
						echo '<script>console.log("Nama: ' . $detail['nama'] . '");</script>';
						$mOperasionalDtlSave->Nama = $detail['nama'];
						$mOperasionalDtlSave->Jumlah = $detail['jumlah'];
						$mOperasionalDtlSave->Total = $detail['total'];
						echo '<script>console.log("xxx' . $detail['id'] . '");</script>';
						if (!$mOperasionalDtlSave->save()) {
							throw new Exception('Error updating operasional detail.');
						}
					}
				} else {
					// 	// Create new detail
					$mOperasionalDtl = new Operasionaldetail;
					$mOperasionalDtl->Operasional_ID = $model->Operasional_ID;
					$mOperasionalDtl->Nama = $detail['nama'];
					$mOperasionalDtl->Jumlah = $detail['jumlah'];
					$mOperasionalDtl->Total = $detail['total'];
					if (!$mOperasionalDtl->save()) {
						throw new Exception('Error saving operasional detail.');
					}
				}
			}
			Yii::app()->session['operasionalDetails'] = null;
			Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
			$this->redirect(array('index', 'pageOperasional' => 'operasional'));
		}

		$this->render('update', array(
			'model' => $model,
			'mOperasionalDtl' => $mOperasionalDtl,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletes($id)
	{
		$model = Operasional::model()->findByPk($id);
		$model->StatusAktif = 0;

		if ($model->save()) {
			Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_DELETE_SUCCESS']);
			$this->redirect(array('index', 'pageOperasional' => 'operasional'));
		} else {
			Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DELETE_FAILED']);
			$this->redirect(array('index', 'pageOperasional' => 'operasional'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($pageOperasional)
	{

		$model = new Operasional('search');


		Yii::app()->session['Opersional_ID'] = null;
		Yii::app()->session['operasionalDetails'] = null;

		if (isset($_GET['Operasional'])) {
			$model->attributes = $_GET['Operasional'];
		}

		$dataProvider = $model->search();

		$this->render('index', array(
			'model' => $model,
			'dataProvider' => $dataProvider,
			'pageOperasional' => $pageOperasional
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Operasional('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Operasional']))
			$model->attributes = $_GET['Operasional'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Operasional the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Operasional::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Operasional $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'operasional-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
