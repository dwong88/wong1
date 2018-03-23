<?php
Yii::import('system.web.widgets.CActiveForm');
class ActiveForm extends CActiveForm
{
	/**
	 * Renders a dropdown list for a model attribute.
	 * This method is a wrapper of {@link CHtml::activeDropDownList}.
	 * Please check {@link CHtml::activeDropDownList} for detailed information
	 * about the parameters for this method.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data data for generating the list options (value=>display)
	 * @param array $htmlOptions additional HTML attributes.
	 * @return string the generated drop down list
	 */
	public function dropDownListOne($model,$attribute,$data,$htmlOptions=array())
	{
		if($model->scenario == 'insert' && empty($model->$attribute) && count($data) == 1)  {
			
			foreach($data as $val=>$dis)
				$model->$attribute = $val;
		}
		return parent::dropDownList($model, $attribute, $data, $htmlOptions);
	}
}