<?php
$this->breadcrumbs=array(
	'Basepricerooms'=>array('index'),
	$model->room_type_id=>array('view','id'=>$model->room_type_id),
	'Update',
);

/*$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->room_type_id);
$buttonBar->render();*/
?>

<?php $this->renderPartial('_form', array('model'=>$model,'mRoomtype'=>$mRoomtype)); ?>
