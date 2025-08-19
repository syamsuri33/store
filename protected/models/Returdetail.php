<?php

/**
 * This is the model class for table "returdetail".
 *
 * The followings are the available columns in table 'returdetail':
 * @property string $ReturDetail_ID
 * @property string $Barang_ID
 * @property string $Retur_ID
 * @property integer $Jumlah
 * @property integer $Satuan_ID
 * @property string $Harga
 * @property string $Penjualan_Dari
 * @property double $HargaOffline
 * @property double $HargaGrosir
 * @property double $HargaTokped
 * @property string $Alasan
 */
class Returdetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'returdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Jumlah, ModulDetail_ID, Satuan_ID', 'numerical', 'integerOnly'=>true),
			array('HargaOffline, HargaGrosir, HargaTokped', 'numerical'),
			array('Barang_ID, Retur_ID, Alasan', 'length', 'max'=>255),
			array('Harga', 'length', 'max'=>20),
			array('Penjualan_Dari', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ReturDetail_ID, ModulDetail_ID, Barang_ID, Retur_ID, Jumlah, Satuan_ID, Harga, Penjualan_Dari, HargaOffline, HargaGrosir, HargaTokped, Alasan', 'safe', 'on'=>'search'),
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
      'satuan' => array(self::BELONGS_TO, 'Satuan', 'Satuan_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ReturDetail_ID' => 'Retur Detail',
      'ModulDetail_ID' => 'ModulDetail_ID',      
			'Barang_ID' => 'Barang',
			'Retur_ID' => 'Retur',
			'Jumlah' => 'Jumlah',
			'Satuan_ID' => 'Satuan',
			'Harga' => 'Harga',
			'Penjualan_Dari' => 'Penjualan Dari',
			'HargaOffline' => 'Harga Offline',
			'HargaGrosir' => 'Harga Grosir',
			'HargaTokped' => 'Harga Tokped',
			'Alasan' => 'Alasan',
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

		$criteria->compare('ReturDetail_ID',$this->ReturDetail_ID,true);
    $criteria->compare('ModulDetail_ID',$this->ModulDetail_ID,true);
		$criteria->compare('Barang_ID',$this->Barang_ID,true);
		$criteria->compare('Retur_ID',$this->Retur_ID,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('Satuan_ID',$this->Satuan_ID);
		$criteria->compare('Harga',$this->Harga,true);
		$criteria->compare('Penjualan_Dari',$this->Penjualan_Dari,true);
		$criteria->compare('HargaOffline',$this->HargaOffline);
		$criteria->compare('HargaGrosir',$this->HargaGrosir);
		$criteria->compare('HargaTokped',$this->HargaTokped);
		$criteria->compare('Alasan',$this->Alasan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Returdetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
