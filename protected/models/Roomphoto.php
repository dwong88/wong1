<?php

/**
 * This is the model class for table "tghroomphoto".
 *
 * The followings are the available columns in table 'tghroomphoto':
 * @property string $photo_id
 * @property integer $room_id
 * @property integer $roomphototype_id
 * @property string $filename
 * @property string $create_dt
 * @property integer $create_by
 * @property string $update_dt
 * @property integer $update_by
 */
class Roomphoto extends ActiveRecord
{
	public $doc;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tghroomphoto';
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
			array('doc','file','allowEmpty'=>true,'types'=>array('jpg','jpeg','png'),'maxSize'=>1024*1024*10,'tooLarge'=>'Ukuran File harus lebih kecil dari 10MB'),
			array('room_id, roomphototype_id', 'required'),
			array('room_id, roomphototype_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('photo_id, room_id, roomphototype_id, filename, create_dt, create_by, update_dt, update_by', 'safe', 'on'=>'search'),
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
			'refRoomphototype' => array(self::BELONGS_TO, 'Roomphototype', 'roomphototype_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'photo_id' => 'Photo',
			'room_id' => 'Room',
			'roomphototype_id' => 'Roomphototype',
			'filename' => 'Filename',
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

		$criteria->compare('photo_id',$this->photo_id,true);
		$criteria->compare('room_id',$this->room_id);
		$criteria->compare('roomphototype_id',$this->roomphototype_id);
		$criteria->compare('filename',$this->filename,true);
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
	 * @return Roomphoto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
