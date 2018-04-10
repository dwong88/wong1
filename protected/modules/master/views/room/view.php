<?php
$this->breadcrumbs=array(
	'Room'=>array('index'),
	$model->room_name,
);
?>

<?php Helper::showFlash(); ?>
<?php
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->room_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->room_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'room_id',
		array('name'=>'roomtype','value'=>$model->refRoomtype->room_type_name),
		'room_floor',
		'room_name',
		'room_status',
		array('name'=>'create_dt', 'type'=>'datetime'),
        array('name'=>'create_by','value'=>$model->refUserupdate->user_name),
        array('name'=>'update_dt', 'type'=>'datetime'),
        array('name'=>'update_by','value'=>$model->refUserupdate->user_name)
	),
)); ?>
