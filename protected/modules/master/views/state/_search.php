<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'state_id'); ?>
		<?php echo $form->textField($model,'state_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country_id'); ?>
		<?php echo $form->dropDownList($model, 'country_id', CHtml::listData(Countries::model()->findAll(), 'countryid', 'country_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'state_name'); ?>
		<?php echo $form->textField($model,'state_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->