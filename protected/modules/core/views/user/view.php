<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_name,
);
?>

<?php Helper::showFlash(); ?>

<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->user_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'user_name',
		'user_type',
		array('label'=>'Is Active', 'value'=>(($model->is_active=="1")? "Yes" : "No")),
	),
)); ?>
