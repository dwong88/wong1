<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	$model->test_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->test_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->test_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'test_id',
		array('name'=>'test_date', 'type'=>'datetime'),
		array('name'=>'test_number', 'type'=>'number'),
	),
)); ?>
