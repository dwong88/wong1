<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_name=>array('view','id'=>$model->user_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->user_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'employee'=>$employee)); ?>