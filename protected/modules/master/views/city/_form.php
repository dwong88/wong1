<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#state_name').change(function() {
	var thisvalue = this.value;
	$('#City_state_id').text(thisvalue);
});

							",
CClientScript::POS_READY
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>'pure-form',
		),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->dropDownList($model,'country_id', CHtml::listData(Countries::model()->findAll(), 'country_id', 'country_name'),array(
			'prompt'=>'Pilih Negara',
			'ajax' => array(
			'type'=>'POST',
			'url'=>Yii::app()->createUrl('core/globalsetting/loadstates'), //or $this->createUrl('loadcities') if '$this' extends CController
			'update'=>'#state_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
		'data'=>array('country_id'=>'js:this.value'),
		))); ?>
	</div>

	<div class="row">
		<?php
			$select=$model->state_id;
		  echo CHtml::dropDownList('state_id',$select,
		  array($select=>$mState[0]['state_name']),

		  array(
		    'prompt'=>'Pilih Provinsi',
		    'ajax' => array(
		    'type'=>'POST',
		    'url'=>Yii::app()->createUrl('core/globalsetting/loadcities'), //or $this->createUrl('loadcities') if '$this' extends CController
		    'update'=>'#city_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
		  'data'=>array('state_id'=>'js:this.value'),
		  )));
			//echo CHtml::dropDownList('city_name','', array(), array('prompt'=>'Select City'));
		?>
	</div>
	<?php echo $form->hiddenField($model,'state_id',array('value'=>''));?>
	<div class="row">
		<?php echo $form->labelEx($model,'postal_code'); ?>
		<?php echo $form->textField($model,'postal_code',array('placeholder'=>'Masukan Kode Pos')); ?>
		<?php echo $form->error($model,'postal_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_name'); ?>
		<?php echo $form->textField($model,'city_name',array('size'=>30,'maxlength'=>30,'placeholder'=>'Masukan Nama Kota')); ?>
		<?php echo $form->error($model,'city_name'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
