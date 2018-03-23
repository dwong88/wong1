<?php

/**
 * This is the model class for table "tmastertype".
 *
 * The followings are the available columns in table 'tmastertype':
 * @property integer $mastertype_id
 * @property string $mastertype_code
 * @property string $mastertype_name
 * @property string $table_name
 * @property integer $create_by
 * @property string $create_dt
 * @property integer $update_by
 * @property string $update_dt
 */
class Mastertype extends ActiveRecord
{
	const TABLE_RELIGION = 'TRELIGION';
	const TABLE_MARITAL_STATUS = 'TMARITALSTATUS';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmastertype';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mastertype_code, mastertype_name', 'required'),
			array('mastertype_code', 'length', 'max'=>50),
			array('mastertype_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mastertype_code, mastertype_name, table_name, create_by, create_dt, update_by, update_dt', 'safe', 'on'=>'search'),
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
			'mastertype_code' => 'Code',
			'mastertype_name' => 'Name',
			'table_name' => 'Table Name',
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

		$criteria->compare('mastertype_code',$this->mastertype_code,true);
		$criteria->compare('mastertype_name',$this->mastertype_name,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('update_dt',$this->update_dt,true);

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
	 * @return Mastertype the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employee the static model class
	 */
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
}
