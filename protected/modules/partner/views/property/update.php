<?php
$this->breadcrumbs=array(
	'Properties'=>array('index'),
	$model->property_id=>array('view','id'=>$model->property_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->property_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_formupdate', array('model'=>$model,'models'=>$models,'modeldesc'=>$modeldesc)); ?>
