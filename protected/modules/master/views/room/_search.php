<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'room_id'); ?>
		<?php echo $form->textField($model,'room_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status_room_type_id'); ?>
		<?php echo $form->textField($model,'status_room_type_id', CHtml::listData(Statusroomtype::model()->findAll(), 'status_room_type_id', 'status_room_type_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_id'); ?>
		<?php echo $form->textField($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_floor'); ?>
		<?php echo $form->textField($model,'room_floor',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_name'); ?>
		<?php echo $form->textField($model,'room_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_status'); ?>
		<?php echo $form->textArea($model,'room_status',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->