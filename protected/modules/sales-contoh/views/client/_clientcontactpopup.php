<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientcontact-form',
	'enableAjaxValidation'=>true,
)); 
?>
	<?php echo $form->hiddenField($model, 'client_cd'); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_name'); ?>
		<?php echo $form->textField($model,'contact_name',array('size'=>30)); ?>
		<?php echo $form->error($model,'contact_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'phone_no'); ?>
		<?php echo $form->textField($model,'phone_no',array('size'=>30)); ?>
		<?php echo $form->error($model,'phone_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>30)); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->




















