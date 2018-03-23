<div class="form">

	<fieldset>
	<legend>Create User</legend>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model,$employee)); ?>
	<?php Helper::showFlash(); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php
			if($model->isNewRecord) {
				echo $form->textField($model,'user_name',array('size'=>20,'maxlength'=>20));
			} else {
				echo $model->user_name;
			} 
		?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>
	
	<?php if($model->isNewRecord) { ?>
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
	<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?>
		<?php echo $form->dropDownList($model, 'user_type', array('ADMIN'=>'Admin', 'USER'=>'User'), array('prompt'=>'')); ?>
		<?php echo $form->error($model,'user_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->checkBox($model, 'is_active').' Yes'; ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>
</fieldset>
</div><!-- form -->
<hr />
<div class="form">
<fieldset>
	<legend>Create Employee</legend>

	<div class="row">
		<?php echo $form->labelEx($employee,'employee_name'); ?>
		<?php echo $form->textField($employee,'employee_name'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($employee,'company_id'); ?>
		<?php echo $form->dropDownList($employee, 'company_id', CHtml::listData(Company::model()->findAll(), 'company_id', 'company_name'), array('prompt'=>'-Select Company-')); ?>
		<?php echo $form->error($employee,'company_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($employee,'employee_type'); ?>
        <?php echo $form->dropDownList($employee, 'employee_type', CHtml::listData(Employeetype::model()->findAll(), 'employee_type', 'employee_type'), array('prompt'=>'-Select EmployeeType-')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($employee,'email'); ?>
		<?php echo $form->textField($employee,'email'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>
</fieldset>
</div>