<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'room-form',
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
		<?php echo $form->labelEx($model,'status_room_type_id'); ?>
		<?php echo $form->dropDownList($model,'status_room_type_id', CHtml::listData(Statusroomtype::model()->findAll(), 'status_room_type_id', 'status_room_type_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'status_room_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_id'); ?>
		<?php echo $form->dropDownList($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'room_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_floor'); ?>
		<?php echo $form->textField($model,'room_floor',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'room_floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_name'); ?>
		<?php echo $form->textField($model,'room_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'room_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_status'); ?>
		<?php echo $form->textArea($model,'room_status',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'room_status'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->