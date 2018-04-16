<?php
$this->breadcrumbs=array(
	'Temproomprices'=>array('index'),
	$model->random_id=>array('view','id'=>$model->random_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->random_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>