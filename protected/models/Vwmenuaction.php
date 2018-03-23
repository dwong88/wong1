<?php

/**
 * This is the model class for table "vwmenuaction".
 *
 * The followings are the available columns in table 'vwmenuaction':
 * @property integer $menuaction_id
 * @property integer $menu_id
 * @property string $menu_name
 * @property string $menuaction_desc
 * @property string $action_url
 * @property integer $group_id
 * @property string $group_name
 */
class Vwmenuaction extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vwmenuaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vwmenuaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id, menu_name, menuaction_desc, action_url, group_id, group_name', 'required'),
			array('menuaction_id, menu_id, group_id', 'numerical', 'integerOnly'=>true),
			array('menu_name, group_name', 'length', 'max'=>100),
			array('action_url', 'length', 'max'=>225),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menuaction_id, menu_id, menu_name, menuaction_desc, action_url, group_id, group_name', 'safe', 'on'=>'search'),
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
			'menuaction_id' => 'Menuaction',
			'menu_id' => 'Menu',
			'menu_name' => 'Menu Name',
			'menuaction_desc' => 'Menuaction Desc',
			'action_url' => 'Action Url',
			'group_id' => 'Group',
			'group_name' => 'Group Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('menuaction_id',$this->menuaction_id);
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('menuaction_desc',$this->menuaction_desc,true);
		$criteria->compare('action_url',$this->action_url,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('group_name',$this->group_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function primaryKey()
	{
		return 'menuaction_id';
	}
}