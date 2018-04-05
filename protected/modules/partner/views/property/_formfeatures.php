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

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>

	<div class="row">
			<?php echo $form->labelEx($model,'Allowable Arrival Times'); ?>
			<?php
				for($features=1;$features<=50;$features++)
				{
						//$win[$d] = $d;
						echo CHtml::activeCheckBox($model,'propertyname[]',array('value'=>$features)).'Features '.$features." ";
				}
			?>
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
