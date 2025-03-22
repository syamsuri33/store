<?php

/**
 * This is the model class for table "masterbarang".
 *
 * The followings are the available columns in table 'masterbarang':
 * @property string $MasterBarang_ID
 * @property string $Kode
 * @property string $Nama
 * @property string $Kategori_ID
 * @property string $Keterangan
 * @property double $Harga
 * @property string $Barcode
 * @property double $MinStok
 * @property integer $StatusAktif
 */
class Masterbarang extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'masterbarang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Kode, Nama, Kategori_ID, Vendor_ID, HargaOffline, HargaTokped, MinStok', 'required'),
			array('StatusAktif', 'numerical', 'integerOnly'=>true),
			array('HargaOffline, HargaTokped, MinStok', 'numerical'),
			array('MasterBarang_ID, Kode, Nama, Kategori_ID, Keterangan, Barcode', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('MasterBarang_ID, Kode, Nama, Kategori_ID, Vendor_ID, Keterangan, HargaOffline, HargaTokped, Barcode, MinStok, StatusAktif', 'safe', 'on'=>'search'),
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
			'kategori' => array(self::BELONGS_TO, 'Kategori', 'Kategori_ID'), 
			'vendor' => array(self::BELONGS_TO, 'Vendor', 'Vendor_ID'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'MasterBarang_ID' => 'Master Barang',
			'Kode' => 'Kode',
			'Nama' => 'Nama',
			'Kategori_ID' => 'Kategori',
			'Vendor_ID' => 'Vendor',
			'Keterangan' => 'Keterangan',
			'HargaOffline' => 'Harga Offline',
			'HargaTokped' => 'Harga Tokped',
			'Barcode' => 'Barcode',
			'MinStok' => 'Min Stok',
			'StatusAktif' => 'Status Aktif',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('MasterBarang_ID',$this->MasterBarang_ID,true);
		$criteria->compare('Kode',$this->Kode,true);
		$criteria->compare('Nama',$this->Nama,true);
		$criteria->compare('Kategori_ID',$this->Kategori_ID,true);
		$criteria->compare('Vendor_ID',$this->Vendor_ID,true);
		$criteria->compare('Keterangan',$this->Keterangan,true);
		$criteria->compare('HargaOffline',$this->HargaOffline);
		$criteria->compare('HargaTokped',$this->HargaTokped);
		$criteria->compare('Barcode',$this->Barcode,true);
		$criteria->compare('MinStok',$this->MinStok);
		$criteria->compare('StatusAktif',$this->StatusAktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Masterbarang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
