<?php
$this->breadcrumbs=array(
	'Reservations'=>array('index'),
	$model->reservations_id=>array('view','id'=>$model->reservations_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->reservations_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>