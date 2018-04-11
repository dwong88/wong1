<?php
$this->breadcrumbs=array(
	'Roomphototypes'=>array('index'),
	$model->roomphototype_id=>array('view','id'=>$model->roomphototype_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->roomphototype_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>