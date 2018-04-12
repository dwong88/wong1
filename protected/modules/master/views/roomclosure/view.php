<?php
$this->breadcrumbs=array(
	'Roomclosures'=>array('index'),
	$model->id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'room_id',
		'start_date',
		'end_date',
		'status',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
