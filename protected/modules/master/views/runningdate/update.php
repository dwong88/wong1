<?php
$this->breadcrumbs=array(
	'Runningdates'=>array('index'),
	$model->runningdate=>array('view','id'=>$model->runningdate),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->runningdate);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>