<?php
$this->breadcrumbs=array(
	'Roomclosures'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->id);
$buttonBar->render();
?>

<?php $this->renderPartial('_formup', array('model'=>$model)); ?>
