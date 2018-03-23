<?php
$this->breadcrumbs=array(
	'Patterns'=>array('index'),
	$model->pattern_id=>array('view','id'=>$model->pattern_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->pattern_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>