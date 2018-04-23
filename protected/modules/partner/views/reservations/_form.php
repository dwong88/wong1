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

							$('#reservations-form').submit(function () {
							    var f = $('#reservations-form');
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

<?php

		if($model->isNewRecord){
		 $actions[]='loadcreateevent&start='.$start."&end=".$end."&resource".$room_id;
		}
		else{
			$id=$model->reservations_id;
			$actions[]='update&id='.$id;
		}
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'reservations-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action'=>$actions,
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
	<?php
	if($idtype==1)
	{
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model, 'type', array('regular'=>'Regular','onenight'=>'24 Hours'), array('prompt'=>'Pilih')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	<?php
	}
	else {
			echo $form->hiddenField($model,'type',array('value'=>'flexible'));
	}
?>
<?php
		if($model->isNewRecord){

		}
		else{
			?>
			<div class="row">
				<?php echo $form->labelEx($model,'status'); ?>
				<?php echo $form->dropDownList($model, 'status', array('New'=>'New','Confirm'=>'Confirm', 'Arrived'=>'Arrived','CheckedOut'=>'Checked Out'), array('prompt'=>'Pilih')); ?>
				<?php echo $form->error($model,'status'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'paid'); ?>
				<?php echo $form->dropDownList($model, 'paid', array('0'=>'0%','50'=>'50%', '100'=>'100%'), array('prompt'=>'Pilih')); ?>
				<?php echo $form->error($model,'paid'); ?>
			</div>
			<?php
		}
	?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
