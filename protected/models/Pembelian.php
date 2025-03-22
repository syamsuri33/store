<?php

/**
 * This is the model class for table "pembelian".
 *
 * The followings are the available columns in table 'pembelian':
 * @property string $Pembelian_ID
 * @property string $Tanggal
 * @property string $Created
 * @property string $UserCreated_ID
 * @property string $Updated
 * @property string $UserUpdated_ID
 */
class Pembelian extends CActiveRecord
{
	public $startDate; 
	public $endDate;

	public function tableName()
	{
		return 'pembelian';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Pembelian_ID', 'required'),
			array('Pembelian_ID', 'length', 'max'=>255),
			array('UserCreated_ID, UserUpdated_ID', 'length', 'max'=>100),
			array('Tanggal, Created, Updated, startDate, endDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Pembelian_ID, Tanggal, Created, UserCreated_ID, Updated, UserUpdated_ID', 'safe', 'on'=>'search'),
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
			'Pembelian_ID' => 'Pembelian',
			'Tanggal' => 'Tanggal',
			'Created' => 'Created',
			'UserCreated_ID' => 'User Created',
			'Updated' => 'Updated',
			'UserUpdated_ID' => 'User Updated',
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

		$criteria->compare('Pembelian_ID',$this->Pembelian_ID,true);
		$criteria->compare('Created',$this->Created,true);
		$criteria->compare('UserCreated_ID',$this->UserCreated_ID,true);
		$criteria->compare('Updated',$this->Updated,true);
		$criteria->compare('UserUpdated_ID',$this->UserUpdated_ID,true);

		if (!empty($this->startDate) && !empty($this->endDate)) {
			$criteria->addCondition('Tanggal >= :startDate');
			$criteria->addCondition('Tanggal <= :endDate');
			
			$criteria->params[':startDate'] = date('Y-m-d', strtotime($this->startDate));
			$criteria->params[':endDate'] = date('Y-m-d', strtotime($this->endDate));
		} elseif (!empty($this->startDate)) {
			$criteria->addCondition('Tanggal >= :startDate');
			$criteria->params[':startDate'] = date('Y-m-d', strtotime($this->startDate));
		} elseif (!empty($this->endDate)) {
			$criteria->addCondition('Tanggal <= :endDate');
			$criteria->params[':endDate'] = date('Y-m-d', strtotime($this->endDate));
		}

		$criteria->order = 'Created DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pembelian the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
