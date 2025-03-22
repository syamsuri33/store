<?php

/**
 * This is the model class for table "pembeliandetail".
 *
 * The followings are the available columns in table 'pembeliandetail':
 * @property string $PembelianDetail_ID
 * @property string $Barang_ID
 * @property string $Pembelian_ID
 * @property integer $Jumlah
 * @property string $Satuan_ID
 * @property double $Harga
 * @property double $Modal
 * @property string $Expired
 */
class Pembeliandetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pembeliandetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('Barang_ID, Satuan_ID, Jumlah, Harga, Modal, Expired', 'required'),
			array('Jumlah, Harga, Diskon, HargaOffline, HargaTokped', 'numerical', 'integerOnly'=>true),
			array('Harga, Modal', 'numerical'),
			array('Barang_ID', 'length', 'max'=>255),
			array('Pembelian_ID', 'length', 'max'=>100),
			array('Expired', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('PembelianDetail_ID, Barang_ID, Pembelian_ID, Jumlah, Satuan_ID, Harga, Modal, Diskon, Expired, HargaOffline, HargaTokped', 'safe', 'on'=>'search'),
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
			'barang' => array(self::BELONGS_TO, 'Barang', 'Barang_ID'),
			'satuan' => array(self::BELONGS_TO, 'Satuan', 'Satuan_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'PembelianDetail_ID' => 'Pembelian Detail',
			'Barang_ID' => 'Barang',
			'Pembelian_ID' => 'Pembelian',
			'Jumlah' => 'Jumlah',
			'Satuan_ID' => 'Satuan',
			'Harga' => 'Harga',
			'Modal' => 'Modal',
			'Diskon' => 'Diskon',
			'Expired' => 'Expired',
			'HargaOffline' => 'Harga Offline',
			'HargaTokped' => 'Harga Tokped',
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

		$criteria->compare('PembelianDetail_ID',$this->PembelianDetail_ID,true);
		$criteria->compare('Barang_ID',$this->Barang_ID,true);
		$criteria->compare('Pembelian_ID',$this->Pembelian_ID,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('Satuan_ID',$this->Satuan_ID,true);
		$criteria->compare('Harga',$this->Harga);
		$criteria->compare('Modal',$this->Modal);
		$criteria->compare('Diskon',$this->Diskon);
		$criteria->compare('Expired',$this->Expired,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pembeliandetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
