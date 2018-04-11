<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promosi-form',
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
		<?php echo $form->labelEx($model,'promosi_name'); ?>
		<?php echo $form->textField($model,'promosi_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'promosi_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'promosi_code'); ?>
		<?php echo $form->textField($model,'promosi_code'); ?>
		<?php echo $form->error($model,'promosi_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_start'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'date_start',
		                                ));?>
		<?php echo $form->error($model,'date_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'date_end',
		                                ));?>
		<?php echo $form->error($model,'date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'promosi_status'); ?>
		<?php echo $form->dropDownList($model, 'promosi_status', array('enable'=>'Enable', 'disable'=>'Disable'), array('prompt'=>'Status')); ?>
		<?php echo $form->error($model,'promosi_status'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
