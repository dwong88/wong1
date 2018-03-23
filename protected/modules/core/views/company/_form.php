<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'company_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'npwp_no'); ?>
		<?php echo $form->textField($model,'npwp_no',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'npwp_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'npwp_name'); ?>
		<?php echo $form->textField($model,'npwp_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'npwp_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'npwp_address'); ?>
		<?php echo $form->textArea($model,'npwp_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'npwp_address'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->