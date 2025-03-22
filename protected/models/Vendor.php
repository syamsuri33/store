<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property string $Vendor_ID
 * @property string $Vendor
 * @property string $Alamat
 * @property integer $StatusAktif
 */
class Vendor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vendor, Alamat', 'required'),
			array('StatusAktif', 'numerical', 'integerOnly'=>true),
			array('Vendor_ID', 'length', 'max'=>255),
			array('Vendor, Alamat', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Vendor_ID, Vendor, Alamat, StatusAktif', 'safe', 'on'=>'search'),
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
			'Vendor_ID' => 'Vendor',
			'Vendor' => 'Vendor',
			'Alamat' => 'Alamat',
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

		$criteria->compare('Vendor_ID',$this->Vendor_ID,true);
		$criteria->compare('Vendor',$this->Vendor,true);
		$criteria->compare('Alamat',$this->Alamat,true);
		$criteria->compare('StatusAktif',$this->StatusAktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
