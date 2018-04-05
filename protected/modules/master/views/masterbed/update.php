<?php
$this->breadcrumbs=array(
	'Master bed'=>array('index'),
	$model->master_bed_name=>array('view','id'=>$model->master_bed_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->master_bed_id);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>