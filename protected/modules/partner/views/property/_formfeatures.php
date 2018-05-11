<style>
	div.form label{
		display: inline;
	}
	ul {
  list-style-type: none;
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
	'htmlOptions'=>array(
		'class'=>'pure-form',
		),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<table>
		<div class="row">
	<?php
	if($mFeat->hasErrors()) echo $form->errorSummary($mFeat); ?>
	<?php Helper::showFlash(); ?>
	<tr>
	<td colspan="3">
					<ul id="ul-features">
	<?php echo CHtml::checkBoxList(
	        'propfeat',
	        //'$checkedFeat',//you can pass the array here which you want to be pre checked
					$checkedFeat,
	        CHtml::listData(Mspropertyfeatures::model()->findAll(),'prop_features_id','features_name'),
	        array('checkAll'=>'Select all tasks', 'checkAllLast'=>true , 'template'=>'<li>{input} {label}</li>')
	    ); ?>
				</ul>
				<div style="clear: both;"></div>
		</td>
	</tr>
		</div>
	</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($mFeat->isNewRecord ? 'Save' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
