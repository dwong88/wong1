<div class="form">

<?php $form=$this->beginWidget('application.extensions.widget.ActiveForm', array(
	'id'=>'bank-form',
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
		<?php echo $form->labelEx($model,'bank_cd'); ?>
		<?php
			if($model->isNewRecord) { 
				echo $form->textField($model,'bank_cd',array('size'=>30,'maxlength'=>30));
			} else {
				echo $model->bank_cd;
			}
		?>
		<?php echo $form->error($model,'bank_cd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bank_name'); ?>
		<?php echo $form->textField($model,'bank_name',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'bank_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->