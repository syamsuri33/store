<?php

/**
 * This is the model class for table "penjualan".
 *
 * The followings are the available columns in table 'penjualan':
 * @property string $Penjualan_ID
 * @property string $Tanggal
 * @property string $Created
 * @property string $UserCreated_ID
 * @property string $Updated
 * @property string $UserUpdated_ID
 * @property double $Total
 * @property integer $StatusAktif
 */
class Penjualan extends CActiveRecord
{
	public $startDate; 
	public $endDate;

	public function tableName()
	{
		return 'penjualan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Penjualan_ID, Customer_ID', 'required'),
			array('StatusAktif', 'numerical', 'integerOnly'=>true),
			array('Total', 'numerical'),
			array('Penjualan_ID, Customer_ID', 'length', 'max'=>255),
			array('UserCreated_ID, UserUpdated_ID', 'length', 'max'=>100),
			array('Tanggal, Customer_ID, Created, Updated, startDate, endDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Penjualan_ID, Tanggal, Customer_ID, Created, UserCreated_ID, Updated, UserUpdated_ID, Total, StatusAktif', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'Customer_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Penjualan_ID' => 'Penjualan',
			'Tanggal' => 'Tanggal',
			'Customer_ID' => 'Customer',			
			'Created' => 'Created',
			'UserCreated_ID' => 'User Created',
			'Updated' => 'Updated',
			'UserUpdated_ID' => 'User Updated',
			'Total' => 'Total',
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
		$criteria->with = array('customer');
		$criteria->together = true;
		
		$criteria->compare('Penjualan_ID',$this->Penjualan_ID,true);
		$criteria->compare('Created',$this->Created,true);
		$criteria->compare('UserCreated_ID',$this->UserCreated_ID,true);
		$criteria->compare('Updated',$this->Updated,true);
		$criteria->compare('UserUpdated_ID',$this->UserUpdated_ID,true);
		$criteria->compare('Total',$this->Total);
		
		$criteria->addCondition('StatusAktif = 1');

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
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 't.Created DESC',
				'attributes' => array(
					'Created',
					'Penjualan_ID',
					'Tanggal',
					'customer.Nama'
				),
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Penjualan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
