<?php
$this->breadcrumbs=array(
	'Mspropertyfeatures'=>array('index'),
	$model->prop_features_id=>array('view','id'=>$model->prop_features_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->prop_features_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>