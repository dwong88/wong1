<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'room_type_bed_id'); ?>
		<?php echo $form->textField($model,'room_type_bed_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_id'); ?>
		<?php echo $form->textField($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'master_bed_id'); ?>
		<?php echo $form->textField($model,'master_bed_id', CHtml::listData(Masterbed::model()->findAll(), 'master_bed_id', 'master_bed_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_bed_quantity_room'); ?>
		<?php echo $form->textField($model,'room_type_bed_quantity_room',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->