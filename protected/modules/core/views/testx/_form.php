<?php
	Helper::registerJsKarlwei(); 
	Helper::registerNumberField('.tnumber'); 
?>

<script>
function editDetail(oLink)
{
	var jDetailDialog = $('#detail-dialog');
	jDetailDialog.data('url', oLink.href);
	jDetailDialog.dialog('open');
	return false;
}
</script>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'test-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	<div class="row">
		<?php echo $form->labelEx($model,'test_date'); ?>
		<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'test_date',
		                                ));?>
		<?php echo $form->error($model,'test_date'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'test_number'); ?>
		<?php echo $form->textField($model,'test_number',array('size'=>10,'class'=>'col-right tnumber')); ?>
		<?php echo $form->error($model,'test_number'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<hr />
<?php 
if(!$model->isNewRecord) {
	$ajaxformcreate = CHtml::normalizeUrl(array('testdetail/create', 'id'=>$model->test_id));
	Yii::app()->clientScript->registerScript('detail_js', "
		$('#add-detail').click(function() {
			var jDetailDialog = $('#detail-dialog');
			jDetailDialog.data('url','{$ajaxformcreate}');
			jDetailDialog.dialog('open');
			return false;
		});
	");
	echo CHtml::link('Add Detail', 'javascript://', array('id'=>'add-detail'));
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'testdetail-grid',
		'dataProvider'=>$mDetail->search(),
		'filter'=>$mDetail,
		'filterPosition'=>'',
		'columns'=>array(
			array('name'=>'receive_dt', 'type'=>'date'),
			array('name'=>'currency_cd', 'type'=>'text'),
			array('name'=>'price', 'type'=>'number', 'htmlOptions'=>array('class'=>'col-right')),
			array('name'=>'notes', 'type'=>'text'),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update} {delete}',
				'updateButtonUrl'=>'CHtml::normalizeUrl(array("testdetail/update", "id"=>$data->primaryKey))',
				'deleteButtonUrl'=>'CHtml::normalizeUrl(array("testdetail/delete", "id"=>$data->primaryKey))',
				'updateButtonOptions'=>array(
					'class'=>'update',
					'onclick'=>'editDetail(this); return false;',
				),
			),
		),
	));
	
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'detail-dialog',
		    'options'=>array(
		        'title'=>'Dialog',
		        'width'=>500,
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
								var jDate = $('#div-detail').find('.dtl-date');
								Karlwei.helper.date.registerTableDetailDateField(jDate);
								$('#div-detail').find('.tnumber').trigger('blur');
								jDate.focus();
							},
						});
						jThis.data('url', ''); 
					}
				}",
				'buttons'=>array(
					'Submit'=>"js:function(){
						var jForm = $('#testdetail-form');
						var data=jForm.serialize();
						$.ajax({
					    	type: 'POST',
						    url: jForm.attr('action'),
						   	data: data,
						   	dataType:'html',
							success:function(data) {
								if($(data).find('.errorSummary').length > 0) 
								{	
									//kalau error.
									$('#div-detail').html(data);
									Karlwei.helper.date.registerTableDetailDateField($('#div-detail').find('.dtl-date'));
									$('#div-detail').find('.tnumber').trigger('blur');
								}
								else {
									//kalau Sukses.
									$('#detail-dialog').dialog('close');
									$.fn.yiiGridView.update('testdetail-grid');
								}
			                },
						   	error: function(data) { // if error occured
						        alert('Error occured.please try again');
						        $('#div-detail').html(data);
						        Karlwei.helper.date.registerTableDetailDateField($('#div-detail').find('.dtl-date'));
						    },
						});
					}",
					'Cancel'=>'js:function(){$(this).dialog("close");}'
				),
			),
	));
	echo '<div id="div-detail"></div>';
	$this->endWidget('zii.widgets.jui.CJuiDialog');
}
?>