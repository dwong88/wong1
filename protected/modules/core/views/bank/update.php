<?php
$this->breadcrumbs=array(
	'Bank'=>array('index'),
	$model->bank_cd=>array('view','id'=>$model->bank_cd),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->bank_cd);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>