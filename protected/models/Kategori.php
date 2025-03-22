<?php

/**
 * This is the model class for table "kategori".
 *
 * The followings are the available columns in table 'kategori':
 * @property string $Kategori_ID
 * @property string $Kode
 * @property string $Kategori
 * @property string $Parent
 * @property integer $Status
 */
class Kategori extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kategori';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Kode, Kategori', 'required'),
			array('Status', 'numerical', 'integerOnly'=>true),
			array('Kategori_ID, Kode, Kategori, Parent', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Kategori_ID, Kode, Kategori, Parent, Status', 'safe', 'on'=>'search'),
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
			'parent' => array(self::BELONGS_TO, 'Kategori', 'Parent'),
            'children' => array(self::HAS_MANY, 'Kategori', 'Parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Kategori_ID' => 'Kategori',
			'Kode' => 'Kode',
			'Kategori' => 'Kategori',
			'Parent' => 'Parent',
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

		$criteria->compare('Kategori_ID',$this->Kategori_ID,true);
		$criteria->compare('Kode',$this->Kode,true);
		$criteria->compare('Kategori',$this->Kategori,true);
		$criteria->compare('Parent',$this->Parent,true);
		$criteria->compare('Status',$this->Status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kategori the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
