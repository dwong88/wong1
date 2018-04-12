<?php
$this->breadcrumbs=array(
	'Basepricerooms'=>array('index'),
	$model->basepriceroom_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->basepriceroom_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->basepriceroom_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'basepriceroom_id',
		'room_id',
		'hours',
		'price',
	),
)); ?>
