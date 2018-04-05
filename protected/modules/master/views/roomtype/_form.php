<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roomtype-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	<div class="row">
		<?php echo $form->labelEx($model,'property_id'); ?>
		<?php echo $form->dropDownList($model,'property_id', CHtml::listData(Property::model()->findAll(), 'property_id', 'property_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'property_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_name'); ?>
		<?php echo $form->textField($model,'room_type_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'room_type_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_desc'); ?>
		<?php echo $form->textArea($model,'room_type_desc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'room_type_desc'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'room_type_cleaning_minutes'); ?>
		<?php echo $form->textField($model,'room_type_cleaning_minutes'); ?>
		<?php echo $form->error($model,'room_type_cleaning_minutes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_availability_threshold'); ?>
		<?php echo $form->textField($model,'room_type_availability_threshold'); ?>
		<?php echo $form->error($model,'room_type_availability_threshold'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_minimum_availability_threshold'); ?>
		<?php echo $form->textField($model,'room_type_minimum_availability_threshold'); ?>
		<?php echo $form->error($model,'room_type_minimum_availability_threshold'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_default_minimum_stay'); ?>
		<?php echo $form->textField($model,'room_type_default_minimum_stay'); ?>
		<?php echo $form->error($model,'room_type_default_minimum_stay'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_default_maximum_stay'); ?>
		<?php echo $form->textField($model,'room_type_default_maximum_stay'); ?>
		<?php echo $form->error($model,'room_type_default_maximum_stay'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_rack_rate'); ?>
		<?php echo $form->textField($model,'room_type_rack_rate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'room_type_rack_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_default_extra_child_rate'); ?>
		<?php echo $form->textField($model,'room_type_default_extra_child_rate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'room_type_default_extra_child_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_default_extra_adult_rate'); ?>
		<?php echo $form->textField($model,'room_type_default_extra_adult_rate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'room_type_default_extra_adult_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_default_infant_rate'); ?>
		<?php echo $form->textField($model,'room_type_default_infant_rate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'room_type_default_infant_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_included_occupants'); ?>
		<?php echo $form->textField($model,'room_type_included_occupants'); ?>
		<?php echo $form->error($model,'room_type_included_occupants'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_maximum_occupants'); ?>
		<?php echo $form->textField($model,'room_type_maximum_occupants'); ?>
		<?php echo $form->error($model,'room_type_maximum_occupants'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_adult_required'); ?>
		<?php echo $form->textField($model,'room_type_adult_required'); ?>
		<?php echo $form->error($model,'room_type_adult_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_room_size'); ?>
		<?php echo $form->textField($model,'room_type_room_size',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'room_type_room_size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_bed_size'); ?>
		<?php echo $form->textField($model,'room_type_bed_size',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'room_type_bed_size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_guest_capacity'); ?>
		<?php echo $form->textField($model,'room_type_guest_capacity'); ?>
		<?php echo $form->error($model,'room_type_guest_capacity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_total_room'); ?>
		<?php echo $form->textField($model,'room_type_total_room'); ?>
		<?php echo $form->error($model,'room_type_total_room'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->