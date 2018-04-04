<div class="form">

<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'countries-form',
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
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php
			if($model->isNewRecord) {
				echo $form->textField($model,'country_id',array('size'=>50,'maxlength'=>50));
			} else {
				echo $model->country_id;
			}
		?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'country_name'); ?>
		<?php echo $form->textField($model,'country_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'country_name'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
