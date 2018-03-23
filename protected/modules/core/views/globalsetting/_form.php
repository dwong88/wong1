<?php Helper::registerNumberField('.tnumber')?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'globalsetting-form',
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
		<?php echo $form->labelEx($model,'default_fee_sponsor'); ?>
		<?php echo $form->textField($model,'default_fee_sponsor',array('size'=>11,'maxlength'=>11,'class'=>'col-right tnumber')); ?>
		<?php echo $form->error($model,'default_fee_sponsor'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->