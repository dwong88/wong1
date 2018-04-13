<?php

/**
 * This is the model class for table "tghbasepriceroom".
 *
 * The followings are the available columns in table 'tghbasepriceroom':
 * @property string $basepriceroom_type_id
 * @property integer $room_type_id
 * @property integer $hours
 * @property double $price
 */

class Basepriceroom extends CActiveRecord
{
	public static $publicTypePrice = array('hr24','hr0','hr1', 'hr2', 'hr3', 'hr4', 'hr5', 'hr6', 'hr7', 'hr8', 'hr9', 'hr10', 'hr11', 'hr12');
	public $hr24;
	public $hr0;
	public $hr1;
	public $hr2;
	public $hr3;
	public $hr4;
	public $hr5;
	public $hr6;
	public $hr7;
	public $hr8;
	public $hr9;
	public $hr10;
	public $hr11;
	public $hr12;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghbasepriceroom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_type_id, hours, price', 'required'),
			array('room_type_id, hours', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('room_type_id, hours, price', 'safe', 'on'=>'search'),
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
			'refUsercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'refUserupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'refRoomtype' => array(self::BELONGS_TO, 'Roomtype', 'room_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hr24'=> '24 Hours',
			'hr0'=> '1 Night',
			'hr1'=> '1 Hours',
			'hr2'=> '2 Hours',
			'hr3'=> '3 Hours',
			'hr4'=> '4 Hours',
			'hr5'=> '5 Hours',
			'hr6'=> '6 Hours',
			'hr7'=> '7 Hours',
			'hr8'=> '8 Hours',
			'hr9'=> '9 Hours',
			'hr10'=> '10 Hours',
			'hr11'=> '11 Hours',
			'hr12'=> '12 Hours',
			'room_type_id' => 'Room',
			'hours' => 'Hours',
			'price' => 'Price',
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

		$criteria->compare('room_type_id',$this->room_type_id);
		$criteria->compare('hours',$this->hours);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Basepriceroom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
