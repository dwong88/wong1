<?php

/**
 * This is the model class for table "tdpcompanybranch".
 *
 * The followings are the available columns in table 'tdpcompanybranch':
 * @property integer $companybranch_id
 * @property integer $company_id
 * @property string $branch_code
 * @property string $branch_name
 * @property string $branch_addr
 * @property string $branch_phone
 * @property string $notes
 * @property integer $create_by
 * @property string $create_dt
 * @property integer $update_by
 * @property string $update_dt
 */
class Companybranch extends ActiveRecord
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
		return 'tdpcompanybranch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, branch_name', 'required'),
			array('company_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('branch_code', 'length', 'max'=>50),
			array('branch_name', 'length', 'max'=>100),
			array('branch_phone', 'length', 'max'=>40),
			array('branch_addr, notes, update_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('companybranch_id, company_id, branch_code, branch_name, branch_addr, branch_phone, notes, create_by, create_dt, update_by, update_dt', 'safe', 'on'=>'search'),
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
			'refCompany' => array(self::BELONGS_TO, 'Company', 'company_id'),
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
			'companybranch_id' => 'Companybranch',
			'company_id' => 'Company',
			'branch_code' => 'Branch Code',
			'branch_name' => 'Branch Name',
			'branch_addr' => 'Address',
			'branch_phone' => 'Phone',
			'notes' => 'Notes',
			'create_by' => 'Create By',
			'create_dt' => 'Create Dt',
			'update_by' => 'Update By',
			'update_dt' => 'Update Dt',
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

		$criteria->compare('companybranch_id',$this->companybranch_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('branch_code',$this->branch_code,true);
		$criteria->compare('branch_name',$this->branch_name,true);
		$criteria->compare('branch_addr',$this->branch_addr,true);
		$criteria->compare('branch_phone',$this->branch_phone,true);
		$criteria->compare('notes',$this->notes,true);
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
	 * @return Companybranch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
