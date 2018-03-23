<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'testdetail-form',
	'enableAjaxValidation'=>true,
)); 
echo $form->hiddenField($model, 'test_id');
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'receive_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'receive_dt',
				                        'htmlOptions'=>array('class'=>'dtl-date'),
		                                ));?>
		<?php echo $form->error($model,'receive_dt'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'currency_cd'); ?>
		<?php echo $form->dropDownList($model, 'currency_cd', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
		<?php echo $form->error($model,'currency_cd'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'class'=>'tnumber col-right')); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes'); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->