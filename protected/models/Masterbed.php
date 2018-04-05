<?php

/**
 * This is the model class for table "tghmasterbed".
 *
 * The followings are the available columns in table 'tghmasterbed':
 * @property integer $master_bed_id
 * @property string $master_bed_name
 * @property integer $master_bed_capacity
 * @property string $master_bed_size
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Masterbed extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghmasterbed';
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
			
			array('master_bed_name', 'length', 'max'=>50),
			array('master_bed_size', 'length', 'max'=>20),
            array('master_bed_capacity', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('master_bed_id, master_bed_name, master_bed_capacity, master_bed_size, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'master_bed_id' => 'Master Bed',
			'master_bed_name' => 'Master Bed Name',
			'master_bed_capacity' => 'Master Bed Capacity',
			'master_bed_size' => 'Master Bed Size',
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

		$criteria->compare('master_bed_id',$this->master_bed_id);
		$criteria->compare('master_bed_name',$this->master_bed_name,true);
		$criteria->compare('master_bed_capacity',$this->master_bed_capacity);
		$criteria->compare('master_bed_size',$this->master_bed_size,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Masterbed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
