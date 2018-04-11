<?php
$this->breadcrumbs=array(
	'Promosis'=>array('index'),
	$model->promosi_id=>array('view','id'=>$model->promosi_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->promosi_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>