<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roomtypebed-form',
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
		<?php echo $form->labelEx($model,'room_type_id'); ?>
		<?php echo $form->dropDownList($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'room_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'master_bed_id'); ?>
		<?php echo $form->dropDownList($model,'master_bed_id', CHtml::listData(Masterbed::model()->findAll(), 'master_bed_id', 'master_bed_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'master_bed_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_bed_quantity_room'); ?>
		<?php echo $form->textField($model,'room_type_bed_quantity_room', array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'room_type_bed_quantity_room'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->