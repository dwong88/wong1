<?php

/**
 * This is the model class for table "tdpcompany".
 *
 * The followings are the available columns in table 'tdpcompany':
 * @property integer $company_id
 * @property string $company_name
 * @property string $address
 * @property string $phone
 * @property string $fax
 * @property string $npwp_no
 * @property string $npwp_name
 * @property string $npwp_address
 * @property integer $create_by
 * @property string $create_dt
 * @property integer $update_by
 * @property string $update_dt
 */
class Company extends ActiveRecord
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
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tdpcompany';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name', 'required'),
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('company_name, npwp_name', 'length', 'max'=>255),
			array('phone, fax', 'length', 'max'=>200),
			array('npwp_no', 'length', 'max'=>30),
			array('address, npwp_address, update_dt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, company_name, address, phone, fax, npwp_no, npwp_name, npwp_address, create_by, create_dt, update_by, update_dt', 'safe', 'on'=>'search'),
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
			'company_id' => 'Company',
			'company_name' => 'Company Name',
			'address' => 'Address',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'npwp_no' => 'Npwp No',
			'npwp_name' => 'Npwp Name',
			'npwp_address' => 'Npwp Address',
			'create_by' => 'Create By',
			'create_dt' => 'Create Dt',
			'update_by' => 'Update By',
			'update_dt' => 'Update Dt',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('npwp_no',$this->npwp_no,true);
		$criteria->compare('npwp_name',$this->npwp_name,true);
		$criteria->compare('npwp_address',$this->npwp_address,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('update_dt',$this->update_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}