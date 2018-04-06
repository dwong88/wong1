<?php
$this->breadcrumbs=array(
    'Property'=>array('/partner/property/index'),
    'Room Type',
	$model->room_type_name,
	'Update',
);

$buttonBar = new ButtonBar('{list} {create}');
$buttonBar->listUrl = array('/partner/property/index');
$buttonBar->createUrl = array('/master/roomtype/create', 'id'=>$mProperty->property_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'mProperty'=>$mProperty)); ?>