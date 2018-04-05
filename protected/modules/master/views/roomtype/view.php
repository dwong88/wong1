<?php
$this->breadcrumbs=array(
	'Room type'=>array('index'),
	$model->room_type_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->room_type_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->room_type_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'room_type_id',
		array('name'=>'refProperty.property_name', 'header'=>'Property'),
		'room_type_name',
		'room_type_desc',
		array('name'=>'create_dt', 'type'=>'datetime'),
        array('name'=>'create_by','value'=>$model->refUserupdate->user_name),
        array('name'=>'update_dt', 'type'=>'datetime'),
        array('name'=>'update_by','value'=>$model->refUserupdate->user_name),
		'room_type_cleaning_minutes',
		'room_type_availability_threshold',
		'room_type_minimum_availability_threshold',
		'room_type_default_minimum_stay',
		'room_type_default_maximum_stay',
		'room_type_rack_rate',
		'room_type_default_extra_child_rate',
		'room_type_default_extra_adult_rate',
		'room_type_default_infant_rate',
		'room_type_included_occupants',
		'room_type_maximum_occupants',
		'room_type_adult_required',
		'room_type_room_size',
		'room_type_bed_size',
		'room_type_guest_capacity',
		'room_type_total_room',
	),
)); ?>
