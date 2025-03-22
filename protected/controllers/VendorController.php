<?php

class VendorController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/mainAdminLTE';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'deletes'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Vendor;

		if(isset($_POST['Vendor']))
		{
			$lastId = Vendor::model()->find(array(
				'condition' => 'Vendor_ID LIKE :id',
				'params' => array(':id' => Yii::app()->user->getState('Kode_Cabang') . '-%'),
				'order' => 'Vendor_ID DESC'
			));

			if ($lastId) {
				//awal ex 1-00001
				$firstDashPos = strpos($lastId->Vendor_ID, '-'); // jadi 1
				$number = substr($lastId->Vendor_ID, $firstDashPos + 1); // '00001'
				$incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT); //00002
				$id = Yii::app()->user->getState('Kode_Cabang') . "-" . $incrementedNumber;
			}else{
				$id = Yii::app()->user->getState('Kode_Cabang') . "-00001";
			}

			$model->attributes=$_POST['Vendor'];
			$model->Vendor_ID = $id;
			$model->StatusAktif = 1;

			if($model->save()){
				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_ADD_SUCCESS']);
				$this->redirect(array('index'));
			}else{
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_ADD_FAILED']);
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vendor']))
		{
			$model->attributes=$_POST['Vendor'];
			if($model->save()){
				Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_UPDATE_SUCCESS']);
				$this->redirect(array('index'));
			}else {
				Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_UPDATE_FAILED']);
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletes($id)
	{
		$model = Vendor::model()->findByPk($id);
		$model->StatusAktif = 0;

		if ($model->save()) {
			Yii::app()->user->setFlash('success', Yii::app()->params['FLASH_DELETE_SUCCESS']);
			$this->redirect(array('index'));
		}else{
			Yii::app()->user->setFlash('error', Yii::app()->params['FLASH_DELETE_FAILED']);
			$this->redirect(array('index'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_GET['nama'])) {
			$dataProvider = new CActiveDataProvider('Vendor', array(
				'criteria' => array(
					'condition' => '((t.Vendor LIKE "%' . $_GET['nama'] . '%") OR (t.Alamat LIKE "%' . $_GET['nama'] . '%")) and t.StatusAktif=1',
				),
				'pagination' => array( 'pageSize' => 10),
			));
		} else {
			$dataProvider = new CActiveDataProvider('Vendor', array(
				'criteria' => array(
					'condition' => 't.StatusAktif=1',
				),
				'pagination' => array( 'pageSize' => 10),
			));
		}
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vendor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vendor']))
			$model->attributes=$_GET['Vendor'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vendor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Vendor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Vendor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vendor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
