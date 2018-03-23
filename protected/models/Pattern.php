<?php

/**
 * This is the model class for table "tdppattern".
 *
 * The followings are the available columns in table 'tdppattern':
 * @property integer $pattern_id
 * @property string $pattern_group
 * @property string $pattern_sub
 * @property integer $pattern_length
 * @property string $pattern_value
 * @property integer $increment
 * @property integer $pattern_order
 */
class Pattern extends  CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pattern the static model class
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
		return 'tdppattern';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('pattern_group, pattern_sub, pattern_length, pattern_value, increment, pattern_order', 'required'),
		array('pattern_length, increment, pattern_order', 'numerical', 'integerOnly'=>true),
		array('pattern_group', 'length', 'max'=>50),
		array('pattern_sub', 'length', 'max'=>20),
		array('pattern_value', 'length', 'max'=>100),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('pattern_id, pattern_group, pattern_sub, pattern_length, pattern_value, increment, pattern_order', 'safe', 'on'=>'search'),
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
			'pattern_id' => 'Pattern',
			'pattern_group' => 'Pattern Group',
			'pattern_sub' => 'Pattern Sub',
			'pattern_length' => 'Pattern Length',
			'pattern_value' => 'Pattern Value',
			'increment' => 'Increment',
			'pattern_order' => 'Pattern Order',
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

		$criteria->compare('pattern_id',$this->pattern_id);
		$criteria->compare('pattern_group',$this->pattern_group,true);
		$criteria->compare('pattern_sub',$this->pattern_sub,true);
		$criteria->compare('pattern_length',$this->pattern_length);
		$criteria->compare('pattern_value',$this->pattern_value,true);
		$criteria->compare('increment',$this->increment);
		$criteria->compare('pattern_order',$this->pattern_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Generate code from pattern given<br>
	 * Pattern sub consist of 2 type: <br>
	 * <ol>
	 * <li>value</li>
	 * <li>function</li>
	 * </ol>
	 * <b>Value</b> can be autoincrement and the step is defined in increment field<br />
	 * <b>Function</b> must be defined as static method in Pattern class<br />
	 * it will generated as: Pattern::<function_name>;<br /><br />
	 * <b>NOTE: This function will only get value from pattern. It cannot increment the autoincrement value.<br />To Increment the value, you can use</b>
	 * <code>Pattern::increment_pattern_value($pattern_group);</code>
	 * @param string $pattern_group name of pattern group
	 */
	public static function generate($pattern_group) {
		$condition = new CDbCriteria;
		$condition->condition = "pattern_group=:pg";
		$condition->params = array(":pg" => $pattern_group);
		$condition->order = "pattern_order ASC";
		$model = self::model()->findAll($condition);

		$output = "";

		foreach($model as $data)
		{
			$sub = $data->pattern_sub;
			$length = intval($data->pattern_length);
			$value = $data->pattern_value;
			$increment = intval($data->increment);
			if($sub=='value')
			{
				if($increment!==0)
				{
					$value = intval($value);
					$value += $increment;
					$length_for_increment = strlen($value);
					for($i=$length_for_increment;$i<$length;$i++)
					{
						$value = '0'.$value;
					}
				}
			}
			else if($sub=='function')
			{
				$temp_value = $value;
				$value = "";
				$value = @eval('return Pattern::'.$temp_value.';');
			}
			$output .= $value;
			
		}
		return $output;
	}

	/**
	 * Use this function to increment the autoincrement field in pattern.
	 * @param string $pattern_group name of pattern group
	 */
	public static function increase($pattern_group)
	{
		$condition = new CDbCriteria;
		$condition->condition = "pattern_group=:pg";
		$condition->params = array(":pg" => $pattern_group);
		$condition->order = "pattern_order ASC";
		$model = self::model()->findAll($condition);

		foreach($model as $data) {
			$sub = $data->pattern_sub;
			$length = intval($data->pattern_length);
			$value = intval($data->pattern_value);
			$increment = intval($data->increment);
			if($sub=='value') {
				if($increment!==0) {
					$data->pattern_value = $value+$increment;
					$data->save();
				}
			}
		}
	}
	
	public static function monthInRoman($mth = '')
	{
		$dt;
		if($mth == '') $dt = date('n');
		else $dt = $mth;
		switch($dt)
		{
			case 1: return 'I';
			case 2: return 'II';
			case 3: return 'III';
			case 4: return 'IV';
			case 5: return 'V';
			case 6: return 'VI';
			case 7: return 'VII';
			case 8: return 'VIII';
			case 9: return 'IX';
			case 10: return 'X';
			case 11: return 'XI';
			case 12: return 'XII';
		}
		return "";
	}

	public static function getDate($format) {
		return date($format);
	}
}