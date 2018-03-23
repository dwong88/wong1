<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sodetail-grid',
	'dataProvider'=>$model->search(),
	'filterPosition'=>'',
	'columns'=>array(
		'so_cd',
		//array('header'=>'Item Name','value'=>'item.item_name'),
		'discount_type',
		'discount_value',
	),
)); ?>