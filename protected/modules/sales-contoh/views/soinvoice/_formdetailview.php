<hr/>
<h3>DO-Detail</h3>

<div id="err-adddodetail"></div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dodetail-grid',
	'dataProvider'=>$model->search(),
	'filterPosition'=>'',
	'columns'=>array(
		'do_cd',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'viewButtonUrl'=>'CHtml::normalizeUrl(array("soinvoice/viewdetail", "id"=>$data->primaryKey))',			// AH : change
			'deleteButtonUrl'=>'CHtml::normalizeUrl(array("soinvoice/deletedetail", "id"=>$data->primaryKey))',		// AH : change
			'afterDelete'=>'function(link,success,data){ if(success) 
				{
					$.fn.yiiGridView.update("itemdetail-grid");
					$("#grand_total").html(data);
					$("#hidden_grandtotal").val(data);
				} 
			}',				// AH : optional to create depedeny to another grid 
			'buttons'=>array(
				'update'=> array('visible'=>'false'),
				'view'=>array('options'=>array('class'=>'viewdetail'),'visible'=>'false'),
				'delete'=>array('visible'=>'false')
			),
		),
	),
)); ?>




