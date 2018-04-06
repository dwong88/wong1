<?php
$this->breadcrumbs=array(
	'Property'=>array('/partner/property/index'),
	'Room Type',
	'Create',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('/partner/property/index');
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'mProperty'=>$mProperty)); ?>