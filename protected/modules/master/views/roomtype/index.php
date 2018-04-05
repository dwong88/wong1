<?php
$this->breadcrumbs=array(
	'Room type',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#roomtype-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	$('.search-form').hide();
	return false;
});
");
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{search} {create}');
$buttonBar->searchLinkHtmlOptions = array('id'=>'srcbutton');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.extensions.widget.GridView', array(
	'id'=>'roomtype-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'room_type_id',
		array('name'=>'refProperty.property_name', 'header'=>'Property'),
		'room_type_name',
		'room_type_desc',
		
		/*
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
		*/
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
