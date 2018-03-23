<?php

/**
 * This is the model class for table "vwmenu".
 *
 * The followings are the available columns in table 'vwmenu':
 * @property integer $menu_id
 * @property integer $parent_id
 * @property string $parent_menu_name
 * @property string $menu_name
 * @property string $default_url
 * @property integer $menu_order
 * @property integer $is_active
 * @property string $active_status
 */
class Vwmenu extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vwmenu the static model class
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
		return 'vwmenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, menu_name, menu_order, is_active', 'required'),
			array('menu_id, parent_id, menu_order, is_active', 'numerical', 'integerOnly'=>true),
			array('parent_menu_name, menu_name', 'length', 'max'=>100),
			array('default_url', 'length', 'max'=>255),
			array('active_status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, parent_id, parent_menu_name, menu_name, default_url, menu_order, is_active, active_status', 'safe', 'on'=>'search'),
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
			'menu_id' => 'Menu',
			'parent_id' => 'Parent',
			'parent_menu_name' => 'Parent Menu Name',
			'menu_name' => 'Menu Name',
			'default_url' => 'Default Url',
			'menu_order' => 'Menu Order',
			'is_active' => 'Is Active',
			'active_status' => 'Active Status',
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

		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('parent_menu_name',$this->parent_menu_name,true);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('default_url',$this->default_url,true);
		$criteria->compare('menu_order',$this->menu_order);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('active_status',$this->active_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function primaryKey()
	{
		return 'menu_id';
	}

}