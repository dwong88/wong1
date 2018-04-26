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
Helper::registerJsKarlwei();
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
	<?if($_GET['resource']!=null){
		echo "string";
	}else{?>
	<?php
	echo $form->labelEx($model,'property_id');
	echo $form->dropDownList($model,'property_id', CHtml::listData(Property::model()->findAll(), 'property_id', 'property_name'),array(
		'prompt'=>'Select Property',
		'ajax' => array(
		'type'=>'POST',
		'url'=>Yii::app()->createUrl('core/globalsetting/loadroomtype'), //or $this->createUrl('loadcities') if '$this' extends CController
		'update'=>'#roomtype_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
		'data'=>array('property_id'=>'js:this.value'),
		)));
	?>
	<?php
		echo $form->labelEx($model,'room_type_id');
		echo CHtml::dropDownList('roomtype_id',$select_st,
		array($select_st=>$mStatec[0]['state_name']),
		array(
			'prompt'=>'Select Room Type',
			'ajax' => array(
			'type'=>'POST',
			'url'=>Yii::app()->createUrl('core/globalsetting/loadroom'), //or $this->createUrl('loadcities') if '$this' extends CController
			'update'=>'#room_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
		'data'=>array('room_type_id'=>'js:this.value'),
		)));

	?>
	<div><?php 		echo CHtml::dropDownList('room_id',$select_ct,
			array($select_ct=>$mStatec[0]['city_name']), array('prompt'=>'Select Room'));?>
	</div>
<?php }?>
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
		<?php echo $form->labelEx($model,'status_cl'); ?>
		<?php echo $form->textField($model,'status_cl'); ?>
		<?php echo $form->error($model,'status_cl'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
