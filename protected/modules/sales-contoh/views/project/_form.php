<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'project_name'); ?>
		<?php echo $form->textField($model,'project_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
        <?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'start_date',
		                                ));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'end_date',
		                                ));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'project_notes'); ?>
		<?php echo $form->textArea($model,'project_notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'client_cd'); ?>
        <?php echo $form->dropDownList($model, 'client_cd', CHtml::listData(Client::model()->findAll(), 'client_cd', 'client_name'), array('prompt'=>'-Select Client-')); ?>
	</div>
	
    <?php
    	if(!$model->IsNewRecord)
		{
	?>
    	<div class="row">
			<?php echo $form->label($model,'is_closed'); ?>
        	<?php echo $form->checkBox($model, 'is_closed'); ?>
		</div>
    <?php
    	}
	?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->