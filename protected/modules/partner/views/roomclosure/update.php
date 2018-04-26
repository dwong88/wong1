<?php
$this->breadcrumbs=array(
	'Roomclosures'=>array('index'),
	$model->cl_id=>array('view','cl_id'=>$model->cl_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'cl_id'=>$model->cl_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_formup', array('model'=>$model)); ?>
