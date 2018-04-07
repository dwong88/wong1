<?php
$this->breadcrumbs=array(
	'Room type features'=>array('index'),
	'Create',
	//$qProperty['room_type_name'],
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'qProperty'=>$qProperty)); ?>