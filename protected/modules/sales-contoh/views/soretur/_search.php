<?php
/* @var $this SoreturController */
/* @var $model Soretur */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'soretur_cd'); ?>
		<?php echo $form->textField($model,'soretur_cd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'do_cd'); ?>
		<?php echo $form->textField($model,'do_cd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Client Name'); ?>
		<?php echo $form->textField($model,'client_cd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Signer Name'); ?>
		<?php echo $form->textField($model,'signed_by'); ?>
	</div>

	<div class="row">
        <?php echo $form->label($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Status::$core_status, array('prompt'=>'')); ?>
    </div>
    
	<div class="row">
        <?php echo $form->label($model,'received_status'); ?>
        <?php echo $form->dropDownList($model, 'status', Status::$depedency_status, array('prompt'=>'')); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textField($model,'notes'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
		                        'model'=>$model,
		                        'attribute'=>'create_dt',
                                ));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
		                        'model'=>$model,
		                        'attribute'=>'update_dt',
                                ));?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->