<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property string $Customer_ID
 * @property string $Nama
 * @property string $Alamat
 * @property string $Telepon
 * @property integer $Type
 * @property integer $Status
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Nama, Alamat, Telepon, Type', 'required'),
			array('Type, Status', 'numerical', 'integerOnly'=>true),
			array('Customer_ID', 'length', 'max'=>255),
			array('Nama, Alamat, Telepon', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Customer_ID, Nama, Alamat, Telepon, Type, Status', 'safe', 'on'=>'search'),
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
			'Type' => array(self::BELONGS_TO, 'Customertype', 'CustomerType_ID'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Customer_ID' => 'Customer',
			'Nama' => 'Nama',
			'Alamat' => 'Alamat',
			'Telepon' => 'Telepon',
			'Type' => 'Type',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Customer_ID',$this->Customer_ID,true);
		$criteria->compare('Nama',$this->Nama,true);
		$criteria->compare('Alamat',$this->Alamat,true);
		$criteria->compare('Telepon',$this->Telepon,true);
		$criteria->compare('Type',$this->Type);
		$criteria->compare('Status',$this->Status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
