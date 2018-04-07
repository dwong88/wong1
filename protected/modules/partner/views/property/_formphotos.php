<?php
#fungsi list data menggunakan GridView
$this->widget('application.extensions.widget.GridView', array(
	'id'=>'property-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'filterPosition'=>'',
	'columns'=>array(
		'photo_id',
		'filename',
		array(
      'class'=>'CButtonColumn',
      'template'=>'{delete}',
			'deleteButtonUrl'=>'CHtml::normalizeUrl(array("property/delete", "id"=>$_GET["id"], "pid"=>$data->photo_id))',
		),
	),
));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'propertyphoto-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'title' => 'form title'),

)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($models->hasErrors()) echo $form->errorSummary($models); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($models,'filename'); ?>
		<?php echo $form->fileField($models,'doc'); ?>
		<?php echo $form->error($models,'doc'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($models->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
