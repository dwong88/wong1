<?php

/**
 * This is the model class for table "tghcountries".
 *
 * The followings are the available columns in table 'tghcountries':
 * @property integer $country_id
 * @property string $country_name
 * @property string $create_dt
 * @property string $create_by
 * @property string $update_dt
 * @property string $update_by
 */
class Countries extends ActiveRecord
{
	const TABLE_COUNTRIES = 'tghcountries';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghcountries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, country_name', 'required'),
			array('country_id,create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('country_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('country_id, country_name, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'country_id' => 'ID',
			'country_name' => 'Country Name',
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

		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('country_name',$this->country_name,true);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_dt',$this->update_dt,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'create_dt DESC',
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Countries the static model class
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
