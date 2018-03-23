<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientaddress-form',
	'enableAjaxValidation'=>true,
)); 
?>
	<?php echo $form->hiddenField($model, 'client_cd'); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	
	<div class="row">
        <?php echo $form->labelEx($model,'short_desc'); ?>
        <?php echo $form->textField($model,'short_desc'); ?>
        <?php echo $form->error($model,'short_desc'); ?>
    </div>
	
 	<div class="row">
        <?php echo $form->labelEx($model,'phone'); ?>
        <?php echo $form->textField($model,'phone'); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'fax'); ?>
        <?php echo $form->textField($model,'fax'); ?>
        <?php echo $form->error($model,'fax'); ?>
    </div>
 	
 
    
    <div class="row">
        <?php echo $form->labelEx($model,'address'); ?>
        <?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>
    
    
    <div class="row">
        <?php echo $form->labelEx($model,'notes'); ?>
        <?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'notes'); ?>
    </div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->




















