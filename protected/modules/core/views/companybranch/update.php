<?php
$this->breadcrumbs=array(
	'Company Branch'=>array('index'),
	$model->branch_name=>array('view','id'=>$model->companybranch_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->companybranch_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>