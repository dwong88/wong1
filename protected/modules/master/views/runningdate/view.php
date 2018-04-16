<?php
$this->breadcrumbs=array(
	'Runningdates'=>array('index'),
	$model->runningdate,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->runningdate);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->runningdate),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'runningdate',
	),
)); ?>
