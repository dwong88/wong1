<?php

/**
 * This is the model class for table "tghroompriceflexible".
 *
 * The followings are the available columns in table 'tghroompriceflexible':
 * @property string $price_id
 * @property integer $room_type_id
 * @property string $date
 * @property integer $hours
 * @property double $price
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Roompriceflexible extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghroompriceflexible';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_type_id, date, hours, price', 'required'),
			array('room_type_id, hours, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('price_id, room_type_id, date, hours, price, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'price_id' => 'Price',
			'room_type_id' => 'Room Type',
			'date' => 'Date',
			'hours' => 'Hours',
			'price' => 'Price',
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

		$criteria->compare('price_id',$this->price_id,true);
		$criteria->compare('room_type_id',$this->room_type_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hours',$this->hours);
		$criteria->compare('price',$this->price);
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
	 * @return Roompriceflexible the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
