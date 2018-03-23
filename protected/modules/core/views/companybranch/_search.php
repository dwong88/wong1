<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', CHtml::listData(Company::model()->findAll(), 'company_id', 'company_name'), array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branch_code'); ?>
		<?php echo $form->textField($model,'branch_code',array('size'=>20,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branch_name'); ?>
		<?php echo $form->textField($model,'branch_name',array('size'=>20,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branch_addr'); ?>
		<?php echo $form->textField($model,'branch_addr',array('size'=>20,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branch_phone'); ?>
		<?php echo $form->textField($model,'branch_phone',array('size'=>20,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('size'=>20,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->