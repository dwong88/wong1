<script>
	function description()
	{
		$('#pattern_sub_hidden').toggle();
	}
</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pattern-form',
	'enableAjaxValidation'=>false,
));

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	<div class="row">
		<?php echo $form->labelEx($model,'pattern_group'); ?>
		<?php
			$config = !empty($model->pattern_group)? array('model'=>$model, 'attribute'=>'pattern_group') : array('value'=>'');
			/*$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			 'name'=>'Pattern[pattern_group]',
			 'sourceUrl'=>yii::app()->createUrl('core/pattern/auto'),
			 ));*/
			 
			 $this->widget('zii.widgets.jui.CJuiAutoComplete', CMap::mergeArray( array(
            'sourceUrl'=>yii::app()->createUrl('core/pattern/auto'),
            'name'=>'Pattern[pattern_group]',
             ), $config)
            );
		?>
		<?php echo $form->error($model,'pattern_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pattern_sub'); ?>
		<?php echo $form->dropDownList($model, 'pattern_sub',array('function'=>'function','value'=>'value'), array('prompt'=>'-Select-', 'id'=>'pattern_sub')); ?>
		<?php echo $form->error($model,'pattern_sub'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pattern_length'); ?>
		<?php echo $form->textField($model,'pattern_length'); ?>
		<?php echo $form->error($model,'pattern_length'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pattern_value'); ?>
		<?php echo $form->textField($model,'pattern_value',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'pattern_value'); ?>
        <a href="javascript:void(0)" onclick="window.open('welcome.html',
'Description','width=300,height=200')" style="cursor:default;text-decoration:none;">Description</a>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'increment'); ?>
		<?php echo $form->textField($model,'increment'); ?>
		<?php echo $form->error($model,'increment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pattern_order'); ?>
		<?php echo $form->textField($model,'pattern_order'); ?>
		<?php echo $form->error($model,'pattern_order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->