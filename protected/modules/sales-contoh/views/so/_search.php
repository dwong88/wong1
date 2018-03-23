<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'so_cd'); ?>
		<?php echo $form->textField($model,'so_cd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'client name'); ?>
		<?php echo $form->textField($model,'client_cd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'client_po_no'); ?>
		<?php echo $form->textField($model,'client_po_no',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sales name'); ?>
		<?php echo $form->textField($model,'sales_cd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'est_delivery_dt'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
		                        'model'=>$model,
		                        'attribute'=>'est_delivery_dt',
                                ));?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_tax'); ?>
		<?php echo $form->dropDownList($model, 'is_tax', array('0'=>'No','1'=>'Yes'), array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sell_currency'); ?>
		<?php echo $form->dropDownList($model, 'sell_currency', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'top'); ?>
		<?php echo $form->textField($model,'top'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_indent'); ?>
		<?php echo $form->dropDownList($model, 'is_indent', array('0'=>'No','1'=>'Yes'), array('prompt'=>'')); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Status::$so_status, array('prompt'=>'')); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'purchase_status'); ?>
        <?php echo $form->dropDownList($model, 'purchase_status', Status::$depedency_status, array('prompt'=>'')); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'invoice_status'); ?>
        <?php echo $form->dropDownList($model, 'invoice_status', Status::$depedency_status, array('prompt'=>'')); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'payment_status'); ?>
        <?php echo $form->dropDownList($model, 'payment_status', Status::$depedency_status, array('prompt'=>'')); ?>
    </div>
    
	<div class="row">
		<?php echo $form->label($model,'Create Employee'); ?>
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
		<?php echo $form->label($model,'Update Employee'); ?>
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