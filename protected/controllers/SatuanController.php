<?php

class SatuanController extends Controller
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
				'actions' => array('create', 'update', 'deletes', 'getSatuan', 'getSatuan2'),
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
		$model = new Satuan;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Satuan'])) {


			$model->attributes = $_POST['Satuan'];
			$model->HargaOffline = str_replace('.', '', $model->HargaOffline);
			$model->HargaGrosir = str_replace('.', '', $model->HargaGrosir);
			$model->HargaTokped = str_replace('.', '', $model->HargaTokped);
			$model->Status = 1;

			$findDuplikat = Satuan::model()->find(array(
				'condition' => 'Satuan = :satuan and MasterBarang_ID = :MasterBarang_ID',
				'params' => array(
					':satuan' => $model->Satuan,
					':MasterBarang_ID' => $model->MasterBarang_ID,
				),
				'order' => 'MasterBarang_ID DESC'
			));

			if ($findDuplikat) {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_ADD_DUPLICATE']);
				$this->redirect(array('create'));
			}

			if ($model->save()) {
				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_ADD_SUCCESS']);
				$this->redirect(array('index'));
			} else {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_ADD_FAILED']);
			}
		}

		$this->render('create', array(
			'model' => $model,
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

		if (isset($_POST['Satuan'])) {
			$model->attributes = $_POST['Satuan'];

			$model->HargaOffline = str_replace('.', '', $model->HargaOffline);
			$model->HargaGrosir = str_replace('.', '', $model->HargaGrosir);
			$model->HargaTokped = str_replace('.', '', $model->HargaTokped);

			if ($model->save()) {
				if ($model->Satuan == 'pcs') {
					//update masterBarang
					$mMasterBarang = Masterbarang::model()->findByPk($model->MasterBarang_ID);
					$mMasterBarang->HargaOffline = str_replace('.', '', $model->HargaOffline);
					$mMasterBarang->HargaGrosir = str_replace('.', '', $model->HargaGrosir);
					$mMasterBarang->HargaTokped = str_replace('.', '', $model->HargaTokped);
					$mMasterBarang->save();
				}

				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_UPDATE_SUCCESS']);
				$this->redirect(array('index'));
			} else {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_UPDATE_FAILED']);
			}
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
	public function actionDeletes($id)
	{
		$model = Satuan::model()->findByPk($id);
		$model->Status = 0;

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
		$dataProvider = Satuan::getDataProvider($nama);
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Satuan('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Satuan']))
			$model->attributes = $_GET['Satuan'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Satuan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Satuan::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Satuan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'satuan-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetSatuan($masterbarang_id)
	{
		$satuanList = Satuan::model()->findAllByAttributes(['MasterBarang_ID' => $masterbarang_id]);
		$data = CHtml::listData($satuanList, 'Satuan_ID', 'Satuan');
		echo CJSON::encode($data);
		Yii::app()->end();
	}


	public function actionGetSatuan2()
	{
		$MasterBarang_ID = $_GET['masterbarang_id'];
		$satuanData = CHtml::listData(
			Satuan::model()->findAll(array(
				'condition' => 'MasterBarang_ID = :masterbarang_id',
				'params' => array(':masterbarang_id' => $MasterBarang_ID)
			)),
			'Satuan_ID',
			'Satuan'
		);
		echo json_encode($satuanData);
		Yii::app()->end();
	}
}
