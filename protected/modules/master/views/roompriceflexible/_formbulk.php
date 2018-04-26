<style>
	div.form label{
		display: inline;
	}
	ul {
  list-style-type: none;
	}
</style>
<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#roomtype_id').change(function() {
	var thisvalue = this.value;
	$('#Roompriceflexible_room_type_id').text(thisvalue);
	console.log(thisvalue);
});
							",
CClientScript::POS_READY
);
Helper::registerNumberField('#tnumber, .dtl-price');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roompriceflexible-form',
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
		<?php
		$model->date_id = array(1,2,3,4,5,6,7);
		echo $form->checkBoxList($model, 'date_id', Helper::$listDays); ?>
	</div>
	<?php
	foreach (Roompriceflexible::$publicTypePrice as $key => $value) {
	?>
	<div class="row">
		<?php echo $form->labelEx($model,$value); ?>
		<?php echo $form->textField($model,$value,array('size'=>10,'id'=>'tnumber','class'=>'dtl-price col-right')); ?>
	</div>
	<?php
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
