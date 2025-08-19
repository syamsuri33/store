<?php

class ReturController extends Controller
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
        'actions' => array('create', 'update', 'getData', 'loadSelectedItems', 'saveSelectedItems', 'exportToExcel'),
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
      ->setCellValue('A1', 'Tanggal')
      ->setCellValue('B1', 'Tipe')
      ->setCellValue('C1', 'Nama Barang')
      ->setCellValue('D1', 'Jumlah')
      ->setCellValue('E1', 'Satuan');

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

    $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($headerStyleArray);

    //start
    $row = 2;

    $command = Yii::app()->db->createCommand();
    $sql = "SELECT r.Tanggal, r.TipeRetur, mb.Nama, rd.Jumlah, s.Satuan
            FROM retur r
            JOIN returdetail rd ON rd.Retur_ID = r.Retur_ID
            LEFT JOIN pembeliandetail pd ON r.TipeRetur = 'pembelian' AND pd.PembelianDetail_ID = rd.ModulDetail_ID
            LEFT JOIN penjualandetail pj ON r.TipeRetur = 'penjualan' AND pj.PenjualanDetail_ID = rd.ModulDetail_ID
            LEFT JOIN barang b ON b.Barang_ID = rd.Barang_ID
            LEFT JOIN masterbarang mb ON mb.MasterBarang_ID = b.MasterBarang_ID 
            LEFT JOIN satuan s ON s.Satuan_ID = rd.Satuan_ID
            where r.Retur_ID is not null 
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

    $sql .= ' ORDER BY r.Tanggal ASC, r.TipeRetur ASC';
    $command->text = $sql;
    $command->params = $params;
    $dataParent = $command->queryAll();
    $no = 1;

    $prevTanggal = '';
    $prevTipe = '';

    foreach ($dataParent as $item) {
      $tanggal = $item['Tanggal'];
      $tipe = $item['TipeRetur'];

      $cellTanggal = ($tanggal != $prevTanggal) ? $tanggal : '';
      $cellTipe = ($tanggal != $prevTanggal || $tipe != $prevTipe) ? $tipe : '';

      $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $cellTanggal);
      $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $cellTipe);
      $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item['Nama']);
      $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item['Jumlah']);
      $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item['Satuan']);

      $prevTanggal = $tanggal;
      $prevTipe = $tipe;
      $row++;
    }

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Report Retur');

    // Set active sheet index to the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="report_retur.xlsx"');
    //header('Cache-Control: max-age=0');

    // Save Excel file to output
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    Yii::app()->end();
  }


  public function actionSaveSelectedItems()
  {
    $items = json_decode($_POST['items'], true);
    Yii::app()->session['selectedItems'] = $items;
    var_dump($items);
    echo 'OK';
  }

  public function actionLoadSelectedItems()
  {
    $selectedItems = isset(Yii::app()->session['selectedItems']) ?
      Yii::app()->session['selectedItems'] : array();

    $html = '';
    if (!empty($selectedItems)) {
      $html .= '<table class="table table-bordered"><thead><tr class="bg-info">';
      $html .= '<th>Nama Barang</th><th>Jumlah</th><th>Satuan</th>';
      $html .= '<th>HargaOffline</th><th>HargaGrosir</th><th>HargaTokped</th><th>Alasan</th>';
      $html .= '</tr></thead><tbody>';

      foreach ($selectedItems as $index => $item) {
        $html .= '<tr>';
        $html .= '<td>' . CHtml::encode($item['Nama']) . '</td>';
        $html .= '<td><input type="number" name="selectedItems[' . $index . '][Jumlah]" value="' . $item['Jumlah'] . '" min="0" class="form-control"></td>';
        $html .= '<td>' . CHtml::encode($item['SatuanNama']) . '</td>';
        $html .= '<td>' . CHtml::encode($item['HargaOffline']) . '</td>';
        $html .= '<td>' . CHtml::encode($item['HargaGrosir']) . '</td>';
        $html .= '<td>' . CHtml::encode($item['HargaTokped']) . '</td>';
        $html .= '<td><input type="text" name="selectedItems[' . $index . '][Alasan]" class="form-control"></td>';
        $html .= '</tr>';

        // Hidden fields
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][PembelianDetail_ID]', $item['PembelianDetail_ID']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][Barang_ID]', $item['Barang_ID']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][Nama]', $item['Nama']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][SatuanNama]', $item['SatuanNama']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][Harga]', $item['Harga']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][HargaOffline]', $item['HargaOffline']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][HargaGrosir]', $item['HargaGrosir']);
        $html .= CHtml::hiddenField('selectedItems[' . $index . '][HargaTokped]', $item['HargaTokped']);
        $html .= CHtml::textField('selectedItems[' . $index . '][Satuan_ID]', $item['Satuan_ID']);
        $html .= CHtml::textField('selectedItems[' . $index . '][Penjualan_Dari]', $item['Penjualan_Dari']);
      }

      $html .= '</tbody></table>';
    }

    echo $html;
    Yii::app()->end();
  }

  public function actionGetData($TipeRetur)
  {
    if (isset($TipeRetur)) {
      $session = Yii::app()->session;
      $selectedItems = isset($session['selectedItems']) ? $session['selectedItems'] : array();

      Yii::app()->session['TipeRetur'] = $TipeRetur;


      $criteria = new CDbCriteria();
      $criteria->alias = 'pd';
      if ($TipeRetur == "PEMBELIAN") {
        $criteria->join = 'INNER JOIN pembelian p ON p.Pembelian_ID = pd.Pembelian_ID';
        $criteria->condition = 'pd.StatusAktif=:StatusAktif AND p.StatusAktif=:StatusAktif';
        $criteria->params = array(':StatusAktif' => 1);
      } else if ($TipeRetur == "PENJUALAN") {
        $criteria->join = 'INNER JOIN penjualan p ON p.Penjualan_ID = pd.Penjualan_ID';
      }

      if (
        isset($_GET['startDate']) && isset($_GET['endDate']) &&
        !empty($_GET['startDate']) && !empty($_GET['endDate'])
      ) {
        $criteria->addCondition('p.Tanggal >= :startDate AND p.Tanggal <= :endDate');
        $criteria->params[':startDate'] = $_GET['startDate'];
        $criteria->params[':endDate'] = $_GET['endDate'];
      }

      if ($TipeRetur == "PEMBELIAN") {
        $model = PembelianDetail::model()->findAll($criteria);
      } else if ($TipeRetur == "PENJUALAN") {
        $model = PenjualanDetail::model()->findAll($criteria);
      }

      $this->renderPartial('_dataTable', array(
        'model' => $model,
        'TipeRetur' => $TipeRetur,
        'selectedItems' => $selectedItems
      ), false, true);
    }
  }



  public function actionView($Retur_ID)
  {
    $model = $this->loadModel($Retur_ID);
    if ($model !== null) {
      $this->renderPartial('view', array(
        'model' => $model,
      ), false, true);
    } else {
      echo '<p>Data not found.</p>';
    }
  }

  public function actionCheckStok($Type, $Barang_ID, $total)
  {
    //$Barang_ID klo di penjualan jadi penjualanDetail_ID buat get di penjualandetailLog
    echo '<script>console.log("aaaa");</script>';
    if ($Type === "PEMBELIAN") {
      $mBarang = Barang::model()->findByPk($Barang_ID);

      if ($total > $mBarang->Jumlah) {
        return "Jumlah stok hanya " . $mBarang->Jumlah;
      } else {
        return true;
      }
    } else if ($Type === "PENJUALAN") {
      $mPenjualandetail = Penjualandetail::model()->findByPk($Barang_ID);
      $mSatuan = Satuan::model()->findByPk($mPenjualandetail->Satuan_ID);
      $totalStok = $mSatuan->Jumlah * $mPenjualandetail->Jumlah;
      if ($total > $totalStok) {
        return "Jumlah stok hanya " . $totalStok;
      } else {
        return true;
      }
    }
  }

  public function actionCreate()
  {
    $model = new Retur;

    if (Yii::app()->session['TipeRetur']) {
      $model->TipeRetur = Yii::app()->session['TipeRetur'];
    }

    $model->Tanggal = date('Y-m-d');
    $model->Created = (new DateTime())->format('Y-m-d H:i:s');
    $model->UserCreated_ID = Yii::app()->user->id;
    $model->StatusAktif = 1;

    $formattedDate = date('Ymd');

    $lastId = Retur::model()->find(array(
      'condition' => 'Retur_ID LIKE :id',
      'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-r-' . $formattedDate . '-%'),
      'order' => 'Retur_ID DESC'
    ));

    if ($lastId) {
      $firstDashPos = strpos($lastId->Retur_ID, '-');
      $secondDashPos = strpos($lastId->Retur_ID, '-', $firstDashPos + 1);
      $thirdDashPos = strpos($lastId->Retur_ID, '-', $secondDashPos + 1);

      $prefix = substr($lastId->Retur_ID, 0, $firstDashPos); // '1'
      $formattedDate = substr($lastId->Retur_ID, $firstDashPos + 1, $secondDashPos - $firstDashPos - 1); // 'b'
      $date = substr($lastId->Retur_ID, $secondDashPos + 1, $thirdDashPos - $secondDashPos - 1); // '20241006'
      $number = substr($lastId->Retur_ID, $thirdDashPos + 1); // '00001'

      $incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);

      $id = $prefix . '-' . $formattedDate . '-' . $date . '-' . $incrementedNumber;
    } else {
      $id = Yii::app()->user->getState('Kode_Cabang') . "-r-" . $formattedDate . "-00001";
    }

    $selectedItems = array();

    // Load selected items from session
    $session = Yii::app()->session;
    if (isset($session['selectedItems'])) {
      $selectedItems = $session['selectedItems'];
    }

    if (isset($_POST['Retur'])) {
      echo '<script>console.log(' . json_encode($_POST['Retur']) . ');</script>';

      $model->attributes = $_POST['Retur'];
      $model->Retur_ID = $id;
      if (isset(Yii::app()->session['TipeRetur'])) {
        $model->TipeRetur = Yii::app()->session['TipeRetur'];
      }


      // Process selected items
      if (isset($_POST['selectedItems'])) {
        echo '<script>console.log("aaaa");</script>';

        $selectedItems = array();
        foreach ($_POST['selectedItems'] as $item) {
          $selectedItems[] = array(
            'PembelianDetail_ID' => $item['PembelianDetail_ID'],
            'Barang_ID' => $item['Barang_ID'],
            'Nama' => $item['Nama'],
            'Jumlah' => $item['Jumlah'],
            'SatuanNama' => $item['SatuanNama'],
            'Harga' => $item['Harga'],
            'HargaOffline' => $item['HargaOffline'],
            'HargaGrosir' => $item['HargaGrosir'],
            'HargaTokped' => $item['HargaTokped'],
            'Alasan' => $item['Alasan'],
            'Satuan_ID' => $item['Satuan_ID'],
            'Penjualan_Dari' => $item['Penjualan_Dari'],
          );
        }
        // Save to session
        $session['selectedItems'] = $selectedItems;
      }

      $transaction = Yii::app()->db->beginTransaction();


      try {
        if ($model->save()) {

          $minout = new Minout;
          $minout->Tanggal = $model->Tanggal;
          $minout->Modul_ID = $model->Retur_ID;
          $minout->Modul  = "RETUR " . $model->TipeRetur;
          $minout->Keterangan  = "CREATE";
          $minout->save();

          foreach (Yii::app()->session['selectedItems'] as $detail) {
            $mSatuan = Satuan::model()->findByPk($detail['Satuan_ID']);
            $total = $mSatuan->Jumlah * $detail['Jumlah'];

            if ($model->TipeRetur === "PEMBELIAN") {
              $stokCheck = $this->actionCheckStok($model->TipeRetur, $detail['Barang_ID'], $total);
            } else {
              $stokCheck = $this->actionCheckStok($model->TipeRetur, $detail['PembelianDetail_ID'], $total);
            }

            if ($stokCheck !== true) {
              Yii::app()->session['TipeRetur'] = $model->TipeRetur;
              Yii::app()->user->setFlash('error', $stokCheck); // Display warning message
              $this->redirect(array('retur/create')); // Redirect to prevent further processing
              return;
            }

            $returDetail = new Returdetail();
            $returDetail->Barang_ID = $detail['Barang_ID'];
            $returDetail->Retur_ID = $model->Retur_ID;
            $returDetail->Jumlah = $detail['Jumlah'];
            $returDetail->Satuan_ID = $detail['Satuan_ID'];
            $returDetail->Harga = $detail['Harga'];
            $returDetail->HargaOffline = $detail['HargaOffline'];
            $returDetail->HargaGrosir = $detail['HargaGrosir'];
            $returDetail->HargaTokped = $detail['HargaTokped'];
            $returDetail->ModulDetail_ID = $detail['PembelianDetail_ID'];
            $returDetail->Penjualan_Dari = $detail['Penjualan_Dari'];

            if (!$returDetail->save()) {
              throw new Exception('Error saving penjualan detail.');
            }

            //update ke table barang
            if ($model->TipeRetur == "PEMBELIAN") {
              $mBarang = Barang::model()->findByPk($detail['Barang_ID']);
            } else {
              $mFindBarangID = Penjualandetaillog::model()->findByAttributes(array('PenjualanDetail_ID' => $detail['PembelianDetail_ID']));
              $mBarang = Barang::model()->findByPk($mFindBarangID->Barang_ID);
            }

            $mBarang->JumlahRusak += $total;
            if (!$mBarang->save()) {
              throw new Exception('Error saving barang.');
            }

            $minoutline = new Minoutline();
            $minoutline->Barang_ID = $detail['Barang_ID'];
            $minoutline->Minout_ID = $minout->Minout_ID;
            $minoutline->Jumlah = $detail['Jumlah'];
            $minoutline->Satuan_ID = $detail['Satuan_ID'];
            $minoutline->Harga = (int) $detail['Harga'];
            $minoutline->HargaOffline = $detail['HargaOffline'];
            $minoutline->HargaGrosir = $detail['HargaGrosir'];
            $minoutline->HargaTokped = $detail['HargaTokped'];

            if (!$minoutline->save()) {
              throw new Exception('Error saving minoutline');
            }
          }

          // Clear session after successful save
          unset($session['selectedItems']);
          $transaction->commit();

          Yii::app()->user->setFlash('success', 'Sukses, Data berhasil disimpan');
          $this->redirect(array('retur/index', 'pageRetur' => 'retur'));
        }
      } catch (Exception $e) {
        $transaction->rollback();
        echo "Failed to complete the transaction: " . $e->getMessage();
        Yii::app()->user->setFlash('error', 'Error occurred while saving.');
      }
    }

    $this->render('create', array(
      'model' => $model,
      'selectedItems' => $selectedItems,
    ));
  }

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

    if (isset($_POST['Retur'])) {
      $model->attributes = $_POST['Retur'];
      if ($model->save())
        $this->redirect(array('view', 'id' => $model->Retur_ID));
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
  public function actionIndex($pageRetur)
  {
    unset(Yii::app()->session['selectedItems']);
    unset(Yii::app()->session['TipeRetur']);

    $model = new Retur('search');

    if (isset($_GET['Retur'])) {
      $model->attributes = $_GET['Retur'];
    }

    $dataProvider = $model->search();

    $this->render('index', array(
      'model' => $model,
      'dataProvider' => $dataProvider,
      'pageRetur' => $pageRetur
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new Retur('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Retur']))
      $model->attributes = $_GET['Retur'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Retur the loaded model
   * @throws CHttpException
   */
  public function loadModel($id)
  {
    $model = Retur::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Retur $model the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'retur-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
