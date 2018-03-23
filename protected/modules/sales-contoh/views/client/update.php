<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->client_cd),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->client_cd);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', 
				array('model'=>$model,
					  'modelContact'=>$modelContact,
					  'modelAddress'=>$modelAddress)); ?>