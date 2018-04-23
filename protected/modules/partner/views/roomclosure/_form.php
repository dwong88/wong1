<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#room_id').change(function() {
	var thisvalue = this.value;
	$('#Roomclosure_room_id').text(thisvalue);
});
			$('#Roomclosure_start_date').datepicker({
				});
			$('#Roomclosure_end_date').datepicker({
           onSelect: function () {
              myfunc();
      			}
				});

       function myfunc(){
	      var start= $('#Roomclosure_start_date').datepicker('getDate');
	    	var end= $('#Roomclosure_end_date').datepicker('getDate');
	   		days = (end- start) / (1000 * 60 * 60 * 24);
       	console.log(Math.round(days));
       }
			 function close(result) {
			 		if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
			 				parent.DayPilot.ModalStatic.close(result);
			 		}
			 }

			 $('#roomclosure-form').submit(function () {
			 		var f = $('#roomclosure-form');
			 		$.post(f.attr('action'), f.serialize(), function (result) {
			 				close(eval(result));
			 		});
			 		return false;
			 });
							",
CClientScript::POS_READY
);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roomclosure-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->hiddenField($model,'room_id');?>
		<?php echo $form->error($model,'room_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'start_date',
		                                ));?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'end_date',
		                                ));?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
