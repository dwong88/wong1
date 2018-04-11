<?php
$this->breadcrumbs=array(
	'Roomphotos'=>array('index'),
	$model->photo_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->photo_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->photo_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'photo_id',
		'room_id',
		'roomphototype_id',
		'filename',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
