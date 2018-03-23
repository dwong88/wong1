<?php
$this->breadcrumbs=array(
	'SO',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('so-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{search}');
$buttonBar->searchLinkHtmlOptions = array('id'=>'srcbutton');
$buttonBar->render();
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'so-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'summaryText'=>'Total: {count}',
	'columns'=>array(
		'so_cd',
		array('name'=>'client.client_name', 'header'=>'Client Name'),
		array('name'=>'est_delivery_dt', 'type'=>'date'),
		array('name'=>'status','value'=>'Status::$so_status[$data->status]'),
		array('name'=>'delivery_status','value'=>'Status::$depedency_status[$data->delivery_status]'),
		array('name'=>'purchase_status','value'=>'Status::$depedency_status[$data->purchase_status]'),
		array('name'=>'invoice_status','value'=>'Status::$depedency_status[$data->invoice_status]'),
		array('name'=>'payment_status','value'=>'Status::$depedency_status[$data->payment_status]'),
		array('name'=>'is_indent','value'=>'Status::$is_status[$data->is_indent]'),
		array('name'=>'update_dt', 'type'=>'datetime'),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('style'=>'text-align:left'),
			'buttons'=>array(
				'update'=> array( 'visible' => 'false' ),
				//'update' => array( 'visible' => '$data->isCanDeletedOrModified("status")' ),
				'delete' => array( 'visible' => 'false' ),
			)
		),
	),
)); ?>
