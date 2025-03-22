<?php

/**
 * This is the model class for table "minout".
 *
 * The followings are the available columns in table 'minout':
 * @property string $Minout_ID
 * @property string $Tanggal
 * @property string $Modul_ID
 * @property string $Modul
 * @property double $Total
 */
class Minout extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'minout';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tanggal, Modul', 'required'),
			array('Total', 'numerical'),
			array('Modul_ID, Modul', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Minout_ID, Tanggal, Modul_ID, Modul, Total', 'safe', 'on'=>'search'),
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
			'Minout_ID' => 'Minout',
			'Tanggal' => 'Tanggal',
			'Modul_ID' => 'Modul',
			'Modul' => 'Modul',
			'Total' => 'Total',
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

		$criteria->compare('Minout_ID',$this->Minout_ID,true);
		$criteria->compare('Tanggal',$this->Tanggal,true);
		$criteria->compare('Modul_ID',$this->Modul_ID,true);
		$criteria->compare('Modul',$this->Modul,true);
		$criteria->compare('Total',$this->Total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Minout the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
