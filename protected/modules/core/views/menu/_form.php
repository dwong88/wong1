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
	'id'=>'menu-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	
	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_id', CHtml::listData(Menu::model()->findAll(), 'menu_id', 'menu_name'),array('prompt'=>'Webroot')); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_name'); ?>
		<?php echo $form->textField($model,'menu_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'menu_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'default_url'); ?>
		<?php
			
				echo $form->textField($model,'default_url',array('size'=>60,'maxlength'=>100));
			
			/* IF YOU WANT COMBOBOX
			 $action_url 	= Menuaction::model()->findAll(array('condition'=>'menu_id=:menu_id','params'=>array(':menu_id'=>$model->menu_id)));
			$action_url 	= CHtml::listData($action_url,'action_url', 'action_url');
			echo $form->dropDownList($model, 'default_url', $action_url, array('prompt'=>'-- Choose Default Url --'));
			 */
			
		?>
		<?php echo $form->error($model,'default_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_order'); ?>
		<?php echo $form->textField($model,'menu_order'); ?>
		<?php echo $form->error($model,'menu_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->checkBox($model, 'is_active').' Yes'; ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php 
if(!$model->isNewRecord) 
{
	$ajaxformcreate = CHtml::normalizeUrl(array('menuaction/create', 'id'=>$model->menu_id));
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
		'id'=>'menuaction-grid',
		'dataProvider'=>$mDetail->search(),
		'filter'=>$mDetail,
		'filterPosition'=>'',
		'columns'=>array(
			'menuaction_id',
			'action_url',
			'group_name',
			'menuaction_desc',
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update} {delete}',
				'updateButtonUrl'=>'CHtml::normalizeUrl(array("menuaction/update", "id"=>$data->primaryKey))',			// AH : ubah
				'deleteButtonUrl'=>'CHtml::normalizeUrl(array("menuaction/delete", "id"=>$data->primaryKey))',			// AH : ubah
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
		        'width'=>850,
		        'autoOpen'=>false,
		        'modal'=>true,
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
						var jForm 	= $('#menuaction-form');													// AH:ubah
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
									Karlwei.helper.date.registerTableDetailDateField($('#div-detail').find('.dtl-date'));
									$('#div-detail').find('.tnumber').trigger('blur');
								}
								else {
									//kalau Sukses.
									$('#detail-dialog').dialog('close');
									$.fn.yiiGridView.update('menuaction-grid');
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