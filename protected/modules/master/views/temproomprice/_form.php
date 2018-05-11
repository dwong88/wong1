<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'temproomprice-form',
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
	<?php

	foreach (Temproomprice::$publicTypePrice as $key => $value) {
	?>
	<div class="row">
		<?php echo $form->labelEx($model,$value); ?>
		<?php echo $form->textField($model,$value); ?>
	</div>
	<?php
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
