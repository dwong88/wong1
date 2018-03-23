<div class="grid-popup">
	<center><h3>List Item</h3></center>
	<?php 
		$form = $this->beginWidget('CActiveForm', array(
				'id'=>'item-popup',
				'action'=>array('#'),
				'enableAjaxValidation'=>true,
		));
		
		$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'item-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'filterPosition'=>'',
			'columns'=>array(
				'item.item_name',
				'item.itemtype_name',
				'qty'
				//'item.item_desc',
				//'item.product_number',
				//'item.project_name',
			),
		));
	
		$this->endWidget();
	?>
</div>