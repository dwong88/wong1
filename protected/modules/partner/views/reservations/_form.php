<?php
#fungsi hitung difference day
if($idtype!=0){
$times= '';
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

							$('#room_id').change(function() {
								var thisvalue = this.value;
								console.log(thisvalue);
								$('#Reservations_room_type_id').text(thisvalue);
							});

							$('#roomtype_id').change(function() {
								var thisvalue = this.value;
								console.log(thisvalue);
								$('#Reservations_room_id').text(thisvalue);
							});

							//event perubahan tanggal
							$('input').change(function(){
								hitDate();
							});

							//fungsi hitung beda tanggal dan hitung biaya
							function hitDate() {
								var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
								var day1 = moment(document.getElementById('Reservations_start_date').value, 'DD/MM/YYYY');
								var day2 = moment(document.getElementById('Reservations_end_date').value, 'DD/MM/YYYY');
								var firstDate = new Date(day1);
								var secondDate = new Date(day2);
								if(secondDate<firstDate){
									alert('error tanggal');
									document.getElementById('demo').innerHTML = 0;
									document.getElementById('totalprices').innerHTML = 0;
									die();
								}else {
									var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
									//console.log(firstDate);
									document.getElementById('demo').innerHTML = diffDays;
									var x = document.getElementById('Reservations_price');
									var currentVal = x.value;
									var totalprice=diffDays*currentVal;
									//console.log(totalprice);
									document.getElementById('totalprices').innerHTML = totalprice;
								}
								return true;
							}

							hitDate();
							",
CClientScript::POS_READY
);
}
else{
	$times= 'HH:mm';
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

								$('#room_id').change(function() {
									var thisvalue = this.value;
									console.log(thisvalue);
									$('#Reservations_room_type_id').text(thisvalue);
								});

								$('#roomtype_id').change(function() {
									var thisvalue = this.value;
									$('#Reservations_room_id').text(thisvalue);
								});

								$('input').change(function(){
									hitTime();
								});

								function hitTime()
								{
										var day1 = moment(document.getElementById('Reservations_start_date').value, 'DD/MM/YYYY hh:mm:ss');
										var day2 = moment(document.getElementById('Reservations_end_date').value, 'DD/MM/YYYY hh:mm:ss');
										var firstDate = new Date(day1);
										var secondDate = new Date(day2);
										var date1 = new Date(firstDate);
										var date2 = new Date(secondDate);

										if(date2<date1){
												alert('eror');
										}
										else{
											var diff = date2.getTime() - date1.getTime();

											var msec = diff;
											var hh = Math.floor(msec / 1000 / 60 / 60);
											msec -= hh * 1000 * 60 * 60;
											var mm = Math.floor(msec / 1000 / 60);
											msec -= mm * 1000 * 60;
											var ss = Math.floor(msec / 1000);
											msec -= ss * 1000;
											//alert(hh + ':' + mm + ':' + ss);

											//kondisi jika lebih dari 12jam
											if(hh>12){
												alert('overtime');
												document.getElementById('demo').innerHTML = 'overtime';
											}
											else{
												document.getElementById('demo').innerHTML = hh;
												var pricestime = document.getElementById('hr'+hh).innerHTML;
												document.getElementById('totalprices').innerHTML = pricestime;
											}
										}
								}
								hitTime();
								",
	CClientScript::POS_READY
	);
}
$room_id = $model->room_id;
#query price regular
$roomsprice =DAO::queryAllSql("SELECT rm.room_id,rm.room_name,rt.room_type_name , rm.room_type_id, bp.price,pt.property_id FROM tghroom as rm
													INNER JOIN `tghbasepriceroom` as bp on rm.room_type_id = bp.room_type_id
													INNER JOIN `tghroomtype` as rt on rm.room_type_id = rt.room_type_id
													INNER JOIN `tghproperty` as pt on rt.property_id = pt.property_id
WHERE rm.room_id = '".$room_id."' and bp.hours='hr0';");

#query price flexible
$roomspricehours =DAO::queryAllSql("SELECT rm.room_id,rm.room_name,rt.room_type_name , rm.room_type_id,bp.hours, bp.price,pt.property_id FROM tghroom as rm
													INNER JOIN `tghbasepriceroom` as bp on rm.room_type_id = bp.room_type_id
													INNER JOIN `tghroomtype` as rt on rm.room_type_id = rt.room_type_id
													INNER JOIN `tghproperty` as pt on rt.property_id = pt.property_id
WHERE rm.room_id = '".$room_id."' and bp.hours NOT IN ('hr0','hr24');");

#tampilkan room_name
$dataroom=Room::model()->findAll('room_type_id=:room_type_id',array(':room_type_id'=>(string) $roomsprice[0]['room_type_id']));
$dataroom=CHtml::listData($dataroom,'room_id','room_name');
//var_dump($datas);die;
//print_r($dataroom);
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/moment.js"></script>
<div class="form">
<?php
		#cek kondisi data baru?
		if($model->isNewRecord){
				//print_r($model);
				#cek id reservation 0=flexible 1=regular 2=1night
				if($idtype!=0){
					$start = $model->start_date;
					$newDate1 = date("d/m/Y", strtotime($start));
					$model->start_date = $newDate1;

					$end = $model->end_date;
					$newDate2 = date("d/m/Y", strtotime($end));
					$model->end_date = $newDate2;
				}
				else {
					$start = $model->start_date;

					$newDate1 = date("d/m/Y H:m", strtotime($start));
					$model->start_date = $newDate1;
					$end = $model->end_date;
					$newDate2 = date("d/m/Y H:m", strtotime($end));
					$model->end_date = $newDate2;
					$id=$model->reservations_id;
					//$actions[]='loadeditevent&id='.$id."&idtype=".$id_type;
				}
		 		$actions[]='loadcreateevent&start='.$start."&end=".$end."&resource=".$room_id."&idtype=".$idtype;
		}
		else{
				#edit
		}
			$form=$this->beginWidget('CActiveForm', array(
			'id'=>'reservations-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			'action'=>$actions,
		));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<table>
		<tr>
			<td>
				<div class="row">
					<?php echo '<Strong>Check in: </Strong>';?>
					<?php
							$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
																					'model'=>$model,
																					'attribute'=>'start_date',
													                'mode'=>'datetime', //use "time","date" or "datetime" (default)
																					'options'   => array(
																								 'dateFormat' => 'dd/mm/yy',
																								 'timeFormat' => $times,//'hh:mm tt' default
																						 ),
																					 ));
					?>
					<?php echo $form->error($model,'start_date'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<?php echo '<Strong>Check out: </Strong>';?>
					<?php
								$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
																						'model'=>$model,
																						'attribute'=>'end_date',
														                'mode'=>'datetime', //use "time","date" or "datetime" (default)
																						'options'   => array(
																									 'dateFormat' => 'dd/mm/yy',
																									 'timeFormat' => $times,//'hh:mm tt' default
																							 ),
																						 ));
																								?>
								<?php echo $form->error($model,'end_date'); ?>
					</div>
			</td>
	</tr>
<?php if($idtype!=0)
{?>
		<tr>
				<td colspan="2">
					<h3>Length of stay:<strong><font id="demo"></font>Nights</strong></h3>
					<h3>Prices:<strong>Rp<font id="totalprices"></font></strong></h3>
				</td>
		</tr>
<?php
		echo $form->hiddenField($model,'price',array('value'=>$roomsprice[0]['price']));
}
else
{
?>
	<tr>
			<td colspan="2">
				<?php
						foreach ($roomspricehours as $key => $value) {
							echo "<p style='display:none;' id='".$value['hours']."'>".$value['price']."</p>";
						}
				?>
				<h3>Length of stay:<strong><font id="demo"></font>Hours</strong></h3>
				<h3>Prices:<strong>Rp<font id="totalprices"></font></strong></h3>
			</td>
	</tr>
<?php
			echo $form->hiddenField($model,'price',array('value'=>$roomsprice[0]['price']));
}
?>
	<tr>
		<td colspan="2">
				<div class="row">
				 <?php
				 		 $model->property_id = $roomsprice[0]['property_id'];
						 $model->room_type_id = $roomsprice[0]['room_type_id'];
						 $model->room_id = $roomsprice[0]['room_id'];
						 echo $form->labelEx($model,'property_id');
						 echo $form->dropDownList($model,'property_id', CHtml::listData(Property::model()->findAll(), 'property_id', 'property_name'),array(
							 'prompt'=>'Select Property',
							 //'disabled'=>true,
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
							 array($select_st=>$roomsprice[0]['room_type_name']),
							 array(
								 'prompt'=>'Select Room Type',
								 'options' => array($model->room_type_id=>array('selected'=>true)),
								 'ajax' => array(
								 'type'=>'POST',
								 'url'=>Yii::app()->createUrl('core/globalsetting/loadroom'), //or $this->createUrl('loadcities') if '$this' extends CController
								 'update'=>'#room_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
							 'data'=>array('room_type_id'=>'js:this.value'),
							 )));

						 ?>
					 <div>
						 <?php
						 		 echo $form->labelEx($model,'room_id');
						 		 echo CHtml::dropDownList('room_id',$select_ct,
								 array($select_ct=>$roomsprice[0]['room_name']), array('prompt'=>'Select Room','options' => array($model->room_id=>array('selected'=>true))));
							?>
					 </div>

					<?php echo $form->hiddenField($model,'room_type_id',array($model->room_type_id),array('value'=>''));?>
					<?php echo $form->hiddenField($model,'room_id',array($model->room_id),array('value'=>''));?>
					<?php echo '<Strong>Adult</Strong>';?>
					<?php echo $form->textField($model,'adult',array('size'=>2,'maxlength'=>2)); ?>
					<?php echo $form->error($model,'adult'); ?>

					<?php echo'<Strong>Child</Strong>'; ?>
					<?php echo $form->textField($model,'child',array('size'=>2,'maxlength'=>2)); ?>
					<?php echo $form->error($model,'child'); ?>
					<?php echo'<Strong>Infant</Strong>'; ?>
					<?php echo $form->textField($model,'infant',array('size'=>2,'maxlength'=>2)); ?>
					<?php echo $form->error($model,'infant'); ?>
				</div>
		</td>
		<td></td>
	</tr>

	<?php
	#fungsi cek tipe reservation regular atau flexible
	if($idtype==1)
	{
			echo $form->hiddenField($model,'idtype',array('value'=>'1'));
	?>
			<tr>
				<td colspan="3">
					<div class="row">
						<?php echo'<Strong>Type</Strong>'; ?>
						<?php echo $form->dropDownList($model, 'type', array('regular'=>'Regular','onenight'=>'24 Hours'), array('prompt'=>'Pilih')); ?>
						<?php echo $form->error($model,'type'); ?>

<?php
	}
	else
	{
?>

		<tr>
			<td colspan="3">
				<div class="row">
<?php
			echo $form->hiddenField($model,'idtype',array('value'=>'0'));
			echo $form->hiddenField($model,'type',array('value'=>'flexible'));
	}
?>
<?php
		if($model->isNewRecord){
			#kosong
		}
		else
		{
				if($model->status == "CheckedOut"){
						$disabled='disabled';
					}
?>
							<?php echo'<Strong>Status</Strong>'; ?>
							<?php echo $form->dropDownList($model, 'status', array('New'=>'New','Confirmed'=>'Confirmed', 'Arrived'=>'Arrived', 'Cancel'=>'Cancel', 'unallocated'=>'Unallocated', 'CheckedOut'=>'Checked Out'), array('prompt'=>'Pilih','disabled'=>$disabled)); ?>
							<?php echo $form->error($model,'status'); ?>

							<?php echo'<Strong>Paid</Strong>'; ?>
							<?php echo $form->dropDownList($model, 'paid', array('0'=>'0%','50'=>'50%', '100'=>'100%'), array('prompt'=>'Pilih')); ?>
							<?php echo $form->error($model,'paid'); ?>
						</div>
					</td>
				</tr>
				<?php
		}
	?>
</table>
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
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model,'country_id', CHtml::listData(Countries::model()->findAll(), 'country_id', 'country_name'),array('prompt'=>'Pilih')); ?>
		<?php echo $form->error($model,'country_id'); ?>
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
