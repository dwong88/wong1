<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<?php echo $form->label($model,'room_features_id'); ?>
		<?php echo $form->textField($model,'room_features_id', CHtml::listData(Roomfeatures::model()->findAll(), 'room_features_id', 'room_features_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_id'); ?>
		<?php echo $form->textField($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->