<?php

class MasterbarangController extends Controller
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
				'actions' => array('create', 'update', 'getData', 'deletes', 'getHarga'),
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
		$model = new Masterbarang;
		$kategoriValue = "";


		$lastId = Masterbarang::model()->find(array(
			'condition' => 'MasterBarang_ID LIKE :id',
			'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-%'),
			'order' => 'MasterBarang_ID DESC'
		));

		if ($lastId) {
			list($prefix, $number) = explode('-', $lastId->MasterBarang_ID);
			$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);
			$newProdukId = $prefix . '-' . $incrementedNumber;
		} else {
			$newProdukId = Yii::app()->user->getState('Kode_Cabang') . "-00001";
		}

		if (isset($_POST['Masterbarang'])) {

			$model->attributes = $_POST['Masterbarang'];
			$model->MasterBarang_ID = $newProdukId;
			$model->HargaOffline = str_replace('.', '', $model->HargaOffline);
			$model->HargaGrosir = str_replace('.', '', $model->HargaGrosir);
			$model->HargaTokped = str_replace('.', '', $model->HargaTokped);
			$model->MinStok = str_replace('.', '', $model->MinStok);
			$model->Vendor_ID = $model->Vendor_ID;
			$model->StatusAktif = 1;

			$kategoriValue = $_POST['Kategori'];

			$findDuplikat = Masterbarang::model()->find(array(
				'condition' => 'Nama = :nama and Kategori_ID = :kategoriID',
				'params' => array(
					':nama' => $model->Nama,
					':kategoriID' => $model->Kategori_ID,
				),
				'order' => 'MasterBarang_ID DESC'
			));

			if ($findDuplikat) {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_ADD_DUPLICATE']);
				$this->redirect(array('create'));
			}

			if ($model->save()) {
				$mSatuan = new Satuan();
				$mSatuan->Satuan = 'pcs';
				$mSatuan->Jumlah = 1;
				$mSatuan->HargaOffline = str_replace('.', '', $model->HargaOffline);
				$mSatuan->HargaGrosir = str_replace('.', '', $model->HargaGrosir);
				$mSatuan->HargaTokped = str_replace('.', '', $model->HargaTokped);
				$mSatuan->MasterBarang_ID = $newProdukId;
				$mSatuan->Status = 1;
				$mSatuan->save();

				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_ADD_SUCCESS']);
				$this->redirect(array('index'));
			} else {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_ADD_FAILED']);
			}
		}

		$this->render('create', array(
			'model' => $model,
			'kategoriValue' => $kategoriValue
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

		$model->HargaOffline = number_format($model->HargaOffline, 0, '', '.');
		$model->HargaGrosir = number_format($model->HargaGrosir, 0, '', '.');
		$model->HargaTokped = number_format($model->HargaTokped, 0, '', '.');
		$model->MinStok = number_format($model->MinStok, 0, '', '.');

		$kategoriValue = $model->kategori->Kategori;

		if (isset($_POST['Masterbarang'])) {
			$model->attributes = $_POST['Masterbarang'];

			$model->HargaOffline = str_replace('.', '', $model->HargaOffline);
			$model->HargaGrosir = str_replace('.', '', $model->HargaGrosir);
			$model->HargaTokped = str_replace('.', '', $model->HargaTokped);
			$model->MinStok = str_replace('.', '', $model->MinStok);
			$model->Vendor_ID = $model->Vendor_ID;

			if ($model->save()) {
				//update satuan
				$satuan = Satuan::model()->findByAttributes(array('MasterBarang_ID' => $id, 'Satuan' => 'pcs'));
				$satuan->HargaOffline = $model->HargaOffline;
				$satuan->HargaGrosir = $model->HargaGrosir;
				$satuan->HargaTokped = $model->HargaTokped;
				$satuan->save();

				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_UPDATE_SUCCESS']);
				$this->redirect(array('index'));
			} else {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_UPDATE_FAILED']);
			}
		}

		$this->render('update', array(
			'model' => $model,
			'kategoriValue' => $kategoriValue
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletes($id)
	{
		$model = Masterbarang::model()->findByPk($id);
		$model->StatusAktif = 0;

		if ($model->save()) {
			Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_DELETE_SUCCESS']);
			$this->redirect(array('index'));
		} else {
			Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DELETE_FAILED']);
			$this->redirect(array('index'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$nama = isset($_GET['nama']) ? $_GET['nama'] : null;
		$dataProvider = Masterbarang::getDataProvider($nama);

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Masterbarang('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Masterbarang']))
			$model->attributes = $_GET['Masterbarang'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionGetData()
	{
		include_once('protected/controllers/KategoriController.php');
		$kategoriController = new KategoriController('kategori');

		$criteria = new CDbCriteria();
		$criteria->order = 'Kategori ASC';
		$criteria->condition = 'Status = 1';
		$categories = Kategori::model()->findAll($criteria);
		$categoriesTree = $kategoriController->buildTree($categories);

		$this->renderPartial('_dataTable', array('categoriesTree' => $categoriesTree));
	}

	public function actionGetHarga()
	{
		$Customer_ID = $_GET['customer_id'];
		$MasterBarang_ID = $_GET['masterbarang_id'];
		$penjualanDari = $_GET['penjualanDari'];

		if (!empty($_GET['satuan'])) {
			$mSatuan = Satuan::model()->findByAttributes(array('MasterBarang_ID' => $MasterBarang_ID, 'Satuan_ID' => $_GET['satuan']));
		} else {
			$mSatuan = Satuan::model()->findByAttributes(array('MasterBarang_ID' => $MasterBarang_ID, 'Satuan' => 'pcs'));
		}

		if ($penjualanDari == "OFFLINE") {
			if (!empty($Customer_ID)) {
				$mCustomer = Customer::model()->findByPk($Customer_ID);
				if ($mCustomer->type->Type == "grosir") {
					echo $mSatuan->HargaGrosir;
				} else {
					echo $mSatuan->HargaOffline;
				}
			} else {
				echo $mSatuan->HargaOffline;
			}
		} else {
			echo $mSatuan->HargaTokped;
		}
		Yii::app()->end();
	}

	public function loadModel($id)
	{
		$model = Masterbarang::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Masterbarang $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'masterbarang-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
