<?php

/**
 * This is the model class for table "satuan".
 *
 * The followings are the available columns in table 'satuan':
 * @property integer $Satuan_ID
 * @property string $Satuan
 * @property integer $Jumlah
 * @property string $MasterBarang_ID
 * @property integer $Status
 */
class Satuan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'satuan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Satuan, Jumlah, HargaOffline, HargaTokped, HargaGrosir, MasterBarang_ID', 'required'),
			array('Jumlah, HargaOffline, HargaTokped, HargaGrosir, Status', 'numerical', 'integerOnly' => true),
			array('Satuan', 'length', 'max' => 100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Satuan_ID, Satuan, Jumlah, HargaOffline, HargaTokped, HargaGrosir, MasterBarang_ID, Status', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'masterbarang' => array(self::BELONGS_TO, 'MasterBarang', 'MasterBarang_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Satuan_ID' => 'Satuan',
			'Satuan' => 'Satuan',
			'Jumlah' => 'Jumlah',
			'HargaOffline' => 'Harga Offline',
			'HargaTokped' => 'Harga Tokopedia',
			'HargaGrosir' => 'Harga Grosir',
			'MasterBarang_ID' => 'Master Barang',
			'Status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search2()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('Satuan_ID', $this->Satuan_ID);
		$criteria->compare('Satuan', $this->Satuan, true);
		$criteria->compare('Jumlah', $this->Jumlah);
		$criteria->compare('MasterBarang_ID', $this->MasterBarang_ID, true);
		$criteria->compare('Status', $this->Status);

		$criteria->order = 't.Satuan_ID DESC';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('Satuan_ID', $this->Satuan_ID);
		$criteria->compare('Satuan', $this->Satuan, true);
		$criteria->compare('Jumlah', $this->Jumlah);
		$criteria->compare('MasterBarang_ID', $this->MasterBarang_ID, true);
		$criteria->compare('Status', 1);

		// Include the relation to masterbarang 
		$criteria->with = array('masterbarang');
		$criteria->together = true;

		if (isset($_GET['nama'])) {
			$criteria->compare('masterbarang.Nama', $_GET['nama'], true);
		}

		$criteria->order = 't.Satuan_ID DESC';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}


	public static function getDataProvider($nama = null)
	{
		$criteria = new CDbCriteria();
		$criteria->with = array('masterbarang');
		$criteria->together = true;
		
		$criteria->condition = 't.Status=1';

		if ($nama !== null) {
			$criteria->addCondition('(t.Satuan LIKE :nama OR masterbarang.Nama LIKE :nama)');
			$criteria->params[':nama'] = '%' . $nama . '%';
		}
		
		return new CActiveDataProvider('Satuan', array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.Satuan_ID DESC',
				'attributes' => array(
					'Satuan_ID',
					'Satuan',
					'masterbarang.Nama',
					'Jumlah', 
					'HargaOffline', 
					'HargaTokped', 
					'HargaGrosir'
				),
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Satuan the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
