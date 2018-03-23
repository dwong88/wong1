<?php
$this->breadcrumbs=array(
	'Menuactions'=>array('index'),
	$model->menuaction_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->menuaction_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->menuaction_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'menuaction_id',
		'menu_id',
		'menuaction_desc',
		'action_url',
		'group_id',
	),
)); ?>
