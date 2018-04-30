<?php
#fungsi close iframe saat onsubmit
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

							$('input').change(function(){
								var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
								var day1 = moment(document.getElementById('Reservations_start_date').value, 'DD/MM/YYYY');
								var day2 = moment(document.getElementById('Reservations_end_date').value, 'DD/MM/YYYY');
								var firstDate = new Date(day1);
								var secondDate = new Date(day2);

								var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
								//console.log(diffDays);
								document.getElementById('demo').innerHTML = diffDays;
							});

							var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
							var day1 = moment(document.getElementById('Reservations_start_date').value, 'DD/MM/YYYY');
							var day2 = moment(document.getElementById('Reservations_end_date').value, 'DD/MM/YYYY');
							var firstDate = new Date(day1);
							var secondDate = new Date(day2);

							var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
							console.log(firstDate);
							document.getElementById('demo').innerHTML = diffDays;

							",
CClientScript::POS_READY
);
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/moment.js"></script>
<div class="form">

<?php
$room_id = $model->room_id;
$start = $model->start_date;
$end = $model->end_date;
$id_type = $model->type;

if($model->isNewRecord){
 		$actions[]='loadcreateevent&start='.$start."&end=".$end."&resource=".$room_id."&idtype=".$id_type;
}
else{
		$id=$model->reservations_id;
		$actions[]='loadeditevent&id='.$id."&idtype=".$id_type;
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
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php //echo $form->textField($model,'start_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'start_date',
		                                ));?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php //echo $form->textField($model,'end_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'end_date',
		                                ));?>
		<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'name'=>'publishDate',
					'options'=>array(
							'showAnim'=>'fold',
							'dateFormat'=>'yy-mm-dd',
							'onSelect'=>'js:function(i,j){

													 function JSClock() {
															var time = new Date();
															var hour = time.getHours();
															var minute = time.getMinutes();
															var second = time.getSeconds();
															var temp="";
															temp +=(hour<10)? "0"+hour : hour;
															temp += (minute < 10) ? ":0"+minute : ":"+minute ;
															temp += (second < 10) ? ":0"+second : ":"+second ;
															return temp;
														}

														$v=$(this).val();
														$(this).val($v+" "+JSClock());

										 }'
				 ),
					'htmlOptions'=>array(
							'style'=>'height:20px;'
					),
			));
		?>
		<?php echo $form->error($model,'end_date'); ?>
		<h3>Length of stay:<strong><font id="demo"></font>Nights</strong></h3>
	</div>
	<div class="row">
		<?php
		$idr=$model->room_id;
		$rooms = Room::model()->findByPk($idr);

		echo $form->labelEx($model,'room_id');
		echo $rooms->room_name;
		 ?>
		<?php //echo $form->dropDownList($model,'room_id', CHtml::listData(Room::model()->findAll($idr), 'room_id', 'room_name'),array('prompt'=>'Pilih kamar')); ?>
		<?php //echo $form->error($model,'room_id'); ?>
	</div>
	<?php
	#fungsi cek tipe reservation regular atau flexible
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
	else
	{
			echo $form->hiddenField($model,'type',array('value'=>'flexible'));
	}
?>
<?php
		if($model->isNewRecord){
			#kosong
		}
		else{
				if($model->status == "CheckedOut"){
						$disabled='disabled';
				}
			?>
				<div class="row">
					<?php echo $form->labelEx($model,'status'); ?>
					<?php echo $form->dropDownList($model, 'status', array('New'=>'New','Confirmed'=>'Confirmed', 'Arrived'=>'Arrived', 'Cancel'=>'Cancel', 'unallocated'=>'Unallocated', 'CheckedOut'=>'Checked Out'), array('prompt'=>'Pilih','disabled'=>$disabled)); ?>
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
	<hr>
	<div class="row">
		<?php echo $form->labelEx($model,'customer_name'); ?>
		<?php echo $form->textField($model,'customer_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customer_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'guest_comment'); ?>
		<?php echo $form->textArea($model,'guest_comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'guest_comment'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
