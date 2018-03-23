<?php
$this->breadcrumbs=array(
	'SO'=>array('index'),
	$model->so_cd=>array('view','id'=>$model->so_cd),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view} {sendnotification}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->so_cd);
$buttonBar->sendnotificationUrl = array('sendnotif', 'so_cd'=>$model->so_cd);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'mDetail'=>$mDetail)); ?>