<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#city_name').change(function() {
	var thisvalue = this.value;
	$('#Property_state_id').text(thisvalue);
});
$('#state_name').change(function() {
	var thisvalue = this.value;
	$('#Property_city_id').text(thisvalue);
});

							",
CClientScript::POS_READY
);
?>
<?php
//echo $model->end_minutes;
#looping buat jam
for($d=0;$d<=23;$d++)
{
	$win[$d] = $d;
}
?>
<?php
#looping buat Menit
for($f=0;$f<=59;$f++)
{
	$min[$f] = $f;
}
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'property-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	<table border="1">
			<tr>
				<td width="33%">
						<?php echo $form->labelEx($model,'property_name'); ?>
						<?php echo $form->textField($model,'property_name',array('size'=>50,'maxlength'=>50,'placeholder'=>'Masukan Nama Property')); ?>
						<?php echo $form->error($model,'property_name'); ?>

						<?php echo $form->labelEx($model,'property_type_id'); ?>
						<?php echo $form->dropDownList($model,'property_type_id', CHtml::listData(Propertytype::model()->findAll(), 'property_type_id', 'property_type_name'),array('prompt'=>'Pilih Tipe')); ?>
						<?php echo $form->error($model,'property_type_id'); ?>
						<div class="row">
							<?php echo $form->labelEx($model,'addressline1'); ?>
							<?php echo $form->textArea($model,'addressline1',array('rows'=>6, 'cols'=>50,'placeholder'=>'Masukan Alamat Property')); ?>
							<?php echo $form->error($model,'addressline1'); ?>
						</div>
						<?php echo $form->labelEx($model,'addressline2'); ?>
						<?php echo $form->textArea($model,'addressline2',array('rows'=>6, 'cols'=>50,'placeholder'=>'Masukan Alamat Alternatif Property')); ?>
						<?php echo $form->error($model,'addressline2'); ?>
						<div class="row">
							<?php echo $form->labelEx($model,'postal_code').'<br>'; ?>
							<?php echo $form->textField($model,'postal_code',array('size'=>5,'maxlength'=>5)); ?>
							<?php echo $form->error($model,'postal_code'); ?>
						</div>
						<?php echo $form->hiddenField($model,'state_id',array('value'=>''));?>
						<?php echo $form->hiddenField($model,'city_id',array('value'=>''));?>
						</div>
						<?php echo $form->dropDownList($model,'country_id', CHtml::listData(Countries::model()->findAll(), 'country_id', 'country_name'),array(
						'prompt'=>'Select Country',
						'ajax' => array(
						'type'=>'POST',
						'url'=>Yii::app()->createUrl('core/globalsetting/loadstates'), //or $this->createUrl('loadcities') if '$this' extends CController
						'update'=>'#state_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
						'data'=>array('country_id'=>'js:this.value'),
						))); ?>
						<?php
							echo CHtml::dropDownList('state_id',$select_st,
							array($select_st=>$mStatec[0]['state_name']),
						  array(
						    'prompt'=>'Select Provinsi',
						    'ajax' => array(
						    'type'=>'POST',
						    'url'=>Yii::app()->createUrl('core/globalsetting/loadcities'), //or $this->createUrl('loadcities') if '$this' extends CController
						    'update'=>'#city_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
						  'data'=>array('state_id'=>'js:this.value'),
						  )));
								echo CHtml::dropDownList('city_id',$select_ct,
								array($select_ct=>$mStatec[0]['city_name']), array('prompt'=>'Select City'));
						?>
						<div class="row">
							<?php echo $form->labelEx($model,'weekend_start').'<br>'; ?>
							<?php //echo $form->textField($model,'weekend_start',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->dropDownList($model, 'weekend_start', Helper::$listDay, array('prompt'=>'Pilih', 'id'=>'id-sel-day')); ?>
							<?php echo $form->error($model,'weekend_start'); ?>
						</div>
				</td>
				<td width="33%" align="center" style="vertical-align:top">
					<div class="row">
						<?php echo $form->labelEx($model,'hotel_phone_number').'<br>'; ?>
						<?php echo $form->textField($model,'hotel_phone_number',array('size'=>20,'maxlength'=>20,'placeholder'=>'(kode_area) 999999')); ?>
						<?php echo $form->error($model,'hotel_phone_number'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'phone_number').'<br>'; ?>
						<?php echo $form->textField($model,'phone_number',array('size'=>20,'maxlength'=>20,'placeholder'=>'(kode_area) 999999')); ?>
						<?php echo $form->error($model,'phone_number'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'tax_number').'<br>'; ?>
						<?php echo $form->textField($model,'tax_number',array('size'=>11,'maxlength'=>11)); ?>
						<?php echo $form->error($model,'tax_number'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'minimumroomrate').'<br>'; ?>
						<?php echo $form->textField($model,'minimumroomrate',array('size'=>5,'maxlength'=>5)); ?>
						<?php echo $form->error($model,'minimumroomrate'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'star_rated').'<br>'; ?>
						<?php echo $form->dropDownList($model, 'star_rated', array('yes'=>'Yes', 'no'=>'No',), array('prompt'=>'')); ?>
						<?php echo $form->error($model,'star_rated'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'numberofstar').'<br>'; ?>
						<?php echo $form->textField($model,'numberofstar'); ?>
						<?php echo $form->error($model,'numberofstar'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'maximumchildage').'<br>'; ?>
						<?php echo $form->textField($model,'maximumchildage'); ?>
						<?php echo $form->error($model,'maximumchildage'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'maximuminfantage').'<br>'; ?>
						<?php echo $form->textField($model,'maximuminfantage'); ?>
						<?php echo $form->error($model,'maximuminfantage'); ?>
					</div>
				</td>
				<td width="33%" align="center" style="vertical-align:top">
					<div class="row">
						<?php echo $form->labelEx($model,'enquiryemail').'<br>'; ?>
						<?php echo $form->textField($model,'enquiryemail',array('size'=>50,'maxlength'=>50,'placeholder'=>'partner@g-hours.id')); ?>
						<?php echo $form->error($model,'enquiryemail'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'bookingconfirmationemail').'<br>'; ?>
						<?php echo $form->textField($model,'bookingconfirmationemail',array('size'=>50,'maxlength'=>50,'placeholder'=>'partner@g-hours.id')); ?>
						<?php echo $form->error($model,'bookingconfirmationemail'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'bookingconfirmationccemail').'<br>'; ?>
						<?php echo $form->textField($model,'bookingconfirmationccemail',array('size'=>50,'maxlength'=>50,'placeholder'=>'partner@g-hours.id')); ?>
						<?php echo $form->error($model,'bookingconfirmationccemail'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'availabilityalertemail').'<br>'; ?>
						<?php echo $form->textField($model,'availabilityalertemail',array('size'=>50,'maxlength'=>50,'placeholder'=>'partner@g-hours.id')); ?>
						<?php echo $form->error($model,'availabilityalertemail'); ?>
					</div>
					<div class="row">
						<?php echo $form->labelEx($model,'available_cleaning_start').'<br>'; ?>
						<?php //echo $form->dropDownList($model, 'available_cleaning_start', array('ADMIN'=>'Admin', 'Partner'=>'Partner',), array('prompt'=>'')); ?>
						<?php //$form->dropDownList($model->myFunction())?>
						<?php echo $form->dropDownList($model, 'start_hours',
						 $win,array('prompt'=>'--Select Hours---')); ?>
						 <?php echo $form->dropDownList($model, 'start_minutes',
					 	 $min,array('prompt'=>'--Select Minutes---')); ?>
					</div>
					<div class="row">
						<?php echo $form->labelEx($model,'available_cleaning_end').'<br>'; ?>
						<?php //echo $form->dropDownList($model, 'available_cleaning_start', array('ADMIN'=>'Admin', 'Partner'=>'Partner',), array('prompt'=>'')); ?>
						<?php //$form->dropDownList($model->myFunction())?>
						<?php echo $form->dropDownList($model, 'end_hours',
						 $win,array('prompt'=>'--Select Hours---')); ?>
						 <?php echo $form->dropDownList($model, 'end_minutes',
					 	 $min,array('prompt'=>'--Select Minutes---')); ?>
					</div>
					<div class="row">
						<?php echo $form->labelEx($model,'locationinstruction'); ?>
						<?php echo $form->textArea($model,'locationinstruction',array('rows'=>6, 'cols'=>50)); ?>
						<?php echo $form->error($model,'locationinstruction'); ?>
					</div>
				</td>
			</tr>
	</table>
	<?php Helper::showFlash(); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'description').'<br>'; ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gmaps_longitude').'<br>'; ?>
		<?php echo $form->textField($model,'gmaps_longitude',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'gmaps_longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gmaps_latitude').'<br>'; ?>
		<?php echo $form->textField($model,'gmaps_latitude',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'gmaps_latitude'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
