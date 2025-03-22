<?php

/**
 * This is the model class for table "operasional".
 *
 * The followings are the available columns in table 'operasional':
 * @property string $Operasional_ID
 * @property string $Tanggal
 */
class Operasional extends CActiveRecord
{
	public $startDate;
	public $endDate;

	public function tableName()
	{
		return 'operasional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tanggal', 'required'),
			array('Operasional_ID', 'length', 'max' => 255),
			array('Tanggal, startDate, endDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Operasional_ID, Tanggal', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Operasional_ID' => 'Operasional',
			'Tanggal' => 'Tanggal',
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
		$criteria = new CDbCriteria;

		$criteria->compare('Operasional_ID', $this->Operasional_ID, true);
		$criteria->addCondition('StatusAktif = 1');
		// Add date range filter 
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

		$criteria->order = 'Tanggal DESC';

		return new CActiveDataProvider($this, array('criteria' => $criteria,));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Operasional the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
