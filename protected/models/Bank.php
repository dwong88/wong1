<?php

/**
 * This is the model class for table "tdpbank".
 *
 * The followings are the available columns in table 'tdpbank':
 * @property string $bank_cd
 * @property string $bank_name
 * @property integer $create_by
 * @property string $create_dt
 * @property integer $update_by
 * @property string $update_dt
 */
class Bank extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
	 */
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tdpbank';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_cd, bank_name', 'required', 'on'=>'insert'),
			array('bank_cd', 'length', 'max'=>30, 'on'=>'insert'),
			array('bank_name', 'required', 'on'=>'update'),
			array('bank_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bank_cd, bank_name, create_by, create_dt, update_by, update_dt', 'safe', 'on'=>'search'),
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
			'bank_cd' => 'Bank Code',
			'bank_name' => 'Bank Name',
			'create_by' => 'Create By',
			'create_dt' => 'Create Date',
			'update_by' => 'Update By',
			'update_dt' => 'Update Date',
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

		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('update_dt',$this->update_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bank the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
