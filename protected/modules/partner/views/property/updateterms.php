<?php
$this->breadcrumbs=array(
	'Properties'=>array('index'),
	$model->propertyid=>array('view','id'=>$model->propertyid),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->propertyid);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>