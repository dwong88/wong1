<?php
$this->breadcrumbs=array(
	'Reservations'=>array('index'),
	$model->reservations_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->reservations_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->reservations_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'reservations_id',
		'customer_name',
		'start_date',
		'end_date',
		'status',
		'paid',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
