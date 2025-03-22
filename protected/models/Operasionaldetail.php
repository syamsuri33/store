<?php

/**
 * This is the model class for table "operasionaldetail".
 *
 * The followings are the available columns in table 'operasionaldetail':
 * @property integer $OperasionalDetail_ID
 * @property string $Nama
 * @property integer $Jumlah
 * @property integer $HargaSatuan
 * @property string $Operasional_ID
 */
class Operasionaldetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operasionaldetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Jumlah, HargaSatuan, Total', 'numerical', 'integerOnly'=>true),
			array('Nama, Operasional_ID', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('OperasionalDetail_ID, Nama, Jumlah, HargaSatuan, Total, Operasional_ID', 'safe', 'on'=>'search'),
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
			'operasional' => array(self::BELONGS_TO, 'Operasional', 'Operasional_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'OperasionalDetail_ID' => 'Operasional Detail',
			'Nama' => 'Item Name',
			'Jumlah' => 'Jumlah Item',
			'HargaSatuan' => 'Harga Satuan',
			'Total' => 'Total',
			'Operasional_ID' => 'Operasional',
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

		$criteria->compare('OperasionalDetail_ID',$this->OperasionalDetail_ID);
		$criteria->compare('Nama',$this->Nama,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('HargaSatuan',$this->HargaSatuan);
		$criteria->compare('Total',$this->Total);
		$criteria->compare('Operasional_ID',$this->Operasional_ID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Operasionaldetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
