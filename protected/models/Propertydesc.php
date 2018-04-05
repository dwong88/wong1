<?php

/**
 * This is the model class for table "tghpropertydesc".
 *
 * The followings are the available columns in table 'tghpropertydesc':
 * @property integer $property_id
 * @property string $lang
 * @property string $type
 * @property string $desc
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Propertydesc extends ActiveRecord
{
	public static $publicTypeDesc = array('toc', 'payment', 'cancel');
	public $cancel;
	public $toc;
	public $payment;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghpropertydesc';
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
			array('lang, desc', 'required'),
			array('lang', 'length', 'max'=>2),
			array('type', 'length', 'max'=>100),
			array('cancel, toc, payment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('property_id, lang, type, desc, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'property_id' => 'property_id',
			'lang' => 'Language',
			'type' => 'Type',
			'desc' => 'Desc',
			'toc' => 'Terms And Conditions',
			'payment' => 'Payment Policy',
			'cancel' => 'Cancellation Policy',
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

		$criteria->compare('property_id',$this->property_id);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('desc',$this->desc,true);
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
	 * @return Propertydesc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
