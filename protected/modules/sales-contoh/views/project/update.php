<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->project_name=>array('view','id'=>$model->project_name),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->project_name);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>