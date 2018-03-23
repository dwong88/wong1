<?php
$this->breadcrumbs=array(
	'Usergroups'=>array('index'),
	$model->usergroup_id=>array('view','id'=>$model->usergroup_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->usergroup_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>