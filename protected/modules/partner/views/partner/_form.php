<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'partner-form',
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
		<?php echo $form->labelEx($model,'partner_name'); ?>
		<?php echo $form->textField($model,'partner_name',array('size'=>60,'maxlength'=>100,'placeholder'=>'Masukan Nama Partner')); ?>
		<?php echo $form->error($model,'partner_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo $form->textField($model,'pic',array('size'=>60,'maxlength'=>100,'placeholder'=>'Masukan Nama PIC')); ?>
		<?php echo $form->error($model,'pic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model1,'username'); ?>
		<?php echo $form->textField($model1,'username',array('size'=>60,'maxlength'=>100,'placeholder'=>'Masukan Username Anda')); ?>
		<?php echo $form->error($model1,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model1,'roles'); ?>
		<?php echo $form->dropDownList($model1, 'roles', array('ADMIN'=>'Admin', 'Partner'=>'Partner',), array('prompt'=>'Pilih')); ?>
		<?php /*echo $form->dropDownList($model1, 'roles',
		 array($win), array('prompt'=>''));*/ ?>
		<?php echo $form->error($model1,'roles'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model1,'password'); ?>
		<?php echo $form->passwordField($model1,'password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model1,'password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
