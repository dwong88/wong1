<?php
$this->breadcrumbs=array(
	'Room type features'=>array('index'),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>