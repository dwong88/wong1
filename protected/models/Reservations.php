<?php

/**
 * This is the model class for table "tghreservations".
 *
 * The followings are the available columns in table 'tghreservations':
 * @property string $reservations_id
 * @property string $customer_name
 * @property string $email
 * @property string $phone
 * @property string $start_date
 * @property string $end_date
 * @property string $room_id
 * @property string $adult
 * @property string $child
 * @property string $infant
 * @property string $status
 * @property string $type
 * @property string $country_id
 * @property integer $paid
 * @property string $guest_comment
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Reservations extends ActiveRecord
{
	public $property_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghreservations';
	}

	#scenario insert create_dt etc
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
			array('start_date', 'application.components.validator.DatePickerSwitcherValidator'),
			array('end_date', 'application.components.validator.DatePickerSwitcherValidator'),
			array('customer_name, start_date, end_date', 'required'),
			array('room_id,country_id,adult,child,infant,paid, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('customer_name,email,phone', 'length', 'max'=>50),
			array('guest_comment', 'length', 'max'=>255),
			array('status,type', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('reservations_id, customer_name, start_date, end_date,room_id , type, status, paid, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'refCity' => array(self::BELONGS_TO, 'City', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reservations_id' => 'Reservations',
			'customer_name' => 'Customer Name',
			'email' => 'Email',
			'phone' => 'phone',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'type' => 'Type',
			'country_id' => 'Country',
			'adult' => 'Adult',
			'child' => 'Child',
			'infant' => 'Infant',
			'status' => 'Status',
			'paid' => 'Paid',
			'guest_comment' => 'Comment',
			'create_dt' => 'Create Dt',
			'create_by' => 'Create By',
			'update_dt' => 'Update Dt',
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

		$criteria->compare('reservations_id',$this->reservations_id,true);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('adult',$this->adult,true);
		$criteria->compare('child',$this->child,true);
		$criteria->compare('infant',$this->infant,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('guest_comment',$this->guest_comment,true);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_dt',$this->update_dt,true);
		$criteria->compare('update_by',$this->update_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reservations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
