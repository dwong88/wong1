<?php
$this->breadcrumbs=array(
	'Religion'=>array('index'),
	$model->mastertype_code=>array('view','id'=>$model->mastertype_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->mastertype_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>