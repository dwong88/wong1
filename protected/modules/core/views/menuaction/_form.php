<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menuaction-form',
	'enableAjaxValidation'=>true,
)); 
?>
	<?php echo $form->hiddenField($model, 'menu_id'); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'menuaction_desc'); ?>
		<?php echo $form->textArea($model,'menuaction_desc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'menuaction_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'action_url'); ?>
		<?php echo $form->textField($model,'action_url',array('size'=>60,'maxlength'=>225)); ?>
		<?php echo $form->error($model,'action_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->dropDownList($model, 'group_id', CHtml::listData(Actiongroup::model()->findAll(), 'group_id', 'group_name'),array('prompt'=>'-- Choose Action Group --')); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->