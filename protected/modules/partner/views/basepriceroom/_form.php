<?php
$model->room_type_id=$_GET['id'];

//$temp=(Countries::model()->findAll(), 'country_id', 'country_name');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'basepriceroom-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<br><h1><?php echo $mRoomtype->room_type_name; ?></h1><br/>
	<div class="row">
		<?php echo $form->labelEx($model,'room_type_id'); ?>
		<?php
		if($mRoomtype!=NULL){
			echo $form->textField($mRoomtype,'room_type_name',array('readonly'=>'readonly'));
		}
		else {
			echo $form->textField($model,'room_type_id',array('readonly'=>'readonly'));
		}
		 ?>
		<?php echo $form->error($model,'room_type_id'); ?>
	</div>

<?php

foreach (Basepriceroom::$publicTypePrice as $key => $value) {
?>
<div class="row">
	<?php echo $form->labelEx($model,$value); ?>
	<?php echo $form->textField($model,$value); ?>
</div>
<?php
}
?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
