<?php

/**
 * This is the model class for table "minoutline".
 *
 * The followings are the available columns in table 'minoutline':
 * @property string $MinoutLine_ID
 * @property string $Barang_ID
 * @property string $Minout_ID
 * @property integer $Jumlah
 * @property integer $Satuan_ID
 * @property string $Harga
 * @property string $Modal
 * @property string $Expired
 */
class Minoutline extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'minoutline';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Jumlah, Satuan_ID, Diskon', 'numerical', 'integerOnly'=>true),
			array('Barang_ID', 'length', 'max'=>255),
			array('Minout_ID, Harga, Modal', 'length', 'max'=>20),
			array('Expired', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('MinoutLine_ID, Barang_ID, Minout_ID, Jumlah, Satuan_ID, Harga, Modal, Diskon, Expired', 'safe', 'on'=>'search'),
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
			'MinoutLine_ID' => 'Minout Line',
			'Barang_ID' => 'Barang',
			'Minout_ID' => 'Minout',
			'Jumlah' => 'Jumlah',
			'Satuan_ID' => 'Satuan',
			'Harga' => 'Harga',
			'Modal' => 'Modal',
			'Diskon' => 'Diskon',
			'Expired' => 'Expired',
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

		$criteria->compare('MinoutLine_ID',$this->MinoutLine_ID,true);
		$criteria->compare('Barang_ID',$this->Barang_ID,true);
		$criteria->compare('Minout_ID',$this->Minout_ID,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('Satuan_ID',$this->Satuan_ID);
		$criteria->compare('Harga',$this->Harga,true);
		$criteria->compare('Modal',$this->Modal,true);
		$criteria->compare('Diskon',$this->Diskon,true);
		$criteria->compare('Expired',$this->Expired,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Minoutline the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
