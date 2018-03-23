<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'so-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
echo $form->hiddenField($model, 'so_status_temp', array('id'=>'so-status-temp'));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	
	
	<table cellpadding="0" cellspacing="0" border="0" style="width: 50%" class="k-table-form">
	<tr>
		<td><?php echo $form->labelEx($model,'so_cd'); ?></td>
		<td>:</td>
		<td>
			<?php if($model->total_titipan == 0)
				{
				?>
		       	<?php echo $form->dropDownList($model, 'so_cd', CHtml::listData(So::model()->findAll("total_titipan = 0"), "so_cd", "so_cd"), array('prompt'=>'')); ?>
				<?php echo $form->error($model,'so_cd'); ?>
			<?php }else{ ?>
				<?php echo $model->so_cd; ?>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td><?php echo $form->labelEx($model,'total_titipan'); ?></td>
		<td>:</td>
		<td>
	        <?php echo $form->dropDownList($model, 'titipan_currency', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
			<?php echo $form->textField($model,'total_titipan',array('size'=>19,'maxlength'=>19, 'class'=>'col-right tnumber')); ?>
			<?php echo $form->error($model,'total_titipan'); ?>
		</td>
	</tr>
	</table>

	<div class="row buttons">
		<?php
			echo CHtml::submitButton('Save');
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->