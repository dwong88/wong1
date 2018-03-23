<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'soinvoice_cd'); ?>
		<?php echo $form->textField($model,'soinvoice_cd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'so_cd'); ?>
		<?php echo $form->textField($model,'so_cd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'client_cd'); ?>
		<?php echo $form->textField($model,'client_cd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'soinvoice_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'soinvoice_dt',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'top'); ?>
		<?php echo $form->textField($model,'top',array('size'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'due_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'due_date',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_percent'); ?>
		<?php echo $form->textField($model,'payment_percent',array('size'=>5,'maxlength'=>5)); ?>
		<span>%</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_amount'); ?>
		<?php echo $form->textField($model,'payment_amount',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_cd'); ?>
		<?php echo $form->dropDownList($model, 'currency_cd', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_kurs'); ?>
		<?php echo $form->textField($model,'currency_kurs',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tax_kurs'); ?>
		<?php echo $form->textField($model,'tax_kurs',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_type'); ?>
		<?php echo $form->textField($model,'discount_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_value'); ?>
		<?php echo $form->textField($model,'discount_value',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtotal_price'); ?>
		<?php echo $form->textField($model,'subtotal_price',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtotal_tax'); ?>
		<?php echo $form->textField($model,'subtotal_tax',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grandtotal_price'); ?>
		<?php echo $form->textField($model,'grandtotal_price',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'used_dp'); ?>
		<?php echo $form->textField($model,'used_dp',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_tax'); ?>
		<?php echo $form->dropDownList($model, 'is_tax', array('0'=>'No','1'=>'Yes'), array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_down_payment'); ?>
		<?php echo $form->textField($model,'is_down_payment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Status::$so_status, array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_status'); ?>
		<?php echo $form->dropDownList($model, 'payment_status', Status::$depedency_status, array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'create_dt',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'update_dt',)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->