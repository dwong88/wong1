<div class="form">

<?php $form=$this->beginWidget('application.extensions.widget.ActiveForm', array(
	'id'=>'companybranch-form',
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
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->dropDownListOne($model, 'company_id', CHtml::listData(Company::model()->findAll(), 'company_id', 'company_name'), array('prompt'=>'', 'class'=>'selone')); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'branch_name'); ?>
		<?php echo $form->textField($model,'branch_name',array('size'=>20,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'branch_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'branch_code'); ?>
		<?php echo $form->textField($model,'branch_code',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'branch_code'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'branch_phone'); ?>
		<?php echo $form->textField($model,'branch_phone',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'branch_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'branch_addr'); ?>
		<?php echo $form->textArea($model,'branch_addr',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'branch_addr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->