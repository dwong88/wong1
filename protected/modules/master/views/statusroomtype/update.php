<?php
$this->breadcrumbs=array(
	'Status room type'=>array('index'),
	$model->status_room_type_name=>array('view','id'=>$model->status_room_type_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->status_room_type_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>