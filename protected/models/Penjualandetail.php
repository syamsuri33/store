<?php

/**
 * This is the model class for table "penjualandetail".
 *
 * The followings are the available columns in table 'penjualandetail':
 * @property string $PenjualanDetail_ID
 * @property string $MasterBarang_ID
 * @property string $Penjualan_ID
 * @property integer $Jumlah
 * @property integer $Satuan_ID
 * @property string $Harga
 * @property string $Penjualan_Dari
 */
class Penjualandetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penjualandetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Jumlah, Satuan_ID, HargaOffline, HargaTokped', 'numerical', 'integerOnly'=>true),
			array('MasterBarang_ID, Penjualan_ID', 'length', 'max'=>255),
			array('Harga', 'length', 'max'=>20),
			array('Penjualan_Dari', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('PenjualanDetail_ID, MasterBarang_ID, Penjualan_ID, Jumlah, Satuan_ID, Harga, Penjualan_Dari, HargaOffline, HargaTokped', 'safe', 'on'=>'search'),
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
			'masterBarang' => array(self::BELONGS_TO, 'Masterbarang', 'MasterBarang_ID'),
			'satuan' => array(self::BELONGS_TO, 'Satuan', 'Satuan_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'PenjualanDetail_ID' => 'Penjualan Detail',
			'MasterBarang_ID' => 'Barang',
			'Penjualan_ID' => 'Penjualan',
			'Jumlah' => 'Jumlah',
			'Satuan_ID' => 'Satuan',
			'Harga' => 'Harga',
			'Penjualan_Dari' => 'Penjualan Dari',
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

		$criteria->compare('PenjualanDetail_ID',$this->PenjualanDetail_ID,true);
		$criteria->compare('MasterBarang_ID',$this->MasterBarang_ID,true);
		$criteria->compare('Penjualan_ID',$this->Penjualan_ID,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('Satuan_ID',$this->Satuan_ID);
		$criteria->compare('Harga',$this->Harga,true);
		$criteria->compare('Penjualan_Dari',$this->Penjualan_Dari,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Penjualandetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
