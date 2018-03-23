<?php 
	$url = $this->createUrl('ajxvalidatedetail');
?>
<style>
	.txtarea_received_notes
	{
		resize:none;
		min-height:50px;
		min-width:100px;
	}
</style>
<form action="<?php echo $url; ?>" id="soreturdetail-form">
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'soreturdetail-grid',
		'dataProvider'=>$model->searchSoreturUpdate($soretur_cd),
		'filterPosition'=>'',
		'columns'=>array(
			'item_cd',
			'item.item_name',
			'item.itemtype_name',
			'item.product_number',	
			array('name'=>'Item Description','type'=>'raw','htmlOptions'=>array('width'=>'25%'),'value'=>'nl2br($data->item->item_desc)'),	
			array('header'=>'Qty','name'=>'qty','type'=>'number'),
			array('header'=>'Qty Retur','name'=>'qty_retur','type'=>'number'),
			array('header'=>'Qty Retur Now','type'=>'raw',
				  'value'=>'CHtml::decode(" <input type=\'text\' class=\'tnumber qty_retur\'
				  								name=\'qty_retur[]\' 
				  								size=\'10\' maxlength=\'10\' value=\'$data->qty_retur_now\'/>
				  							<input type=\'hidden\' name=\'item_cd[]\' value=\'$data->item_cd\'/>
				  							<div class=\'errorMessage error-detail\'></div>")',
			   	  'htmlOptions'=>array('width'=>'20px'),
			),
			array('header'=>'Notes','type'=>'raw',
							  'value'=>'CHtml::decode("<textarea class=\'txtarea_received_notes\' 
														name=\'received_notes[]\'>$data->received_notes</textarea>")',
			)
		),
	));
	
	echo CHtml::submitButton('Update detail',array('id'=>'uptDetail'));
?>
</form>