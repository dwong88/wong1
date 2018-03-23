<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'expedisi-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'expedisi_name'); ?>
		<?php echo $form->textField($model,'expedisi_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expedisi_address'); ?>
		<?php echo $form->textArea($model,'expedisi_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expedisi_contact'); ?>
		<?php echo $form->textArea($model,'expedisi_contact',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->