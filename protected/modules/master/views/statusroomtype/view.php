<?php
$this->breadcrumbs=array(
	'Status room type'=>array('index'),
	$model->status_room_type_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->status_room_type_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->status_room_type_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'status_room_type_id',
		'status_room_type_name',
	),
)); ?>
