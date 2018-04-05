<?php
$this->breadcrumbs=array(
	'Properties'=>array('index'),
	$model->property_id,
);
?>

<?php Helper::showFlash(); ?>
<?php
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->property_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->property_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'property_id',
		'property_name',
		'addressline1',
		'addressline2',
		'city_id',
		'postal_code',
		'suburb',
		'country_id',
		'state_id',
		'weekend_start',
		'hotel_phone_number',
		'phone_number',
		'tax_number',
		'minimumroomrate',
		'star_rated',
		'numberofstar',
		'maximumchildage',
		'maximuminfantage',
		'bookingconfirmationemail',
		'bookingconfirmationccemail',
		'enquiryemail',
		'availabilityalertemail',
		'description',
		'gmaps_longitude',
		'gmaps_latitude',
		'available_cleaning_start',
		'available_cleaning_end',
		'locationinstruction',
		array('name'=>'refUsercreate.user_name', 'header'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'refUserupdate.user_name', 'header'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
