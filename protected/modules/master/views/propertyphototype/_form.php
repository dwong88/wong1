<?php
#fungsi input value ajax city state country
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#city_name').change(function() {
	var thisvalue = this.value;
	$('#Propertyphototype_test3').text(thisvalue);
});
$('#state_name').change(function() {
	var thisvalue = this.value;
	$('#Propertyphototype_test2').text(thisvalue);
});
$('#country_id').change(function() {
	var thisvalue = this.value;
	$('#Propertyphototype_test1').text(thisvalue);
});

							",
CClientScript::POS_READY
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertyphototype-form',
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
		<?php echo $form->labelEx($model,'propertyphototype_name'); ?>
		<?php echo $form->textField($model,'propertyphototype_name',array('size'=>20,'maxlength'=>20,'placeholder'=>'Masukan Type Photo')); ?>
		<?php echo $form->error($model,'propertyphototype_name'); ?>
		<?php echo $form->hiddenField($model,'test1',array('value'=>''));?>
		<?php echo $form->hiddenField($model,'test2',array('value'=>''));?>
		<?php echo $form->hiddenField($model,'test3',array('value'=>''));?>
	</div>
	<?php echo $form->dropDownList($model,'country_id', CHtml::listData(Countries::model()->findAll(), 'country_id', 'country_name'),array(
    'prompt'=>'Select Country',
    'ajax' => array(
    'type'=>'POST',
    'url'=>Yii::app()->createUrl('core/globalsetting/loadstates'), //or $this->createUrl('loadcities') if '$this' extends CController
    'update'=>'#state_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
  'data'=>array('country_id'=>'js:this.value'),
  ))); ?>
<div id="map"></div>

<?php
  echo CHtml::dropDownList('state_name','',
  array(),

  array(
    'prompt'=>'Select Region',
    'ajax' => array(
    'type'=>'POST',
    'url'=>Yii::app()->createUrl('core/globalsetting/loadcities'), //or $this->createUrl('loadcities') if '$this' extends CController
    'update'=>'#city_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
  'data'=>array('state_id'=>'js:this.value'),
  )));
	echo CHtml::dropDownList('city_name','', array(), array('prompt'=>'Select City'));
?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
