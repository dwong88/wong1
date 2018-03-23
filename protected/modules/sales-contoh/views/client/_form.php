
<script>
	function editDetail(oLink)
	{
		var jDetailDialog = $('#detail-dialog');
		jDetailDialog.data('url', oLink.href);
		jDetailDialog.dialog('open');
		return false;
	}
</script>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'client_name'); ?>
		<?php echo $form->textField($model,'client_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	 
	<div class="row">
		<?php echo $form->labelEx($model,'employee_cd'); ?>
		<?php echo $form->dropDownList($model, 'employee_cd', CHtml::listData(Employee::model()->findAll(array('order'=>'employee_name','condition'=>"employee_type = 'BOD' OR employee_type = 'Sales'")), 'employee_cd', 'employee_name'), array('prompt'=>'-Select Employee-')); ?>				
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'top'); ?>
        <?php echo $form->textField($model,'top'); ?> Day(s)
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<br/>
	<fieldset>
		<legend><h3>Tax Information</h3></legend>
	
		<div class="row">
			<?php echo $form->labelEx($model,'npwp_no'); ?>
			<?php echo $form->textField($model,'npwp_no',array('size'=>50,'maxlength'=>50)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'npwp_name'); ?>
			<?php echo $form->textField($model,'npwp_name',array('size'=>60,'maxlength'=>255)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'npwp_address'); ?>
			<?php echo $form->textArea($model,'npwp_address',array('rows'=>6, 'cols'=>50)); ?>
		</div>
	</fieldset>
	
	
	<br/>
	
	<?php if(!$model->isNewRecord):?>
	<fieldset>
		<legend><h3>Address</h3></legend>
		<span style="color:red">Register all client company branch here <br/><br/></span>
		<a href="<?php echo CHtml::normalizeUrl(array('client/createdetail', 'client_cd'=>$model->client_cd,'type'=>'address'));?>" onclick="editDetail(this); return false;">Add Detail</a>
		<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'addressdetail-grid',
				'dataProvider'=>$modelAddress->search(),
				'filterPosition'=>'',
				'columns'=>array(
					array('name'=>'short_desc','htmlOptions'=>array('width'=>'15%')),
					'phone',
					'fax',
					array('name'=>'address','type'=>'raw','value'=>'nl2br($data->address)','htmlOptions'=>array('width'=>'20%')),
					array('name'=>'notes','type'=>'raw','value'=>'nl2br($data->notes)','htmlOptions'=>array('width'=>'20%')),
					array('name'=>'status','value'=>'Status::$is_status[$data->status]'),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update} {delete}',
						'htmlOptions'=>array('style'=>'text-align:left'),
						'updateButtonUrl'=>'CHtml::normalizeUrl(array("client/updateDetail", "id"=>$data->address_id, "type"=>"address"))',			// AH : ubah
						'updateButtonOptions'=>array(
								'class'=>'update',
								'onclick'=>'editDetail(this); return false;',
							),
						'deleteButtonUrl'=>'CHtml::normalizeUrl(array("client/deleteDetail", "id"=>$data->address_id, "type"=>"address"))',
					 ),//end array class cButtonColumn
				),//end array columns
			)); ?>
	</fieldset>
	<br/>
	<fieldset>
		<legend><h3>Contact Person</h3></legend>
		<a href="<?php echo CHtml::normalizeUrl(array('client/createdetail', 'client_cd'=>$model->client_cd, 'type'=>'contact' ));?>" onclick="editDetail(this); return false;">Add Detail</a>
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'contactdetail-grid',
			'dataProvider'=>$modelContact->search(),
			'filterPosition'=>'',
			'columns'=>array(
				array('name'=>'contact_name','htmlOptions'=>array('width'=>'15%')),
				'phone_no',
				'position',
				array('name'=>'notes','type'=>'raw','value'=>'nl2br($data->notes)','htmlOptions'=>array('width'=>'20%')),
				array('name'=>'status','value'=>'Status::$is_status[$data->status]'),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{update} {delete}',
					'htmlOptions'=>array('style'=>'text-align:left'),
					'updateButtonUrl'=>'CHtml::normalizeUrl(array("client/updateDetail", "id"=>$data->contact_id ,"type"=>"contact"))',			// AH : ubah
					'updateButtonOptions'=>array(
							'class'=>'update',
							'onclick'=>'editDetail(this); return false;',
						),
					'deleteButtonUrl'=>'CHtml::normalizeUrl(array("client/deleteDetail", "id"=>$data->contact_id,"type"=>"contact"))',
				 ),//end array class cButtonColumn
			),//end array columns
		));
		
		$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'detail-dialog',
		    'options'=>array(
		        'title'=>'Contact Detail',
		        'width'=>850,
		        'autoOpen'=>false,
		        'modal'=>true,
		        'position'=> "{my: 'center center'}",
		        'open'=>"js:function() {
		        	var jThis = $(this);
		        	if(jThis.data('url') != '') {
						$.ajax({
							type: 'POST',
							url: jThis.data('url'),
							dataType: 'html',
							success: function(data) {
								$('#div-detail').html(data);
							},
						});
						jThis.data('url', ''); 
					}
				}",
				
			'buttons'=>array(
				'Submit'=>"js:function(){
					var jForm 	= null;
					if($('#clientcontact-form').length ==  1)
						jForm = $('#clientcontact-form');													// AH:ubah
					else
						jForm = $('#clientaddress-form');													// AH:ubah

					var data	= jForm.serialize();
					$.ajax({
				    	type: 'POST',
					    url : jForm.attr('action'),
					   	data: data,
					   	dataType:'html',
						success:function(data) {
							if($(data).find('.errorSummary').length > 0) 
							{	
								//kalau error.
								$('#div-detail').html(data);
							}
							else {
								//kalau Sukses.
								$('#detail-dialog').dialog('close');

								if($('#clientcontact-form').length ==  1)			
									$.fn.yiiGridView.update('contactdetail-grid');
								else
									$.fn.yiiGridView.update('addressdetail-grid');
							}
		                },
					   	error: function(data) { // if error occured
					        alert('Error occured.please try again');
					        $('#div-detail').html(data);
					    },
					});
				}",
			'Cancel'=>'js:function(){$(this).dialog("close");}'
				),
			),
		));
		echo '<div id="div-detail"></div>';
		$this->endWidget('zii.widgets.jui.CJuiDialog'); 
	?>
	</fieldset>
	<?php endif;?>

	<div class="row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
