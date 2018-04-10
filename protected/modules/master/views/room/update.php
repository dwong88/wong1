<?php
$this->breadcrumbs=array(
	'Room'=>array('index'),
	$model->room_name=>array('view','id'=>$model->room_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->room_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model,'modelroom'=>$modelroom,'mRoom'=>$mRoom)); ?>
