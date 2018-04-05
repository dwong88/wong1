<?php

/**
 * This is the model class for table "tghproperty".
 *
 * The followings are the available columns in table 'tghproperty':
 * @property string $property_id
 * @property string $property_name
 * @property string $addressline1
 * @property string $addressline2
 * @property integer $cityid
 * @property string $postcode
 * @property string $suburb
 * @property integer $country
 * @property string $state
 * @property string $weekend_start
 * @property string $hotel_phone_number
 * @property string $phone_number
 * @property string $tax_number
 * @property string $minimumroomrate
 * @property string $star_rated
 * @property integer $numberofstar
 * @property integer $maximumchildage
 * @property integer $maximuminfantage
 * @property string $bookingconfirmationemail
 * @property string $bookingconfirmationccemail
 * @property string $enquiryemail
 * @property string $availabilityalertemail
 * @property string $description
 * @property string $gmaps_longitude
 * @property string $gmaps_latitude
 * @property string $available_cleaning_start
 * @property string $available_cleaning_end
 * @property string $locationinstruction
 * @property string $create_dt
 * @property string $create_by
 * @property string $update_dt
 * @property string $update_by
 */
class Property extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghproperty';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, country_id,state_id, numberofstar, maximumchildage, maximuminfantage', 'numerical', 'integerOnly'=>true),
			array('property_name, gmaps_longitude, gmaps_latitude', 'length', 'max'=>100),
			array('postal_code, minimumroomrate', 'length', 'max'=>5),
			array('suburb, bookingconfirmationemail, enquiryemail', 'length', 'max'=>50),
			array('weekend_start, create_by, update_by,available_cleaning_start, available_cleaning_end', 'length', 'max'=>10),
			array('hotel_phone_number, phone_number, tax_number, bookingconfirmationccemail, availabilityalertemail', 'length', 'max'=>11),
			array('star_rated', 'length', 'max'=>3),
			array('addressline1, addressline2, description, locationinstruction, create_dt, update_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('property_id, property_name, addressline1, addressline2, city_id, postal_code, suburb, country_id, state_id, weekend_start, hotel_phone_number, phone_number, tax_number, minimumroomrate, star_rated, numberofstar, maximumchildage, maximuminfantage, bookingconfirmationemail, bookingconfirmationccemail, enquiryemail, availabilityalertemail, description, gmaps_longitude, gmaps_latitude, available_cleaning_start, available_cleaning_end, locationinstruction, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'refCountry' => array(self::BELONGS_TO, 'Countries', 'country_id'),
			'refState' => array(self::BELONGS_TO, 'State', 'state_id'),
			'refCity' => array(self::BELONGS_TO, 'C', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'property_id' => 'Property ID',
			'property_name' => 'Property Name',
			'addressline1' => 'Address line1',
			'addressline2' => 'Address line2',
			'city_id' => 'City',
			'postal_code' => 'Postal code',
			'suburb' => 'Suburb',
			'country_id' => 'Country',
			'state_id' => 'State',
			'weekend_start' => 'Weekend Start',
			'hotel_phone_number' => 'Hotel Phone Number',
			'phone_number' => 'Phone Number',
			'tax_number' => 'Tax Number',
			'minimumroomrate' => 'Minimumroomrate',
			'star_rated' => 'Star Rated',
			'numberofstar' => 'Numberofstar',
			'maximumchildage' => 'Maximumchildage',
			'maximuminfantage' => 'Maximuminfantage',
			'bookingconfirmationemail' => 'Bookingconfirmationemail',
			'bookingconfirmationccemail' => 'Bookingconfirmationccemail',
			'enquiryemail' => 'Enquiryemail',
			'availabilityalertemail' => 'Availabilityalertemail',
			'description' => 'Description',
			'gmaps_longitude' => 'Gmaps Longitude',
			'gmaps_latitude' => 'Gmaps Latitude',
			'available_cleaning_start' => 'Available Cleaning Start',
			'available_cleaning_end' => 'Available Cleaning End',
			'locationinstruction' => 'Locationinstruction',
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

		$criteria->compare('property_id',$this->property_id,true);
		$criteria->compare('property_name',$this->property_name,true);
		$criteria->compare('addressline1',$this->addressline1,true);
		$criteria->compare('addressline2',$this->addressline2,true);
		$criteria->compare('city_id',$this->cityid);
		$criteria->compare('postal_code',$this->postcode,true);
		$criteria->compare('suburb',$this->suburb,true);
		$criteria->compare('country_id',$this->country);
		$criteria->compare('state_id',$this->state,true);
		$criteria->compare('weekend_start',$this->weekend_start,true);
		$criteria->compare('hotel_phone_number',$this->hotel_phone_number,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('tax_number',$this->tax_number,true);
		$criteria->compare('minimumroomrate',$this->minimumroomrate,true);
		$criteria->compare('star_rated',$this->star_rated,true);
		$criteria->compare('numberofstar',$this->numberofstar);
		$criteria->compare('maximumchildage',$this->maximumchildage);
		$criteria->compare('maximuminfantage',$this->maximuminfantage);
		$criteria->compare('bookingconfirmationemail',$this->bookingconfirmationemail,true);
		$criteria->compare('bookingconfirmationccemail',$this->bookingconfirmationccemail,true);
		$criteria->compare('enquiryemail',$this->enquiryemail,true);
		$criteria->compare('availabilityalertemail',$this->availabilityalertemail,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('gmaps_longitude',$this->gmaps_longitude,true);
		$criteria->compare('gmaps_latitude',$this->gmaps_latitude,true);
		$criteria->compare('available_cleaning_start',$this->available_cleaning_start,true);
		$criteria->compare('available_cleaning_end',$this->available_cleaning_end,true);
		$criteria->compare('locationinstruction',$this->locationinstruction,true);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_dt',$this->update_dt,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Property the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
}
