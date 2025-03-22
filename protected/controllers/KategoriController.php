<?php

class KategoriController extends Controller
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
				'actions' => array('view'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('index', 'create', 'update', 'upload'),
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

	public function actionUpload()
	{
		if (isset($_FILES['file'])) {
			$file = $_FILES['file'];

			// Periksa apakah file diunggah tanpa kesalahan
			if ($file['error'] === UPLOAD_ERR_OK) {
				// Sertakan file PHPExcel
				require_once('protected/extensions/PHPExcel/Classes/PHPExcel.php');

				// Muat file spreadsheet
				$inputFileName = $file['tmp_name'];

				try {
					// Muat spreadsheet
					$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

					// Loop melalui data dan simpan ke database
					foreach ($sheetData as $row) {
						// Asumsikan tabel database memiliki kolom 'Kategori_ID', 'Parent', 'Kode', dan 'Kategori'
						$dataModel = new Kategori();
						$dataModel->Kategori_ID = isset($row['A']) ? $row['A'] : null;
						$dataModel->Parent = isset($row['B']) ? $row['B'] : null;
						$dataModel->Kode = isset($row['C']) ? $row['C'] : null; // Sesuaikan dengan struktur Excel Anda
						$dataModel->Kategori = isset($row['C']) ? $row['C'] : null; // Sesuaikan dengan struktur Excel Anda
						$dataModel->Status = 1; // Set status ke 1

						// Simpan model dan periksa kesalahan
						if (!$dataModel->save()) {
							$this->redirect(array('site/cs'));
						}
					}

					// Redirect atau tampilkan pesan sukses
					$this->redirect(array('site/index2')); // Sesuaikan redirect sesuai kebutuhan
				} catch (Exception $e) {
					// Catat pesan pengecualian
					Yii::log("Kesalahan saat memuat file: " . $e->getMessage(), CLogger::LEVEL_ERROR);
					Yii::app()->user->setFlash('error', 'Kesalahan saat memuat file: ' . $e->getMessage());
					$this->redirect(array('site/index1')); // Sesuaikan redirect sesuai kebutuhan
				}
			} else {
				// Tangani kesalahan
				Yii::app()->user->setFlash('error', 'Kesalahan unggah file: ' . $file['error']);
				$this->redirect(array('site/indexz')); // Sesuaikan redirect sesuai kebutuhan
			}
		}

		$this->render('upload');
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
	public function actionCreate()
	{
		echo "<script>console.log(" . CJSON::encode("aa") . ");</script>";
		if (isset($_POST['Kategori'])) {
			//if (!empty($_POST['category_name']) && !empty($_POST['category_name']) && !empty($_POST['category_name'])) {
			$lastId = Kategori::model()->find(array(
				'condition' => 'Kategori_ID LIKE :id',
				'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-%'),
				'order' => 'Kategori_ID DESC'
			));

			if ($lastId) {
				//awal ex 1-00001
				$firstDashPos = strpos($lastId->Kategori_ID, '-'); // jadi 1
				$number = substr($lastId->Kategori_ID, $firstDashPos + 1); // '00001'
				$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT); //00002
				$id = Yii::app()->user->getState('Kode_Cabang') . "-" . $incrementedNumber;
			} else {
				$id = Yii::app()->user->getState('Kode_Cabang') . "-00001";
			}
			//echo "<script>console.log(" . CJSON::encode($_POST['category_kode']) . ");</script>";
			//echo "<script>console.log(" . CJSON::encode($_POST['category_kode']) . ");</script>";

			// $category = new Kategori;
			// $category->Kategori_ID = $id;
			// $category->Kode = $_POST['category_kode'];
			// $category->Kategori = $_POST['category_name'];
			// $category->Parent = $_POST['parent_id'];
			// echo "<script>console.log(" . CJSON::encode("dd") . ");</script>";
			// if ($category->save()) {
			// 	echo "<script>console.log(" . CJSON::encode("ss") . ");</script>";
			// 	Yii::app()->user->setFlash('success', 'Data berhasil disimpan');
			// 	$this->redirect(array('index'));
			// } else {
			// 	echo "<script>console.log(" . CJSON::encode("oo") . ");</script>";
			// 	Yii::app()->user->setFlash('error', 'Gagal menyimpan Data.');
			// }
			//}else{
			//	echo "<script>console.log(" . CJSON::encode("kosonf") . ");</script>";
			//	Yii::app()->user->setFlash('error', 'Gagal menyimpan Data.');
			//	$this->redirect(array('index'));
			//}
		}
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

		if (isset($_POST['Kategori'])) {
			$model->attributes = $_POST['Kategori'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->Kategori_ID));
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
	public function actionIndex()
	{
		$model = new Kategori;

		$criteria = new CDbCriteria();
		$criteria->order = 'Kategori ASC';
		$criteria->condition = 'Status = 1';

		// if (isset($_FILES['file'])) {
		// 	$this->actionUpload();
		// }

		$categories = Kategori::model()->findAll($criteria);
		$categoriesTree = $this->buildTree($categories);

		if (isset($_POST['Kategori'])) {
			$lastId = Kategori::model()->find(array(
				'condition' => 'Kategori_ID LIKE :id',
				'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-%'),
				'order' => 'Kategori_ID DESC'
			));

			if ($lastId) {
				//awal ex 1-00001
				$firstDashPos = strpos($lastId->Kategori_ID, '-'); // jadi 1
				$number = substr($lastId->Kategori_ID, $firstDashPos + 1); // '00001'
				$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT); //00002
				$id = Yii::app()->user->getState('Kode_Cabang') . "-" . $incrementedNumber;
			} else {
				$id = Yii::app()->user->getState('Kode_Cabang') . "-00001";
			}

			$model->attributes = $_POST['Kategori'];
			$model->Kategori_ID = $id;
			$model->Status = 1;

			if ($model->save()) {
				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_ADD_SUCCESS']);
				$this->redirect(array('index'));
			} else {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_ADD_FAILED']);
			}
		}


		$this->render('index', array(
			'categoriesTree' => $categoriesTree,
			'model' => $model,
		));
	}

	public function buildTree($categories, $parentId = null)
	{
		$branch = array();
		foreach ($categories as $category) {
			if ($category->Parent == $parentId) {
				$children = $this->buildTree($categories, $category->Kategori_ID);
				if ($children) {
					$category->children = $children;
				}
				$branch[] = $category;
			}
		}
		return $branch;
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Kategori('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Kategori']))
			$model->attributes = $_GET['Kategori'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Kategori the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Kategori::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Kategori $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'kategori-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
