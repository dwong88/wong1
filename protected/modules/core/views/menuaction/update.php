<?php
$this->breadcrumbs=array(
	'Menuactions'=>array('index'),
	$model->menuaction_id=>array('view','id'=>$model->menuaction_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->menuaction_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>