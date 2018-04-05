<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'room_type_id'); ?>
		<?php echo $form->textField($model,'room_type_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'property_id'); ?>
		<?php echo $form->textField($model,'property_id', CHtml::listData(Property::model()->findAll(), 'property_id', 'property_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_name'); ?>
		<?php echo $form->textField($model,'room_type_name',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_desc'); ?>
		<?php echo $form->textArea($model,'room_type_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'room_type_cleaning_minutes'); ?>
		<?php echo $form->textField($model,'room_type_cleaning_minutes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_availability_threshold'); ?>
		<?php echo $form->textField($model,'room_type_availability_threshold'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_minimum_availability_threshold'); ?>
		<?php echo $form->textField($model,'room_type_minimum_availability_threshold'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_default_minimum_stay'); ?>
		<?php echo $form->textField($model,'room_type_default_minimum_stay'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_default_maximum_stay'); ?>
		<?php echo $form->textField($model,'room_type_default_maximum_stay'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_rack_rate'); ?>
		<?php echo $form->textField($model,'room_type_rack_rate',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_default_extra_child_rate'); ?>
		<?php echo $form->textField($model,'room_type_default_extra_child_rate',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_default_extra_adult_rate'); ?>
		<?php echo $form->textField($model,'room_type_default_extra_adult_rate',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_default_infant_rate'); ?>
		<?php echo $form->textField($model,'room_type_default_infant_rate',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_included_occupants'); ?>
		<?php echo $form->textField($model,'room_type_included_occupants'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_maximum_occupants'); ?>
		<?php echo $form->textField($model,'room_type_maximum_occupants'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_adult_required'); ?>
		<?php echo $form->textField($model,'room_type_adult_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_room_size'); ?>
		<?php echo $form->textField($model,'room_type_room_size',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_bed_size'); ?>
		<?php echo $form->textField($model,'room_type_bed_size',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_guest_capacity'); ?>
		<?php echo $form->textField($model,'room_type_guest_capacity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_total_room'); ?>
		<?php echo $form->textField($model,'room_type_total_room'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->