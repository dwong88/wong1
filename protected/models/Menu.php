<?php

/**
 * This is the model class for table "tdpmenu".
 *
 * The followings are the available columns in table 'tdpmenu':
 * @property integer $menu_id
 * @property integer $parent_id
 * @property string $menu_name
 * @property string $default_url
 * @property integer $menu_order
 * @property integer $is_active
 *
 * The followings are the available model relations:
 * @property Menuaction[] $menuactions
 */
class Menu extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return 'tdpmenu';
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
			array('parent_id, menu_order, is_active', 'numerical', 'integerOnly'=>true),
			array('menu_name', 'length', 'max'=>100),
			array('default_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, parent_id, menu_name, default_url, menu_order, is_active', 'safe', 'on'=>'search'),
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
			'menuactions' => array(self::HAS_MANY, 'Menuaction', 'menu_id','together'=>false,'order'=>'group_id ASC')
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
			'menu_name' => 'Menu Name',
			'default_url' => 'Default Url',
			'menu_order' => 'Menu Order',
			'is_active' => 'Is Active',
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
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('default_url',$this->default_url,true);
		$criteria->compare('menu_order',$this->menu_order);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAllMenuAsArray()
    {
        $list = array();
        foreach(self::model()->findAll() as $data)
        {
            $list[$data['menu_id']] = $data['menu_name'];
        }

        return $list;
    }
}