<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Change Password',
);
?>

<?php Helper::showFlash(); ?>

<?php 
$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changepass-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php Helper::showFlash(); ?>

	<div class="row">
		<?php echo $form->label($model,'user_name'); ?>
		<?php echo $model->user_name; ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($employee,'employee_name'); ?>
		<?php echo $employee->employee_name; ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'newpass'); ?>
		<?php echo $form->passwordField($model,'newpass',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'newpass'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'reenterpass'); ?>
		<?php echo $form->passwordField($model,'reenterpass',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'reenterpass'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
