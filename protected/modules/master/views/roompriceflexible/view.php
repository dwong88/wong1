<?php
$this->breadcrumbs=array(
	'Roompriceflexibles'=>array('index'),
	$model->price_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->price_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->price_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'price_id',
		'room_type_id',
		'date',
		'hours',
		'price',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
