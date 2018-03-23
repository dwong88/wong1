<?php

/**
 * This is the model class for table "tloghistory".
 *
 * The followings are the available columns in table 'tloghistory':
 * @property integer $loghistory_id
 * @property string $table_name
 * @property string $primary_value
 * @property string $field_name
 * @property string $value_old
 * @property string $value_new
 * @property integer $update_by
 * @property string $update_dt
 */
class Loghistory extends ActiveRecord
{
	public $original_model;
	public $compare_table;
	public $differences;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tloghistory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table_name, primary_value, field_name, value_old, value_new', 'required'),
			array('update_by', 'numerical', 'integerOnly'=>true),
			array('table_name, field_name', 'length', 'max'=>50),
			array('primary_value', 'length', 'max'=>200),
			array('value_old, value_new', 'length', 'max'=>1000),
			array('update_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('loghistory_id, table_name, primary_value, field_name, value_old, value_new, update_by, update_dt', 'safe', 'on'=>'search'),
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
			'loghistory_id' => 'Loghistory',
			'table_name' => 'Table Name',
			'primary_value' => 'Primary Value',
			'field_name' => 'Field Name',
			'value_old' => 'Value Old',
			'value_new' => 'Value New',
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

		$criteria->compare('loghistory_id',$this->loghistory_id);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('primary_value',$this->primary_value,true);
		$criteria->compare('field_name',$this->field_name,true);
		$criteria->compare('value_old',$this->value_old,true);
		$criteria->compare('value_new',$this->value_new,true);
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
	 * @return Loghistory the static model class
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
	
	/**
	 * 
	 * @param CActiveRecord $model
	 */
	public function setOriginalModel($model)
	{
		$this->original_model = clone $model;
		$this->compare_table = $model->tableName();
	}
	
	/**
	 * WT 20140329 : mencari kolom yang diupdate, lalu menyimpannya di variable $differences 
	 * 
	 * @param array $targetAttributes POST variable dari $original_model
	 */
	public function isDifferences($targetAttributes)
	{
		foreach ($targetAttributes as $key=>$val)
		{
			if($this->original_model->$key != $val)
			{
				$this->differences[$key] = array('old'=>$this->original_model->$key, 'new'=>$val);
			}
		}
		
		return (count($this->differences) > 0)? true : false;
	}
	
	public function saveDifferences()
	{
		$arrPrimaryKey = $this->original_model->tableSchema->primaryKey;
		if(!is_array($arrPrimaryKey)) $arrPrimaryKey = array($arrPrimaryKey);
		
		$primaryValue = '';
		foreach($arrPrimaryKey as $idx=>$pKey)
		{
			$primaryValue .= $pKey.'='.$this->original_model->$pKey.((($idx+1) < count($arrPrimaryKey))? ';': '');
		}
		
		foreach($this->differences as $field=>$val)
		{
			DAO::executeSql("Insert into tloghistory (`table_name`, `primary_value`, `field_name`, `value_old`, `value_new`, `update_by`, `update_dt`)
					value (:tnm, :pval, :fnm, :vold, :vnew, :upby, :updt)", array(':tnm'=>$this->compare_table, ':pval'=>$primaryValue, ':fnm'=>$field, ':vold'=>$val['old'], ':vnew'=>$val['new'], ':upby'=>Yii::app()->user->id, ':updt'=>Yii::app()->datetime->getDateTimeNow()));
		}
	}
}
