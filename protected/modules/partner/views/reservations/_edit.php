<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
							function close(result) {
									if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
											parent.DayPilot.ModalStatic.close(result);
									}
							}
							$('#edit-form').submit(function (result) {
							    var g = $('#edit-form');
							    $.post(g.attr('action'), g.serialize(), function (result) {
											//console.log(eval(result));
							        close(eval(result));
							    });
							    return false;
							});
							$('input').change(function(){
								var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
								var firstDate = new Date(document.getElementById('Reservations_start_date').value);
								var secondDate = new Date(document.getElementById('Reservations_end_date').value);

								var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
								//console.log(diffDays);
								document.getElementById('demo').innerHTML = diffDays;
							});

								var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
								var firstDate = new Date(document.getElementById('Reservations_start_date').value);
								var secondDate = new Date(document.getElementById('Reservations_end_date').value);

								var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
								//console.log(diffDays);
								document.getElementById('demo').innerHTML = diffDays;
							",
CClientScript::POS_READY
);
?>
<div class="form">

<?php
	$id=$model->reservations_id;
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action'=>array('update&id='.$id),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'customer_name'); ?>
		<?php echo $form->textField($model,'customer_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'room_id'); ?>
		<?php echo $form->dropDownList($model,'room_id', CHtml::listData(Room::model()->findAll(), 'room_id', 'room_name'),array('prompt'=>'Pilih kamar')); ?>
		<?php echo $form->error($model,'room_id'); ?>
	</div>

	<?php echo $form->hiddenField($model,'reservations_id',array('value'=>''));?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
