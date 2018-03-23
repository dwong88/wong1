<?php

/**
 * This is the model class for table "tdptestdetail".
 *
 * The followings are the available columns in table 'tdptestdetail':
 * @property integer $testdetail_id
 * @property integer $test_id
 * @property string $receive_dt
 * @property string $currency_cd
 * @property string $price
 * @property string $notes
 */
class Testdetail extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tdptestdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receive_dt', 'application.components.validator.DatePickerSwitcherValidator'),
			array('price','application.components.validator.NumberSwitcherValidator'),
			array('test_id, receive_dt, currency_cd, price, notes', 'required'),
			array('test_id', 'numerical', 'integerOnly'=>true),
			array('currency_cd', 'length', 'max'=>5),
			array('price', 'length', 'max'=>17),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('testdetail_id, test_id, receive_dt, currency_cd, price, notes', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'testdetail_id' => 'Testdetail',
			'test_id' => 'Test',
			'receive_dt' => 'Receive Dt',
			'currency_cd' => 'Currency Cd',
			'price' => 'Price',
			'notes' => 'Notes',
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

		$criteria->compare('testdetail_id',$this->testdetail_id);
		$criteria->compare('test_id',$this->test_id);
		$criteria->compare('receive_dt',$this->receive_dt,true);
		$criteria->compare('currency_cd',$this->currency_cd,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Testdetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
