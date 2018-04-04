<?php

/**
 * This is the model class for table "tghcity".
 *
 * The followings are the available columns in table 'tghcity':
 * @property string $city_id
 * @property integer $state_id
 * @property integer $postal_code
 * @property string $city_name
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class City extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghcity';
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
			array('state_id', 'required'),
			array('state_id', 'numerical', 'integerOnly'=>true),
			array('city_name', 'length', 'max'=>30),
            array('postal_code', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, state_id, postal_code, city_name, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
            'refState' => array(self::BELONGS_TO, 'State', 'state_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'City',
			'state_id' => 'State',
			'postal_code' => 'Postal Code',
			'city_name' => 'City Name',
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

		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('postal_code',$this->postal_code);
		$criteria->compare('city_name',$this->city_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
