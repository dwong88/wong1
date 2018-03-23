<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php if($model->updateSuccessfull === 1) { ?>
	<div class="flash-success">
		Password changed successfully. 		
	</div>
	<?php } ?>	
	<?php echo $form->errorSummary($model); ?>

	<?php if( $model->scenario == 'changepassword' ) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'oldpass'); ?>
		<?php echo $form->passwordField($model,'oldpass',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'oldpass'); ?>
	</div>
	<?php } ?>
	
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>