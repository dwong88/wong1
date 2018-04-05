<?php

/**
 * This is the model class for table "tghroomtype".
 *
 * The followings are the available columns in table 'tghroomtype':
 * @property string $room_type_id
 * @property integer $property_id
 * @property string $room_type_name
 * @property string $room_type_desc
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 * @property integer $room_type_cleaning_minutes
 * @property integer $room_type_availability_threshold
 * @property integer $room_type_minimum_availability_threshold
 * @property integer $room_type_default_minimum_stay
 * @property integer $room_type_default_maximum_stay
 * @property string $room_type_rack_rate
 * @property string $room_type_default_extra_child_rate
 * @property string $room_type_default_extra_adult_rate
 * @property string $room_type_default_infant_rate
 * @property integer $room_type_included_occupants
 * @property integer $room_type_maximum_occupants
 * @property integer $room_type_adult_required
 * @property string $room_type_room_size
 * @property string $room_type_bed_size
 * @property integer $room_type_guest_capacity
 * @property integer $room_type_total_room
 */
class Roomtype extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghroomtype';
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
            array('room_type_rack_rate, room_type_default_extra_child_rate, room_type_default_extra_adult_rate, room_type_default_infant_rate','application.components.validator.NumberSwitcherValidator'),
			array('property_id', 'required'),
			array('property_id', 'numerical', 'integerOnly'=>true),
			array('room_type_name', 'required'),
			array('room_type_desc', 'length', 'max'=>100),
			array('room_type_cleaning_minutes', 'length', 'max'=>6),
			array('room_type_availability_threshold', 'required'),
			array('room_type_minimum_availability_threshold', 'length', 'max'=>6),
			array('room_type_default_minimum_stay', 'length', 'max'=>6),
			array('room_type_default_maximum_stay', 'length', 'max'=>6),
            
			array('room_type_rack_rate', 'required'),
			array('room_type_default_extra_child_rate', 'required'),
			array('room_type_default_extra_adult_rate', 'required'),
			array('room_type_default_infant_rate', 'required'),
            
			array('room_type_included_occupants', 'required'),
			array('room_type_maximum_occupants', 'required'),
			array('room_type_adult_required', 'required'),
			array('room_type_room_size', 'length', 'max'=>20),
			array('room_type_bed_size', 'length', 'max'=>20),
			array('room_type_guest_capacity', 'length', 'max'=>6),
			array('room_type_total_room', 'length', 'max'=>4),

			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('room_type_id, property_id, room_type_name, room_type_desc, create_dt, create_by, update_dt, update_by, room_type_cleaning_minutes, room_type_availability_threshold, room_type_minimum_availability_threshold, room_type_default_minimum_stay, room_type_default_maximum_stay, room_type_rack_rate, room_type_default_extra_child_rate, room_type_default_extra_adult_rate, room_type_default_infant_rate, room_type_included_occupants, room_type_maximum_occupants, room_type_adult_required, room_type_room_size, room_type_bed_size, room_type_guest_capacity, room_type_total_room', 'safe', 'on'=>'search'),
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
            'refProperty' => array(self::BELONGS_TO, 'Property', 'property_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'room_type_id' => 'Room Type',
			'property_id' => 'Property Id',
			'room_type_name' => 'Name',
			'room_type_desc' => 'Desc',
			'create_dt' => 'Create Date',
			'create_by' => 'Create By',
			'update_dt' => 'Update Date',
			'update_by' => 'Update By',
			'room_type_cleaning_minutes' => 'Cleaning Minutes',
			'room_type_availability_threshold' => 'Availability Threshold',
			'room_type_minimum_availability_threshold' => 'Minimum Availability Threshold',
			'room_type_default_minimum_stay' => 'Default Minimum Stay',
			'room_type_default_maximum_stay' => 'Default Maximum Stay',
			'room_type_rack_rate' => 'Rack Rate',
			'room_type_default_extra_child_rate' => 'Default Extra Child Rate',
			'room_type_default_extra_adult_rate' => 'Default Extra Adult Rate',
			'room_type_default_infant_rate' => 'Default Infant Rate',
			'room_type_included_occupants' => 'Included Occupants',
			'room_type_maximum_occupants' => 'Maximum Occupants',
			'room_type_adult_required' => 'Adult Required',
			'room_type_room_size' => 'Room Size',
			'room_type_bed_size' => 'Bed Size',
			'room_type_guest_capacity' => 'Guest Capacity',
			'room_type_total_room' => 'Total Room',
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

		$criteria->compare('room_type_id',$this->room_type_id,true);
		$criteria->compare('property_id',$this->property_id);
		$criteria->compare('room_type_name',$this->room_type_name,true);
		$criteria->compare('room_type_desc',$this->room_type_desc,true);
		
		$criteria->compare('room_type_cleaning_minutes',$this->room_type_cleaning_minutes);
		$criteria->compare('room_type_availability_threshold',$this->room_type_availability_threshold);
		$criteria->compare('room_type_minimum_availability_threshold',$this->room_type_minimum_availability_threshold);
		$criteria->compare('room_type_default_minimum_stay',$this->room_type_default_minimum_stay);
		$criteria->compare('room_type_default_maximum_stay',$this->room_type_default_maximum_stay);
		$criteria->compare('room_type_rack_rate',$this->room_type_rack_rate,true);
		$criteria->compare('room_type_default_extra_child_rate',$this->room_type_default_extra_child_rate,true);
		$criteria->compare('room_type_default_extra_adult_rate',$this->room_type_default_extra_adult_rate,true);
		$criteria->compare('room_type_default_infant_rate',$this->room_type_default_infant_rate,true);
		$criteria->compare('room_type_included_occupants',$this->room_type_included_occupants);
		$criteria->compare('room_type_maximum_occupants',$this->room_type_maximum_occupants);
		$criteria->compare('room_type_adult_required',$this->room_type_adult_required);
		$criteria->compare('room_type_room_size',$this->room_type_room_size,true);
		$criteria->compare('room_type_bed_size',$this->room_type_bed_size,true);
		$criteria->compare('room_type_guest_capacity',$this->room_type_guest_capacity);
		$criteria->compare('room_type_total_room',$this->room_type_total_room);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roomtype the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
