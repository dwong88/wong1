<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	$model->test_id=>array('view','id'=>$model->test_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->test_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'mDetail'=>$mDetail)); ?>