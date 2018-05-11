<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#roomtype_id').change(function() {
	var thisvalue = this.value;
	$('#Roompriceflexible_room_type_id').text(thisvalue);
	console.log(thisvalue);
});
							",
CClientScript::POS_READY
);
Helper::registerNumberField('#tnumber, .dtl-price');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roompriceflexible-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>'pure-form',
		),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	<?php
	if($_GET['id']!=NULL){
		echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/images/bed.png', 'Bed'), array('/master/roomtypebed/update', 'id'=>$vRoomType['room_type_id']), array('title'=>'Bed')).'&nbsp;';
	}
	?>
	<br>
	<?php Helper::showFlash(); ?>

	<?php
	echo $form->labelEx($model,'property_id');
	echo $form->dropDownList($model,'property_id', CHtml::listData(Property::model()->findAll(), 'property_id', 'property_name'),array(
		'prompt'=>'Select Property',
		'ajax' => array(
		'type'=>'POST',
		'url'=>Yii::app()->createUrl('core/globalsetting/loadroomtype'), //or $this->createUrl('loadcities') if '$this' extends CController
		'update'=>'#roomtype_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
		'data'=>array('property_id'=>'js:this.value'),
		)));
	?>
	<?php
		echo $form->labelEx($model,'room_type_id');
		echo CHtml::dropDownList('roomtype_id',$select_st,
		array($select_st=>$mStatec[0]['state_name']),
		array(
			'prompt'=>'Select Room Type',
			'ajax' => array(
			'type'=>'POST',
			'url'=>Yii::app()->createUrl('core/globalsetting/loadroom'), //or $this->createUrl('loadcities') if '$this' extends CController
			'update'=>'#room_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
		'data'=>array('room_type_id'=>'js:this.value'),
		)));
	?>
	<div class="row">
		<?php echo $form->hiddenField($model,'room_type_id',array('value'=>''));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'date',
		                                ));?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<?php

	foreach (Roompriceflexible::$publicTypePrice as $key => $value) {
	?>
	<div class="row">
		<?php echo $form->labelEx($model,$value); ?>
		<?php echo $form->textField($model,$value,array('size'=>10,'id'=>'tnumber','class'=>'dtl-price col-right')); ?>
	</div>
	<?php
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
