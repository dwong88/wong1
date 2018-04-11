<?php

/**
 * This is the model class for table "tghpromosi".
 *
 * The followings are the available columns in table 'tghpromosi':
 * @property string $promosi_id
 * @property string $promosi_name
 * @property double $amount
 * @property integer $promosi_code
 * @property string $date_start
 * @property string $date_end
 * @property string $promosi_status
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Promosi extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghpromosi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promosi_name, amount, promosi_code, date_start, date_end, promosi_status', 'required'),
			array('promosi_code, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('promosi_name', 'length', 'max'=>100),
			array('promosi_status', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('promosi_id, promosi_name, amount, promosi_code, date_start, date_end, promosi_status, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'promosi_id' => 'Promosi',
			'promosi_name' => 'Promosi Name',
			'amount' => 'Amount',
			'promosi_code' => 'Promosi Code',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
			'promosi_status' => 'Promosi Status',
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

		$criteria->compare('promosi_id',$this->promosi_id,true);
		$criteria->compare('promosi_name',$this->promosi_name,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('promosi_code',$this->promosi_code);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('promosi_status',$this->promosi_status,true);
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
	 * @return Promosi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
