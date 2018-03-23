<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'item-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'filterPosition'=>'',
		'columns'=>array(
			'item.item_name',
			'item.item_desc',
			'item.itemtype_name',
			'qty',
			'sell_price',
			'total_sell_price',
		),
	));
?>



