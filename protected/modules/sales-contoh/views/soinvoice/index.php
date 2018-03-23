<?php
$this->breadcrumbs=array(
	'Soinvoices',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('soinvoice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{search} {create}');
$buttonBar->searchLinkHtmlOptions = array('id'=>'srcbutton');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'soinvoice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'soinvoice_cd',
		'so_cd',
		array('header'=>'Client Name','name'=>'client.client_name'),
		//'client_cd',
		array('name'=>'status','value'=>'Status::$core_status[$data->status]'),
		array('name'=>'payment_status','value'=>'Status::$depedency_status[$data->payment_status]'),
		array('name'=>'update_dt', 'type'=>'datetime'),
		/*
		'due_date',
		'payment_percent',
		'payment_amount',
		'currency_cd',
		'currency_kurs',
		'tax_kurs',
		'discount_type',
		'discount_value',
		'subtotal_price',
		'subtotal_tax',
		'grandtotal_price',
		'used_dp',
		'is_tax',
		'is_down_payment',
		'status',
		'payment_status',
		'notes',
		'create_by',
		'create_dt',
		'update_by',
		'update_dt',
		*/
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('style'=>'text-align:left'),
			'buttons'=>array(
				'update' => array( 'visible' => '$data->isCanDeletedOrModified("status")' ),
				'delete' => array( 'visible' => '$data->isCanDeletedOrModified("status")' ),
			)
		),
	),
)); ?>
