<hr/>
<h3>Item Detail</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'itemdetail-grid',
	'dataProvider'=>$model->search(),
	'filterPosition'=>'',
	'columns'=>array(
		//'item.item_name',
		array('name'=>'Item Name','value'=>'$data->item->item_name','htmlOptions'=>array('width'=>'20%')),
		array('name'=>'Item Type Name','value'=>'$data->item->itemtype_name','htmlOptions'=>array('width'=>'10%')),
		//'item.itemtype_name',
		array('name'=>'Item Description','value'=>'nl2br($data->item->item_desc)','htmlOptions'=>array('width'=>'35%'),'type'=>'raw'),
		//'qty',
		array('name'=>'Qty', 'value'=>'$data->qty','type'=>'number','htmlOptions'=>array('class'=>'col-right')),
		array('name'=>'Total Price', 'value'=>'number_format($data->total_price,2,".",",")', 'htmlOptions'=>array('class'=>'col-right')),
		'notes'
	),
)); ?>