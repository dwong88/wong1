<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertytype-form',
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
		<?php echo $form->labelEx($model,'property_type_name'); ?>
		<?php echo $form->textField($model,'property_type_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'property_type_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'property_desc'); ?>
		<?php echo $form->textArea($model,'property_desc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'property_desc'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->