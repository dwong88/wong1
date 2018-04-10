<?php

/**
 * This is the model class for table "tghroom".
 *
 * The followings are the available columns in table 'tghroom':
 * @property string $room_id
 * @property integer $room_type_id
 * @property string $room_floor
 * @property string $room_name
 * @property string $room_status
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Room extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghroom';
	}

	public function __construct($scenario = 'insert')
    {
        parent::__construct($scenario);
        $this->logRecord=true;
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
			array('room_type_id', 'numerical', 'integerOnly'=>true),
			array('room_floor', 'length', 'max'=>30),
			array('room_name', 'length', 'max'=>50),
			array('room_status', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('room_id, room_type_id, room_floor, room_name, room_status, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'room_id' => 'Room',
			'room_type_id' => 'Room Type',
			'room_floor' => 'Room Floor',
			'room_name' => 'Room Name',
			'room_status' => 'Room Status',
			'create_dt' => 'Create Date',
			'create_by' => 'Create By',
			'update_dt' => 'Update Date',
			'update_by' => 'Update By',
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

		$criteria->compare('room_id',$this->room_id,true);
		$criteria->compare('room_type_id',$this->room_type_id);
		$criteria->compare('room_floor',$this->room_floor,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('room_status',$this->room_status,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Room the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
