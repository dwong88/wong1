<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'bed_id'); ?>
		<?php echo $form->textField($model,'bed_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bed_name'); ?>
		<?php echo $form->textField($model,'bed_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bed_capacity'); ?>
		<?php echo $form->textField($model,'bed_capacity',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bed_size'); ?>
		<?php echo $form->textField($model,'bed_size',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->