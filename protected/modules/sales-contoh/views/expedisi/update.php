<?php
$this->breadcrumbs=array(
	'Expedisis'=>array('index'),
	$model->expedisi_cd=>array('view','id'=>$model->expedisi_cd),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->expedisi_cd);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>