<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pattern_id'); ?>
		<?php echo $form->textField($model,'pattern_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pattern_group'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			 'name'=>'Pattern[pattern_group]',
			 'sourceUrl'=>yii::app()->createUrl('core/pattern/auto'),
			 ));
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pattern_sub'); ?>
		<?php echo $form->dropDownList($model, 'pattern_sub',array('function'=>'function','value'=>'value'), array('prompt'=>'-Select-', 'id'=>'pattern_sub')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pattern_length'); ?>
		<?php echo $form->textField($model,'pattern_length'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pattern_value'); ?>
		<?php echo $form->textField($model,'pattern_value',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'increment'); ?>
		<?php echo $form->textField($model,'increment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pattern_order'); ?>
		<?php echo $form->textField($model,'pattern_order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->