<style>
	div.form label{
		display: inline;
	}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertyfeat-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php
	if($mFeat->hasErrors()) echo $form->errorSummary($mFeat); ?>
	<?php Helper::showFlash(); ?>
	<?php echo CHtml::checkBoxList(
	        'propfeat',
	        //'$checkedFeat',//you can pass the array here which you want to be pre checked
					$checkedFeat,
	        CHtml::listData(Mspropertyfeatures::model()->findAll(),'prop_features_id','features_name'),
	        array('checkAll'=>'Select all tasks', 'checkAllLast'=>true)
	    ); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($mFeat->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
