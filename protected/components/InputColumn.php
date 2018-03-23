<?php
class InputColumn
{
	public static function textField($model, $attribute, $htmlOptions=array())
	{
		$att = $attribute.'[]';
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=CHtml::resolveName($model,$att);
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']='';
		
		return CHtml::activeTextField($model, $attribute, $htmlOptions);
	}
	
	public static function dropDownList($model,$attribute,$data,$htmlOptions=array())
	{
		$att = $attribute.'[]';
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=CHtml::resolveName($model,$att);
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']='';
		
		return CHtml::activeDropDownList($model,$attribute,$data,$htmlOptions);
	}
	
	public static function textArea($model,$attribute,$htmlOptions=array())
	{
		$att = $attribute.'[]';
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=CHtml::resolveName($model,$att);
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']='';
		
		return CHtml::activeTextArea($model,$attribute,$htmlOptions);
	}
	
	public static function hiddenField($model,$attribute,$htmlOptions=array())
	{
		$att = $attribute.'[]';
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=CHtml::resolveName($model,$att);
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']='';
		
		return CHtml::activeHiddenField($model,$attribute,$htmlOptions);
	}
	
	public static function dateField($model, $attribute, $htmlOptions=array())
	{
		$att = $attribute.'[]';
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=CHtml::resolveName($model,$att);
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']='';
		
		if(!empty($model->$attribute))
		{
			$model->$attribute = date(Yii::app()->params['datepick_phpDateFormat'], strtotime($model->$attribute));
		}
		
		return CHtml::activeTextField($model, $attribute, $htmlOptions);
	}
}