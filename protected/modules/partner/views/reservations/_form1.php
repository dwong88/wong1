<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reservations-form',
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
		<?php echo $form->labelEx($model,'customer_name'); ?>
		<?php echo $form->textField($model,'customer_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid'); ?>
		<?php echo $form->textField($model,'paid'); ?>
		<?php echo $form->error($model,'paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_dt'); ?>
		<?php echo $form->textField($model,'create_dt'); ?>
		<?php echo $form->error($model,'create_dt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by'); ?>
		<?php echo $form->error($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_dt'); ?>
		<?php echo $form->textField($model,'update_dt'); ?>
		<?php echo $form->error($model,'update_dt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
		<?php echo $form->error($model,'update_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->