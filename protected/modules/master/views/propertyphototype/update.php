<?php
$this->breadcrumbs=array(
	'Propertyphototypes'=>array('index'),
	$model->propertyphototype_id=>array('view','id'=>$model->propertyphototype_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->propertyphototype_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>