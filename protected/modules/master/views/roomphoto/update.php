<?php
$this->breadcrumbs=array(
	'Roomphotos'=>array('index'),
	$model->photo_id=>array('view','id'=>$model->photo_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->photo_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>