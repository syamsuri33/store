<?php

/**
 * This is the model class for table "barang".
 *
 * The followings are the available columns in table 'barang':
 * @property string $Barang_ID
 * @property string $MasterBarang_ID
 * @property integer $StatusPPN
 * @property integer $Jumlah
 * @property string $Satuan_ID
 * @property double $Harga
 * @property double $Modal
 * @property integer $StatusAktif
 * @property string $Created
 * @property string $UserCreated_ID
 * @property string $Updated
 * @property string $UserUpdated_ID
 */
class Barang extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'barang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Jumlah, StatusAktif', 'numerical', 'integerOnly'=>true),
			array('MasterBarang_ID', 'length', 'max'=>9),
			array('UserCreated_ID, UserUpdated_ID', 'length', 'max'=>50),
			array('Created, Updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Barang_ID, MasterBarang_ID, Jumlah, PembelianDetail_ID, StatusAktif, Created, UserCreated_ID, Updated, UserUpdated_ID', 'safe', 'on'=>'search'),
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
            'masterbarang' => array(self::BELONGS_TO, 'MasterBarang', 'MasterBarang_ID'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Barang_ID' => 'Barang',
			'MasterBarang_ID' => 'Master Barang',
			'Jumlah' => 'Jumlah',
			'StatusAktif' => 'Status Aktif',
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

		$criteria->compare('Barang_ID',$this->Barang_ID,true);
		$criteria->compare('MasterBarang_ID',$this->MasterBarang_ID,true);
		$criteria->compare('Jumlah',$this->Jumlah);
		$criteria->compare('StatusAktif',$this->StatusAktif);
		$criteria->compare('Created',$this->Created,true);
		$criteria->compare('UserCreated_ID',$this->UserCreated_ID,true);
		$criteria->compare('Updated',$this->Updated,true);
		$criteria->compare('UserUpdated_ID',$this->UserUpdated_ID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Barang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
