<?php
Helper::registerJsKarlwei();

Yii::app()->clientScript->registerScript('detail_js', "
$('.delete-detail').live('click', function(){
	$(this).parents('tr:first').remove();
});
$('#add-detail').click(function() {
	var jTableDtl = $('#table-detail');
	if(jTableDtl.find('.empty').length > 0) {
		jTableDtl.find('.empty').parents('tr').remove();
	}
	var jNewRow = $('#row-clone').clone();
	jNewRow.removeAttr('id');
	Karlwei.helper.date.registerTableDetailDateField(jNewRow.find('.dtl-date'));
	jTableDtl.find('tbody').append(jNewRow);
});
Karlwei.helper.date.registerTableDetailDateField($('.dtl-date'));
");

$htmlCurrency = CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd");
Helper::registerNumberField('#tnumber, .dtl-price');
?>

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
		<?php echo $form->textField($model,'test_number',array('size'=>10,'id'=>'tnumber','class'=>'col-right')); ?>
		<?php echo $form->error($model,'test_number'); ?>
	</div>
	
	<table id="table-detail" class="k-table-detail">
	<thead>
		<tr>
			<th class="button-column"><?php echo CHtml::link(CHtml::image('images/add.png', 'Tambah'), 'javascript://', array('id'=>'add-detail')); ?></th>
			<th>Date</th>
			<th>Currency</th>
			<th>Price</th>
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(!$model->isNewRecord) {
		foreach($mDetail as $detail) {
	?>
		<tr>
			<td class="button-column"><?php echo CHtml::link(CHtml::image('images/delete.png', 'Hapus Detail'), 'javascript://', array('class'=>'delete-detail', 'title'=>'Delete')); ?></td>
			<td><?php echo InputColumn::dateField($detail, 'receive_dt', array("class"=>"dtl-date", 'size'=>'10')); ?></td>
			<td><?php echo InputColumn::dropDownList($detail, 'currency_cd', $htmlCurrency, array('prompt'=>''))?></td>
			<td><?php echo InputColumn::textField($detail, 'price', array("class"=>"dtl-price col-right")); ?></td>
			<td><?php echo InputColumn::textField($detail, 'notes'); ?></td>
		</tr>
	<?php }
	} ?>
	</tbody>
	</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<table style="display: none;">
<tr id="row-clone">
	<td class="button-column"><a href="javascript://" title="Delete" class="delete-detail"><?php echo CHtml::image('images/delete.png', 'Hapus Detail');?></a></td>
	<td><input type="text" value="" maxlength="10" name="Testdetail[receive_dt][]" class="dtl-date" size="10"></td>
	<td><?php echo InputColumn::dropDownList(Testdetail::model() , 'currency_cd', $htmlCurrency, array('prompt'=>''))?></td>
	<td><input type="text" value="" maxlength="19" name="Testdetail[price][]" class="dtl-price col-right"></td>
	<td><input type="text" value="" name="Testdetail[notes][]"></td>
</tr>
</table>