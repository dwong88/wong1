<?php
$this->breadcrumbs=array(
    //'Room type features'=>array('index'),
    $qProperty['property_name'],
    $qProperty['room_type_name'],
	'Update',
	//$qProperty['room_type_name'],
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('/partner/property/index');
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'qProperty'=>$qProperty)); ?>