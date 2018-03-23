<?php
$this->breadcrumbs=array(
	'Usergroups'=>array('index'),
	$model->usergroup_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->usergroup_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->usergroup_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'usergroup_id',
		'usergroup_name',
	),
)); ?>
