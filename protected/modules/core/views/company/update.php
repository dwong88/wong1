<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->company_id=>array('view','id'=>$model->company_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->company_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>