<?php
$this->breadcrumbs=array(
	'Room type bed'=>array('index'),
	$model->room_type_bed_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->room_type_bed_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->room_type_bed_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'room_type_bed_id',
		array('name'=>'roomtype','value'=>$model->refRoomtype->room_type_name),
		array('name'=>'masterbed','value'=>$model->refMasterbed->master_bed_name),
		'room_type_bed_quantity_room',
	),
)); ?>
