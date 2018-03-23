<?php
$this->breadcrumbs=array(
	'Patterns'=>array('index'),
	$model->pattern_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->pattern_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->pattern_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pattern_id',
		'pattern_group',
		'pattern_sub',
		'pattern_length',
		'pattern_value',
		'increment',
		'pattern_order',
	),
)); ?>
