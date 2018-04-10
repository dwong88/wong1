<?php
$this->breadcrumbs=array(
	'City'=>array('index'),
	$model->city_name=>array('view','id'=>$model->city_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->city_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model,'mState'=>$mState)); ?>
