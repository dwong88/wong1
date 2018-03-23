<?php
	$url = $this->createUrl('Ajxsoretur');
	$url2 = $this->createUrl('Ajxsoinvoice');
	Yii::app()->clientScript->registerScript('a',
	"
	$(document).ready(function()
	{
		var data = $('#do_cd').val();
		if(data!='')
			a(data);
			
		$('#do_cd').change(function()
		{
	    	var data = $('#do_cd').val();
			if(data!='')
			{
				a(data);
			}//end if data!=''
			
		});//end change function
		function a(data)
		{
			$.ajax({
		    	type: 'POST',
		    	url : '".$url."',
			   	data: { do_cd : data},
			   	dataType:'html',
				success:function(data)
				{
					$('#client_cd').html(data);
		        },
			   	error: function(data) 
			   	{ // if error occured
			        //alert('Error occured.please try again');
			        console.log('Error occured, please try again');
			    },
			});//end ajax
		}
	});
	"
); ?>
<div id="soretur-form-wrap">
	<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'soretur-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
		
		<?php if(!$model->isNewRecord): ?>
		<div class="row">
			<?php echo $form->labelEx($model,'soretur_cd'); ?>
			<?php echo $model->soretur_cd; ?>
			<?php echo $form->hiddenField($model,'soretur_cd');?>
			<?php echo $form->error($model,'soretur_cd'); ?>
		</div>
		<?php endif; ?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'do_cd'); ?>
			<?php if($model->isNewRecord): 
		 			echo $form->dropDownList($model, 'do_cd', CHtml::listData(Devo::model()->findAll('retur_status!='.Status::RETUR_STATUS_ALL.' AND status = '.Status::CORE_STATUS_OPEN.' AND do_type="SO" AND invoice_status = '.Status::DEPEDENCY_STATUS_COMPLETE), 'do_cd', 'ConcatCdAndActorSo'), array('id'=>'do_cd','prompt' => '-Choose Do-'));
				  else:
				  	echo $model->do_cd;
				  	echo $form->hiddenField($model,'do_cd',array('id'=>'do_cd'));
				  endif;
			?>
			<?php echo $form->error($model,'do_cd'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'client_cd'); ?>
			<?php
				if($model->isNewRecord){
			?>
					<span id="client_cd"></span>
			<?php
				}
				else
					echo $model->client_cd." - ".$model->client->client_name;
			?>	
			<?php echo $form->error($model,'client_cd'); ?>
			
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'signed_by'); ?>
            <?php 
				echo $form->dropDownList($model, 'signed_by',CHtml::listData(Employee::model()->findAll(), 'employee_cd', 'employee_name'), array('prompt'=>'-Select Employee-'));
			?>
			<?php echo $form->error($model,'signed_by'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'notes'); ?>
			<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'notes'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('id'=>'btn-save')); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>