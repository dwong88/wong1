<div class="form">

<script>
	$(document).ready(function()
	{
		$('.disc-type-radio').click(function()
	    {
	    	if($('.disc-type-radio').val() == 0)
	    	{
	    		$('#Sodetail_discount_value').val(0);
	    	}
			$('#td-disc-content').removeClass('td-disc0 td-disc1 td-disc2').addClass('td-disc'+this.value);
		});
	});
</script>
<style>
.td-disc0 #dis-val-content, .td-disc2 #dis-val-percent {display: none;}
#divdetail-itemdesc {width: 100%; height: 140px; overflow: auto;}
#detail-content {background-color: #ebebeb; padding: 5px;}
.selltax0 .selecttax {display: none;
}
</style>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'sodetail-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('onsubmit'=>'validateDetailForm(); return false;')
)); ?>

    <?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
    
    <?php Helper::showFlash(); ?>
    <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;" class="k-table-form">
    <tr>
    	<td style="width: 50%; border-bottom: 1px solid grey;">
    		<table cellpadding="0" cellspacing="0" border="0">
		    <tr>
		    	<td stlye="width: 100px;"><?php echo $form->labelEx($model,'Item'); ?></td>
		    	<td stlye="width: 5px;">:</td>
		    	<td>
		    		<?php $url = CHtml::normalizeUrl(array('/inventory/item/browseitem', 'callback'=>'handleItem')); ?>
		    		<?php echo $form->textField($model,'item_cd',array('size'=>10,'maxlength'=>50, 'readonly'=>'readonly', 'id'=>'ipt-item-cd')).' '.CHtml::link('browse', "javascript:popup('{$url}', 'winselect', 900, 900);"); ?>
		    		<?php echo $form->error($model,'item_cd'); ?>
		    	</td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->label($model,'item_name'); ?></td>
		    	<td>:</td>
		    	<td id="tddetail-itemname"><?php echo $model->item_name; ?></td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->label($model,'product_number'); ?></td>
		    	<td>:</td>
		    	<td id="tddetail-prodnumber"><?php echo $model->product_number; ?></td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->labelEx($model,'qty'); ?></td>
		    	<td>:</td>
		    	<td>
		    		<?php echo $form->textField($model,'qty',array('size'=>10,'maxlength'=>19, 'class'=>'col-right')); ?>
        			<?php echo $form->error($model,'qty'); ?>
		    	</td>
	    	</tr>
	    	</table>
    	</td>
    	<td style="vertical-align: top; border-bottom: 1px solid grey;">
    		<table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<tr>
				<td style="vertical-align: top; width: 100px;"><?php echo $form->label($model,'item_desc'); ?></td>
				<td style="vertical-align: top; width: 5px;">:</td>
				<td>
					<div id="divdetail-itemdesc"><?php echo nl2br($model->item_desc);?></div>
				</td>
			</tr>
			</table>
    	</td>
    </tr>
    <tr>
    	<td style="vertical-align: top; border-bottom: 1px solid grey;">
    		<table cellpadding="0" cellspacing="0" border="0">
		    <tr>
		    	<td stlye="width: 100px;"><?php echo $form->labelEx($model,'Vendor'); ?></td>
		    	<td stlye="width: 5px;">:</td>
		    	<td>
		    		<?php $url = CHtml::normalizeUrl(array('/purchasing/vendor/browsevendor', 'callback'=>'handleVendor')); ?>
		    		<?php echo $form->textField($model,'vendor_cd',array('size'=>10,'maxlength'=>50, 'readonly'=>'readonly', 'id'=>'ipt-vendor-cd')).' '.CHtml::link('browse', "javascript:popup('{$url}', 'winvendor', 900, 900);"); ?>
		    		<?php echo $form->error($model,'vendor_cd'); ?>
		    	</td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->label($model,'vendor_name'); ?></td>
		    	<td>:</td>
		    	<td id="tddetail-vendorname"><?php echo $model->vendor_name; ?></td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->labelEx($model,'cost'); ?></td>
		    	<td>:</td>
		    	<td>
				    <?php echo $form->dropDownList($model, 'cost_currency', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
				    <?php echo $form->textField($model,'cost_price',array('size'=>19,'maxlength'=>19, 'class'=>'col-right tnumber')); ?><span style="font-size: 10px; color:red">(sebelum pajak)</span>
        			<?php echo $form->error($model,'cost_currency'); ?>
        			<?php echo $form->error($model,'cost'); ?>
		    	</td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->labelEx($model,'Cost Tax 1'); ?></td>
		    	<td>:</td>
		    	<td>
      				<?php echo $form->dropDownList($model, 'cost_tax_cd1', CHtml::listData(Tax::model()->findAll(), "tax_cd", "tax_cd"), array('prompt'=>'')); ?>
        			<?php echo $form->error($model,'cost_tax_cd1'); ?>
		    	</td>
	    	</tr>
	    	<tr>
		    	<td><?php echo $form->labelEx($model,'Cost Tax 2'); ?></td>
		    	<td>:</td>
		    	<td>
      				<?php echo $form->dropDownList($model, 'cost_tax_cd2', CHtml::listData(Tax::model()->findAll(), "tax_cd", "tax_cd"), array('prompt'=>'')); ?>
        			<?php echo $form->error($model,'cost_tax_cd2'); ?>
		    	</td>
	    	</tr>
	    	</table>
    	</td>
    	<td style="vertical-align: top; border-bottom: 1px solid grey;">
    		<table cellpadding="0" cellspacing="0" border="0">
    		<tr>
    			<td colspan="3">&nbsp</td>
    		</tr>
    		<tr>
    			<td colspan="3">&nbsp</td>
    		</tr>
		    <tr>
		    	<td stlye="width: 100px;"><?php echo $form->labelEx($model,'sell_price'); ?></td>
		    	<td stlye="width: 5px;">:</td>
		    	<td>
		    		<?php echo $mSo->sell_currency; ?>
		    		<?php echo $form->textField($model,'sell_price',array('size'=>19,'maxlength'=>19, 'class'=>'col-right tnumber')); ?>
					<?php echo $form->error($model,'sell_price'); ?>
		    	</td>
	    	</tr>
	    	<tr class="selecttax">
		    	<td><?php echo $form->labelEx($model,'Sell Tax 1'); ?></td>
		    	<td>:</td>
		    	<td>
		    		<?php echo $form->dropDownList($model, 'sell_tax_cd1', CHtml::listData(Tax::model()->findAll(), "tax_cd", "tax_cd"), array('prompt'=>'')); ?>
        			<?php echo $form->error($model,'sell_tax_cd1'); ?>
		    	</td>
	    	</tr>
	    	<tr class="selecttax">
		    	<td><?php echo $form->labelEx($model,'Sell Tax 2'); ?></td>
		    	<td>:</td>
		    	<td>
		    		<?php echo $form->dropDownList($model, 'sell_tax_cd2', CHtml::listData(Tax::model()->findAll(), "tax_cd", "tax_cd"), array('prompt'=>'')); ?>
        			<?php echo $form->error($model,'sell_tax_cd2'); ?>
		    	</td>
	    	</tr>
	    	
	    	<tr>
				<td style="vertical-align:top"><?php echo $form->labelEx($model,'discount_type'); ?></td>
				<td style="vertical-align:top">:</td>
				<td id="td-disc-content" class="<?php echo 'td-disc'.$model->discount_type;?>">
					<?php echo $form->radioButtonList($model, 'discount_type', array('0'=>'None','1'=>'Percent','2'=>'Amount'), array('separator'=>'&nbsp;&nbsp;', 'class'=>'disc-type-radio', 'labelOptions'=>array('style'=>'display: inline; font-weight: normal;'))); ?>
					<?php echo $form->error($model,'discount_type'); ?>
					<div id="dis-val-content">
					
					<?php echo $form->textField($model,'discount_value',array('size'=>19,'maxlength'=>19,'class'=>'col-right tnumber')).' <span id="dis-val-percent">%</span>'; ?>
					<?php echo $form->error($model,'discount_value'); ?>
					 / item
					</div>
				</td>
			</tr>
	    	
	    	</table>
    	</td>
    </tr>
    <tr>
    	<td colspan="2">
    		<table cellpadding="0" cellspacing="0" border="0">
    		<tr>
	    		<td style="vertical-align: top; width: 100px;"><?php echo $form->labelEx($model,'notes'); ?></td>
		    	<td style="vertical-align: top; width: 5px;">:</td>
		    	<td>
		    		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
        			<?php echo $form->error($model,'notes'); ?>
		    	</td>
	    	</tr>
	    	</table>
    	</td>
    </tr>
    </table>
	
	<?php if($mSo->status == 1 || $mSo->status == 0) { ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
    <?php } ?>

<?php $this->endWidget(); ?>

</div><!-- form -->