<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usergroup-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	<div class="row">
		<?php echo $form->labelEx($model,'usergroup_name'); ?>
		<?php echo $form->textField($model,'usergroup_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'usergroup_name'); ?>
	</div>
	
	<?php if(!$model->isNewRecord):?>
	<div class="row">
		<?php echo $form->labelEx($model,'default_redirect'); ?>
		<?php echo $form->dropDownList($model, 'default_redirect',CHtml::listData(Usergroupakses::model()->with('menuaction')->findAll(
						array('order'=>'menuaction.action_url','condition'=>'usergroup_id=:usergroup_id','params'=>array(':usergroup_id'=>$model->usergroup_id))),'menuaction_id', 'menuaction.action_url')); ?>
		<?php echo $form->error($model,'default_redirect'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->