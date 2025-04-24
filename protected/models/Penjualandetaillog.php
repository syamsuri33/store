<?php

/**
 * This is the model class for table "penjualandetaillog".
 *
 * The followings are the available columns in table 'penjualandetaillog':
 * @property string $PenjualanDetailLog_ID
 * @property string $Barang_ID
 * @property string $PenjualanDetail_ID
 * @property integer $Jumlah
 * @property integer $Jumlah_Awal
 */
class Penjualandetaillog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penjualandetaillog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Jumlah, Jumlah_Awal', 'numerical', 'integerOnly'=>true),
			array('Barang_ID, PenjualanDetail_ID', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('PenjualanDetailLog_ID, Barang_ID, PenjualanDetail_ID, Jumlah, Jumlah_Awal', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'PenjualanDetailLog_ID' => 'Penjualan Detail Log',
			'Barang_ID' => 'Barang',
			'PenjualanDetail_ID' => 'Penjualan Detail',
			'Jumlah' => 'Jumlah',
			'Jumlah_Awal' => 'Jumlah Awal',
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

		$criteria->compare('PenjualanDetailLog_ID',$this->PenjualanDetailLog_ID,true);
		$criteria->compare('Barang_ID',$this->Barang_ID,true);
		$criteria->compare('PenjualanDetail_ID',$this->PenjualanDetail_ID,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('Jumlah_Awal',$this->Jumlah_Awal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Penjualandetaillog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
