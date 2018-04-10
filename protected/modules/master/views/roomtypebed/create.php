<?php
$this->breadcrumbs=array(
	'Room type bed'=>array('index'),
	'Create & Update',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>
<?php $this->renderPartial('_form', array('model'=>$model,'mBed'=>$mBed)); ?>
