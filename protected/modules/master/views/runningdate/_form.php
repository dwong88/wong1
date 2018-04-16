<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'runningdate-form',
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
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'start_date',
		                                ));?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'end_date',
		                                ));?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
