<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertydesc-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($modeldesc->hasErrors()) echo $form->errorSummary($modeldesc); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($modeldesc,'Translation'); ?>
		<?php echo $form->dropDownList($modeldesc, 'lang', array('en'=>'English', 'id'=>'Indonesia',), array('prompt'=>'')); ?>
		<?php //$form->dropDownList($modeldesc->myFunction())?>
		<?php /*echo $form->dropDownList($modeldesc, 'available_cleaning_start',
		 $win,array('prompt'=>'--Select Hours---'));*/ ?>
		<?php //echo $form->error($modeldesc,'roles'); ?>
		<?php //echo $form->error($modeldesc,'lang'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($modeldesc,'Terms and Conditions'); ?>
		<?php //echo $form->textField($modeldesc,'propertyname',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->textArea($modeldesc,'desc[]',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($modeldesc,'desc[]'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modeldesc,'Payment Policy'); ?>
		<?php echo $form->textArea($modeldesc,'desc[]',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($modeldesc,'desc[]'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modeldesc,'Cancellation Policy'); ?>
		<?php echo $form->textArea($modeldesc,'desc[]',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($modeldesc,'desc[]'); ?>
	</div>



	<div class="row">
			<?php echo $form->labelEx($modeldesc,'Allowable Arrival Times'); ?>
			<?php
				for($pagi=1;$pagi<=12;$pagi++)
				{
						//$win[$d] = $d;
						echo CHtml::activeCheckBox($modeldesc,'desc[]',array('value'=>$pagi.'AM')).$pagi.'AM ';
				}
			?>
			<br>
			<?php
			for($siang=1;$siang<=12;$siang++)
			{
					//$win[$d] = $d;
					echo CHtml::activeCheckBox($modeldesc,'desc[]',array('value'=>$siang.'PM')).$siang.'PM ';
			}

			?>
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($modeldesc->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
