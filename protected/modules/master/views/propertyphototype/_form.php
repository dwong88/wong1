<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertyphototype-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>'pure-form',
		),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'propertyphototype_name'); ?>
		<?php echo $form->textField($model,'propertyphototype_name',array('size'=>20,'maxlength'=>20,'placeholder'=>'Masukan Type Photo')); ?>
		<?php echo $form->error($model,'propertyphototype_name'); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
