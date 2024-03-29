<?php

/**
 * This is the model class for table "tghroomtypebed".
 *
 * The followings are the available columns in table 'tghroomtypebed':
 * @property string $room_type_bed_id
 * @property integer $room_type_id
 * @property integer $master_bed_id
 * @property integer $room_type_bed_quantity_room
 */
class Roomtypebed extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghroomtypebed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_type_id', 'required'),
			array('master_bed_id', 'required'),
			array('master_bed_id', 'numerical', 'integerOnly'=>true),
			array('room_type_bed_quantity_room', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('room_type_bed_id, room_type_id, master_bed_id, room_type_bed_quantity_room', 'safe', 'on'=>'search'),
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
            'refRoomtype' => array(self::BELONGS_TO, 'Roomtype', 'room_type_id'),
            'refMasterbed' => array(self::BELONGS_TO, 'Masterbed', 'master_bed_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'room_type_bed_id' => 'Room Type Bed',
			'room_type_id' => 'Room Type',
			'master_bed_id' => 'Master Bed',
			'room_type_bed_quantity_room' => 'Room Type Bed Quantity Room',
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

		$criteria->compare('room_type_bed_id',$this->room_type_bed_id,true);
		$criteria->compare('room_type_id',$this->room_type_id);
		$criteria->compare('master_bed_id',$this->master_bed_id);
		$criteria->compare('room_type_bed_quantity_room',$this->room_type_bed_quantity_room);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roomtypebed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
